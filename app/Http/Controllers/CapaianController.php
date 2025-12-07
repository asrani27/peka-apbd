<?php

namespace App\Http\Controllers;

use App\Imports\CapaianImport;
use App\Imports\CapaianDetailImport;
use App\Models\Capaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class CapaianController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun');

        $query = Capaian::with('skpd')->join('skpd', 'capaian.skpd_id', '=', 'skpd.id')->orderBy('skpd.kode', 'ASC')->select('capaian.*');

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        $data = $query->get();

        return view('superadmin.ikpa.capaian.index', compact('data', 'tahun'));
    }

    public function detail($id)
    {
        $data = Capaian::find($id);
        return view('superadmin.ikpa.capaian.detail', compact('data'));
    }
    public function add()
    {
        return view('superadmin.ikpa.capaian.create');
    }
    public function edit($id)
    {
        $data = Capaian::find($id);
        return view('superadmin.ikpa.capaian.edit', compact('data'));
    }
    public function delete($id)
    {
        $data = Capaian::find($id)->delete();
        Session::flash('success', 'Berhasil Dihapus');
        return back();
    }
    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {
            $capaian = Capaian::find($id);
            
            if (!$capaian) {
                Session::flash('error', 'Data capaian tidak ditemukan');
                return back();
            }

            // Update field periode
            $capaian->periode_tw1 = $req->periode_tw1;
            $capaian->periode_tw2 = $req->periode_tw2;
            $capaian->periode_tw3 = $req->periode_tw3;
            $capaian->periode_tw4 = $req->periode_tw4;
            
            // Update field bobot
            $capaian->bobot_triwulan = $req->bobot_triwulan ?? 0.25;
            $capaian->bobot_capaian = $req->bobot_capaian ?? 0.70;
            $capaian->bobot_ketepatan = $req->bobot_ketepatan ?? 0.30;
            
            $capaian->save();

            // Jika ada file Excel yang diupload, import data detail
            if ($req->hasFile('file')) {
                // Hapus semua detail yang terkait
                $capaian->detail()->delete();
                
                // Import data baru dari Excel
                Excel::import(new CapaianImport($capaian->tahun, $capaian->skpd_id, $capaian), $req->file);
            }

            DB::commit(); // Jika semua operasi berhasil, commit transaksi

            Session::flash('success', 'Berhasil Diupdate');
            return redirect('/superadmin/ikpa/capaian/detail/' . $id);
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, rollback transaksi
            Session::flash('error', $e->getMessage());
            return back();
        }
    }
    public function store(Request $req)
    {
        $check = Capaian::where('skpd_id', $req->skpd_id)->where('tahun', $req->tahun)->first();

        if ($check == null) {
            DB::beginTransaction();
            try {

                $new = new Capaian();
                $new->skpd_id = $req->skpd_id;
                $new->tahun = $req->tahun;
                $new->save();

                Excel::import(new CapaianImport($req->tahun, $req->skpd_id, $new), $req->file);

                DB::commit(); // Jika semua operasi berhasil, commit transaksi

                Session::flash('success', 'Berhasil Disimpan');
                return redirect('/superadmin/ikpa/capaian');
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

    public function insertAllSkpd(Request $request)
    {
        try {
            $tahun = $request->tahun;

            // Validate year
            if ($tahun < 2024 || $tahun > 2026) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun harus antara 2024-2026!'
                ]);
            }

            // Get all SKPD
            $skpds = \App\Models\Skpd::all();
            $insertedCount = 0;
            $skippedCount = 0;

            foreach ($skpds as $skpd) {
                // Check if capaian already exists for this SKPD and year
                $existing = Capaian::where('skpd_id', $skpd->id)->where('tahun', $tahun)->first();

                if (!$existing) {
                    // Create new capaian
                    $capaian = new Capaian();
                    $capaian->skpd_id = $skpd->id;
                    $capaian->tahun = $tahun;
                    $capaian->save();
                    $insertedCount++;
                } else {
                    $skippedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil memasukkan {$insertedCount} data SKPD untuk tahun {$tahun}. " .
                    ($skippedCount > 0 ? "{$skippedCount} data sudah ada dan dilewati." : "")
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteAllSkpd(Request $request)
    {
        try {
            $tahun = $request->tahun;

            // Validate year
            if ($tahun < 2024 || $tahun > 2026) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun harus antara 2024-2026!'
                ]);
            }

            // Get all capaian for the specified year
            $capaians = Capaian::where('tahun', $tahun)->get();
            $deletedCount = 0;

            foreach ($capaians as $capaian) {
                // Delete related details first
                $capaian->detail()->delete();
                // Then delete the capaian
                $capaian->delete();
                $deletedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} data SKPD untuk tahun {$tahun}"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function importDetail(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $capaian = Capaian::find($id);

            if (!$capaian) {
                Session::flash('error', 'Data capaian tidak ditemukan');
                return back();
            }

            // Validate file
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048'
            ]);

            // Hapus data lama terlebih dahulu
            $capaian->detail()->delete();
            
            // Import detail data baru
            Excel::import(new CapaianDetailImport($capaian->id), $request->file('file'));

            DB::commit();
            Session::flash('success', 'Berhasil mengimport data detail capaian');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back();
        }
    }
}
