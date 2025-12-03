<?php

namespace App\Http\Controllers;

use App\Models\Ikpa;
use App\Models\Skpd;
use Illuminate\Http\Request;
use App\Imports\DeviasiImport;
use App\Models\Deviasi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class IkpaController extends Controller
{
    public function index()
    {
        $data = Ikpa::paginate(10);
        return view('superadmin.ikpa.index', compact('data'));
    }
    public function add_deviasi()
    {
        return view('superadmin.ikpa.deviasi.create');
    }
    public function store_deviasi(Request $req)
    {
        $check = Deviasi::where('skpd_id', $req->skpd_id)->where('tahun', $req->tahun)->first();
        if ($check == null) {
            Excel::import(new DeviasiImport($req->tahun, $req->skpd_id), $req->file);
            Session::flash('success', 'Berhasil Disimpan');
        } else {

            Session::flash('warning', 'data pada tahun ini sudah di tambah, jika ingin update, klik edit');
        }
        return redirect('/superadmin/ikpa/deviasi');
    }
    public function revisi()
    {
        $data = Ikpa::paginate(10);
        return view('superadmin.ikpa.revisi.index', compact('data'));
    }
    public function deviasi()
    {
        $data = Ikpa::paginate(10);
        return view('superadmin.ikpa.deviasi.index', compact('data'));
    }
    public function create()
    {
        return view('superadmin.ikpa.create');
    }
    public function store(Request $req)
    {
        Ikpa::create($req->all());
        Session::flash('success', 'Berhasil Disimpan');
        return redirect('/superadmin/ikpa/revisi');
    }

    public function edit($id)
    {
        $data = Ikpa::find($id);
        return view('superadmin.ikpa.edit', compact('data'));
    }
    public function update(Request $req, $id)
    {
        Ikpa::find($id)->update($req->all());
        Session::flash('success', 'Berhasil Diupdate');
        return redirect('/superadmin/ikpa/revisi');
    }

    public function delete($id)
    {
        Ikpa::find($id)->delete();
        return redirect('/superadmin/ikpa/revisi');
    }

    public function insertAllSkpd(Request $request)
    {
        try {
            $bulanNama = $request->input('bulan');
            $tahun = $request->input('tahun');
            
            // Validate input
            if (!$bulanNama || !$tahun) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bulan dan tahun harus diisi'
                ]);
            }
            
            if ($tahun < 2020 || $tahun > 2030) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun harus antara 2020-2030'
                ]);
            }
            
            // Validate month name
            $validMonths = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            
            if (!in_array($bulanNama, $validMonths)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bulan tidak valid'
                ]);
            }
            
            // Calculate semester and triwulan based on month name
            $monthToNumber = [
                'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
                'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
                'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
            ];
            
            $bulanNumber = $monthToNumber[$bulanNama];
            $semester = ($bulanNumber <= 6) ? 1 : 2;
            
            if ($bulanNumber <= 3) {
                $triwulan = 1;
            } elseif ($bulanNumber <= 6) {
                $triwulan = 2;
            } elseif ($bulanNumber <= 9) {
                $triwulan = 3;
            } else {
                $triwulan = 4;
            }
            
            // Get all SKPD
            $skpdList = Skpd::all();
            $insertedCount = 0;
            $skippedCount = 0;
            
            foreach ($skpdList as $skpd) {
                try {
                    // Check if data already exists
                    $existingData = Ikpa::where('skpd_id', $skpd->id)
                        ->where('bulan', $bulanNama)
                        ->where('tahun', $tahun)
                        ->first();
                    
                    if (!$existingData) {
                        // Create new IKPA record
                        Ikpa::create([
                            'skpd_id' => $skpd->id,
                            'tahun' => $tahun,
                            'semester' => $semester,
                            'triwulan' => $triwulan,
                            'bulan' => $bulanNama
                        ]);
                        $insertedCount++;
                    } else {
                        $skippedCount++;
                    }
                } catch (\Exception $e) {
                    // Log the error for this specific SKPD but continue with others
                    Log::error('Error creating IKPA record for SKPD ' . $skpd->id . ': ' . $e->getMessage());
                    // Continue to next SKPD
                    continue;
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => "Berhasil memasukkan {$insertedCount} data SKPD. " . 
                            ($skippedCount > 0 ? "{$skippedCount} data sudah ada dan dilewati." : "")
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
