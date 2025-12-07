<?php

namespace App\Http\Controllers;

use App\Models\Capaian;
use Illuminate\Http\Request;
use App\Imports\CapaianImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AdminCapaianController extends Controller
{

    public function index(Request $request)
    {
        $tahun = $request->get('tahun');
        
        $query = Capaian::with('skpd')->orderBy('id', 'DESC');
        
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        
        $data = $query->paginate(10);
        
        return view('admin.ikpa.capaian.index', compact('data', 'tahun'));
    }
    public function add()
    {
        return view('admin.ikpa.capaian.create');
    }
    public function edit($id)
    {
        $data = Capaian::find($id);
        return view('admin.ikpa.capaian.edit', compact('data'));
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
            if ($capaian) {
                $capaian->detail()->delete(); // Menghapus semua detail yang terkait
            }

            Excel::import(new CapaianImport($req->tahun, $req->skpd_id, $capaian), $req->file);

            DB::commit(); // Jika semua operasi berhasil, commit transaksi

            Session::flash('success', 'Berhasil Diupdate');
            return redirect('/admin/ikpa/capaian');
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, rollback transaksi
            Session::flash('error', $e);
            return back();
        }
    }
    public function store(Request $req)
    {

        $check = Capaian::where('skpd_id', Auth::user()->skpd->id)->where('tahun', $req->tahun)->first();

        if ($check == null) {
            DB::beginTransaction();
            try {

                $new = new capaian();
                $new->skpd_id = Auth::user()->skpd->id;
                $new->tahun = $req->tahun;
                $new->save();

                Excel::import(new capaianImport($req->tahun, $req->skpd_id, $new), $req->file);

                DB::commit(); // Jika semua operasi berhasil, commit transaksi

                Session::flash('success', 'Berhasil Disimpan');
                return redirect('/admin/ikpa/capaian');
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
    public function detail($id)
    {
        $data = Capaian::find($id);
        return view('admin.ikpa.capaian.detail', compact('data'));
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
}
