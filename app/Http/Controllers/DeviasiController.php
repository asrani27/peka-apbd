<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Deviasi;
use Illuminate\Http\Request;
use App\Models\DeviasiDetail;
use App\Imports\DeviasiImport;
use App\Exports\DeviasiDetailExport;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class DeviasiController extends Controller
{
    public function tarikdata($kode_skpd, $tahun)
    {
        $url = "https://kenangan.banjarmasinkota.go.id/api/rfk/{$kode_skpd}/{$tahun}";

        // Ambil data dari API eksternal
        $response = Http::timeout(30)->get($url);

        if ($response->failed()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data dari server eksternal.'
            ], 500);
        }

        $jsonData = $response->json();

        // Daftar bulan berurutan
        $bulanList = [
            'januari',
            'februari',
            'maret',
            'april',
            'mei',
            'juni',
            'juli',
            'agustus',
            'september',
            'oktober',
            'november',
            'desember'
        ];

        foreach ($bulanList as $namaBulan) {

            if (!isset($jsonData[$namaBulan])) {
                continue; // skip jika tidak ada datanya
            }

            $item = $jsonData[$namaBulan];

            // Rencana
            $r51 = $item['rencana']['5.1'] ?? 0;
            $r52 = $item['rencana']['5.2'] ?? 0;
            $r53 = $item['rencana']['5.3'] ?? 0;
            $r54 = $item['rencana']['5.4'] ?? 0;

            // Realisasi
            $re51 = $item['realisasi']['5.1'] ?? 0;
            $re52 = $item['realisasi']['5.2'] ?? 0;
            $re53 = $item['realisasi']['5.3'] ?? 0;
            $re54 = $item['realisasi']['5.4'] ?? 0;

            // Simpan ke DeviasiDetail
            DeviasiDetail::updateOrCreate(
                [
                    'skpd_id' => Skpd::where('kode', $kode_skpd)->first()->id,
                    'tahun'   => $tahun,
                    'bulan'   => ucfirst($namaBulan) // contoh: Januari, Februari
                ],
                [
                    'kolom_c' => $r51,
                    'kolom_d' => $r52,
                    'kolom_e' => $r53,
                    'kolom_f' => $r54,

                    'kolom_g' => $re51,
                    'kolom_h' => $re52,
                    'kolom_i' => $re53,
                    'kolom_j' => $re54,
                ]
            );
        }
        Session::flash('success', 'Berhasil ditarik');
        return back();
    }

    public function index()
    {
        $data = Deviasi::join('skpd', 'deviasi.skpd_id', '=', 'skpd.id')
            ->orderBy('skpd.kode', 'ASC')
            ->select('deviasi.*')
            ->get();
        return view('superadmin.ikpa.deviasi.index', compact('data'));
    }

    public function insertAllSkpd2025()
    {
        DB::beginTransaction();
        try {
            $tahun = 2025;
            $skpdList = Skpd::all();
            $insertedCount = 0;

            foreach ($skpdList as $skpd) {
                // Check if deviasi data already exists for this SKPD and tahun
                $existing = Deviasi::where('skpd_id', $skpd->id)
                    ->where('tahun', $tahun)
                    ->first();

                if (!$existing) {
                    // Create new deviasi record
                    $newDeviasi = new Deviasi();
                    $newDeviasi->skpd_id = $skpd->id;
                    $newDeviasi->tahun = $tahun;
                    $newDeviasi->save();

                    // Create 12 months of deviasi detail records with default values
                    $bulanList = [
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    ];

                    foreach ($bulanList as $bulan) {
                        $newDetail = new DeviasiDetail();
                        $newDetail->deviasi_id = $newDeviasi->id;
                        $newDetail->skpd_id = $skpd->id;
                        $newDetail->tahun = $tahun;
                        $newDetail->bulan = $bulan;
                        $newDetail->kolom_c = 0;
                        $newDetail->kolom_d = 0;
                        $newDetail->kolom_e = 0;
                        $newDetail->kolom_f = 0;
                        $newDetail->kolom_g = 0;
                        $newDetail->kolom_h = 0;
                        $newDetail->kolom_i = 0;
                        $newDetail->kolom_j = 0;
                        $newDetail->save();
                    }

                    $insertedCount++;
                }
            }

            DB::commit();
            Session::flash('success', "Berhasil menambahkan data deviasi untuk {$insertedCount} SKPD tahun {$tahun}");
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Gagal menambahkan data: ' . $e->getMessage());
            return back();
        }
    }
    public function detail($id)
    {
        $data = Deviasi::with(['skpd', 'detail' => function($query) {
            $query->orderBy('id', 'asc');
        }])->find($id);
        
        if (!$data) {
            abort(404);
        }

        // Pre-compute all values to avoid N+1 queries
        $details = $data->detail;
        $cumulativeData = [];
        
        // Pre-compute proporsi pagu values once
        $proporsiPagu = [
            'RAK51' => $data->proporsiPaguRAK51(),
            'RAK52' => $data->proporsiPaguRAK52(),
            'RAK53' => $data->proporsiPaguRAK53(),
            'RAK54' => $data->proporsiPaguRAK54(),
            'Total' => $data->totalProporsiPagu(),
        ];
        
        foreach ($details as $index => $detail) {
            // Get all details up to current index for cumulative calculations
            $previousDetails = $details->slice(0, $index + 1);
            
            $cumulativeData[$detail->id] = [
                'deviasi_51' => $detail->deviasi51(),
                'deviasi_52' => $detail->deviasi52(),
                'deviasi_53' => $detail->deviasi53(),
                'deviasi_54' => $detail->deviasi54(),
                'koreksi_51' => $detail->koreksi51(),
                'koreksi_52' => $detail->koreksi52(),
                'koreksi_53' => $detail->koreksi53(),
                'koreksi_54' => $detail->koreksi54(),
                'deviasi_tertimbang_51' => $detail->deviasiTertimbang51(),
                'deviasi_tertimbang_52' => $detail->deviasiTertimbang52(),
                'deviasi_tertimbang_53' => $detail->deviasiTertimbang53(),
                'deviasi_tertimbang_54' => $detail->deviasiTertimbang54(),
                'seluruh_deviasi' => $detail->seluruhDeviasi(),
                'akumulasi_deviasi' => $previousDetails->sum(function($item) {
                    return $item->seluruhDeviasi();
                }),
                'deviasi_rata_rata' => 0, // Will be calculated below
                'nilai_ikpa' => 0, // Will be calculated below
            ];
            
            // Calculate deviasi rata-rata
            $bulanAngka = $detail->bulanKeAngka($detail->bulan);
            $cumulativeData[$detail->id]['deviasi_rata_rata'] = $bulanAngka > 0 
                ? ($cumulativeData[$detail->id]['akumulasi_deviasi'] / $bulanAngka) 
                : 0;
            
            // Calculate nilai IKPA
            $deviasiRataRata = $cumulativeData[$detail->id]['deviasi_rata_rata'];
            $cumulativeData[$detail->id]['nilai_ikpa'] = ($deviasiRataRata <= 15) ? 100 : (100 - $deviasiRataRata);
        }
        
        // Pre-compute totals for summary row
        $totals = [
            'kolom_c' => $details->sum('kolom_c'),
            'kolom_d' => $details->sum('kolom_d'),
            'kolom_e' => $details->sum('kolom_e'),
            'kolom_f' => $details->sum('kolom_f'),
            'kolom_g' => $details->sum('kolom_g'),
            'kolom_h' => $details->sum('kolom_h'),
            'kolom_i' => $details->sum('kolom_i'),
            'kolom_j' => $details->sum('kolom_j'),
        ];
        
        // Pre-compute total pagu
        $totalPagu = $data->totalPagu();
        
        return view('superadmin.ikpa.deviasi.detail', compact('data', 'cumulativeData', 'totals', 'proporsiPagu', 'totalPagu'));
    }

    public function exportExcel($id)
    {
        $data = Deviasi::find($id);
        if (!$data) {
            abort(404);
        }

        $filename = 'deviasi_dpa_' . str_replace(' ', '_', strtolower($data->skpd->nama)) . '_' . $data->tahun . '.xlsx';
        
        return Excel::download(new DeviasiDetailExport($id), $filename);
    }
    public function add()
    {
        return view('superadmin.ikpa.deviasi.create');
    }
    public function edit($id)
    {
        $data = Deviasi::find($id);
        return view('superadmin.ikpa.deviasi.edit', compact('data'));
    }
    public function delete($id)
    {
        $data = Deviasi::find($id)->delete();
        Session::flash('success', 'Berhasil Dihapus');
        return back();
    }
    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {

            $deviasi = Deviasi::find($id);
            if ($deviasi) {
                $deviasi->detail()->delete(); // Menghapus semua detail yang terkait
            }

            Excel::import(new DeviasiImport($req->tahun, $req->skpd_id, $deviasi), $req->file);

            DB::commit(); // Jika semua operasi berhasil, commit transaksi

            Session::flash('success', 'Berhasil Diupdate');
            return redirect('/superadmin/ikpa/deviasi');
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, rollback transaksi
            Session::flash('error', $e->getMessage());
            return back();
        }
    }
    public function store(Request $req)
    {
        $check = Deviasi::where('skpd_id', $req->skpd_id)->where('tahun', $req->tahun)->first();
        if ($req->file == null) {
            if ($check == null) {
                DB::beginTransaction();
                try {

                    $new = new Deviasi();
                    $new->skpd_id = $req->skpd_id;
                    $new->tahun = $req->tahun;
                    $new->save();

                    // Daftar bulan lengkap
                    $bulanList = [
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    ];

                    // Loop untuk menyimpan 12 bulan
                    foreach ($bulanList as $bulan) {

                        $newdetail = new DeviasiDetail();
                        $newdetail->tahun = $req->tahun;
                        $newdetail->skpd_id = $req->skpd_id;
                        $newdetail->deviasi_id = $new->id;

                        $newdetail->bulan = $bulan;

                        // default semua kolom 0
                        $newdetail->kolom_c = 0;
                        $newdetail->kolom_d = 0;
                        $newdetail->kolom_e = 0;
                        $newdetail->kolom_f = 0;
                        $newdetail->kolom_g = 0;
                        $newdetail->kolom_h = 0;
                        $newdetail->kolom_i = 0;
                        $newdetail->kolom_j = 0;

                        $newdetail->save();
                    }

                    DB::commit(); // Jika semua operasi berhasil, commit transaksi

                    Session::flash('success', 'Berhasil Disimpan');
                    return redirect('/superadmin/ikpa/deviasi');
                } catch (\Exception $e) {
                    DB::rollBack(); // Jika ada error, rollback transaksi
                    Session::flash('error', $e->getMessage());
                    return back();
                }
            } else {
                Session::flash('warning', 'data pada tahun ini sudah di tambah, jika ingin update, klik edit');
                return back();
            }
        } else {

            if ($check == null) {
                DB::beginTransaction();
                try {

                    $new = new Deviasi();
                    $new->skpd_id = $req->skpd_id;
                    $new->tahun = $req->tahun;
                    $new->save();

                    Excel::import(new DeviasiImport($req->tahun, $req->skpd_id, $new), $req->file);

                    DB::commit(); // Jika semua operasi berhasil, commit transaksi

                    Session::flash('success', 'Berhasil Disimpan');
                    return redirect('/superadmin/ikpa/deviasi');
                } catch (\Exception $e) {
                    DB::rollBack(); // Jika ada error, rollback transaksi
                    Session::flash('error', $e->getMessage());
                    return back();
                }
            } else {
                Session::flash('warning', 'data pada tahun ini sudah di tambah, jika ingin update, klik edit');
                return back();
            }
        }
    }
}
