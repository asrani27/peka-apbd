<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Deviasi;
use Illuminate\Http\Request;
use App\Models\DeviasiDetail;
use App\Imports\DeviasiImport;
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
        $data = Deviasi::orderBy('id', 'DESC')->paginate(10);
        return view('superadmin.ikpa.deviasi.index', compact('data'));
    }
    public function detail($id)
    {
        $data = Deviasi::find($id);
        return view('superadmin.ikpa.deviasi.detail', compact('data'));
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
            Session::flash('error', $e);
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
                    Session::flash('error', $e);
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
                    Session::flash('error', $e);
                    return back();
                }
            } else {
                Session::flash('warning', 'data pada tahun ini sudah di tambah, jika ingin update, klik edit');
                return back();
            }
        }
    }
}
