<?php

namespace App\Http\Controllers;

use App\Models\Ikpa;
use App\Models\Revisi;
use App\Models\Skpd;
use App\Imports\RevisiImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class RevisiController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        
        $query = Revisi::with('skpd');
        
        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        
        // Sort by SKPD kode
        $data = $query->join('skpd', 'revisi.skpd_id', '=', 'skpd.id')
                     ->orderBy('skpd.kode', 'asc')
                     ->select('revisi.*')
                     ->get();

        return view('superadmin.ikpa.revisi.index', compact('data', 'tahun'));
    }
    // public function index($id)
    // {
    //     $data = Ikpa::find($id);

    //     $revisi = $data->revisi->map(function ($item) {
    //         $item->pp = $item->pagu_awal === $item->pagu_akhir ? 'Tidak' : 'Ya';
    //         $item->top = $item->pp == 'Ya' ? 'Tidak' : 'Ya';
    //         return $item;
    //     });

    //     $jml_revisi = $revisi->where('top', 'Ya')->count();
    //     $nkra_semester = $jml_revisi <= 1 ? 110 : ($jml_revisi <= 2 ? 100 : 50);
    //     $nkra_tahunan = $nkra_semester * 0.5;

    //     $skor = $data->semester == 1 ? $nkra_semester : $nkra_tahunan;
    //     $bobot_revisi = 0.15;
    //     $sit = $skor * $bobot_revisi;

    //     $bobot_deviasi = 0.20;
    //     return view('superadmin.ikpa.revisi', compact('data', 'revisi', 'jml_revisi', 'nkra_semester', 'nkra_tahunan', 'skor', 'bobot_revisi', 'sit', 'bobot_deviasi'));
    // }

    public function store(Request $req, $id)
    {
        $param = $req->all();
        $param['ikpa_id'] = $id;

        Revisi::create($param);

        Session::flash('success', 'Disimpan');
        return redirect('/superadmin/ikpa/revisi/' . $id);
    }
    public function delete($id)
    {
        Revisi::find($id)->delete();
        Session::flash('success', 'Dihapus');
        return redirect('/superadmin/ikpa/revisi/' . $id);
    }
    public function edit($id, $revisi_id)
    {
        $data = Ikpa::find($id);
        $revisi = $data->revisi->map(function ($item) {
            $item->pp = $item->pagu_awal === $item->pagu_akhir ? 'Tidak' : 'Ya';
            $item->top = $item->pp == 'Ya' ? 'Tidak' : 'Ya';
            return $item;
        });
        $jml_revisi = $revisi->where('top', 'Ya')->count();
        $nkra_semester = $jml_revisi <= 1 ? 110 : ($jml_revisi <= 2 ? 100 : 50);
        $nkra_tahunan = $nkra_semester * 0.5;

        $skor = $data->semester == 1 ? $nkra_semester : $nkra_tahunan;
        $bobot_revisi = 0.15;
        $sit = $skor * $bobot_revisi;
        return view('superadmin.ikpa.revisi_edit', compact('data', 'revisi', 'revisi_id', 'jml_revisi', 'nkra_semester', 'nkra_tahunan', 'skor', 'bobot_revisi', 'sit'));
    }
    public function update(Request $req, $id, $revisi_id)
    {
        $param = $req->all();
        $param['ikpa_id'] = $id;

        Revisi::find($revisi_id)->update($param);

        Session::flash('success', 'Diupdate');
        return redirect('/superadmin/ikpa/revisi/' . $id);
    }

    public function insertAllSkpd(Request $request)
    {
        try {
            $tahun = $request->input('tahun');

            // Validate input
            if (!$tahun) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun harus diisi'
                ]);
            }

            if ($tahun < 2024 || $tahun > 2026) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun harus antara 2024-2026'
                ]);
            }

            // Get all SKPD
            $skpdList = Skpd::all();
            $insertedCount = 0;
            $skippedCount = 0;

            foreach ($skpdList as $skpd) {
                try {
                    // Check if data already exists
                    $existingData = Revisi::where('skpd_id', $skpd->id)
                        ->where('tahun', $tahun)
                        ->first();

                    if (!$existingData) {
                        // Create new Revisi record
                        Revisi::create([
                            'skpd_id' => $skpd->id,
                            'tahun' => $tahun
                        ]);
                        $insertedCount++;
                    } else {
                        $skippedCount++;
                    }
                } catch (\Exception $e) {
                    // Log the error for this specific SKPD but continue with others
                    Log::error('Error creating Revisi record for SKPD ' . $skpd->id . ': ' . $e->getMessage());
                    // Continue to next SKPD
                    continue;
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
            $tahun = $request->input('tahun');

            // Validate input
            if (!$tahun) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun harus diisi'
                ]);
            }

            if ($tahun < 2024 || $tahun > 2026) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun harus antara 2024-2026'
                ]);
            }

            // Count existing data before deletion
            $existingCount = Revisi::where('tahun', $tahun)->count();

            if ($existingCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Tidak ada data SKPD untuk tahun {$tahun}"
                ]);
            }

            // Delete all Revisi records for the specified year
            $deletedCount = Revisi::where('tahun', $tahun)->delete();

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

    public function detail($id)
    {
        $revisi = Revisi::with(['skpd', 'revisiDetail'])->find($id);
        
        if (!$revisi) {
            Session::flash('error', 'Data revisi tidak ditemukan');
            return redirect('/superadmin/ikpa/revisi');
        }

        return view('superadmin.ikpa.revisi.detail', compact('revisi'));
    }

    public function import(Request $request, $id)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048'
            ]);

            $revisi = Revisi::find($id);
            
            if (!$revisi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data revisi tidak ditemukan'
                ]);
            }

            // Hapus data revisi detail yang lama untuk revisi ini
            \App\Models\RevisiDetail::where('revisi_id', $id)->delete();
            
            // Import data baru
            Excel::import(new RevisiImport($id), $request->file('file'));

            return response()->json([
                'success' => true,
                'message' => 'Data revisi berhasil diimport'
            ]);

        } catch (\Exception $e) {
            Log::error('Error importing revisi: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
            ]);
        }
    }

    public function editDetail($id)
    {
        try {
            $detail = \App\Models\RevisiDetail::find($id);
            
            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data detail revisi tidak ditemukan'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $detail
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting revisi detail: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ]);
        }
    }

    public function updateDetail(Request $request, $id)
    {
        try {
            $detail = \App\Models\RevisiDetail::find($id);
            
            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data detail revisi tidak ditemukan'
                ]);
            }

            // Validate request data
            $request->validate([
                'tanggal_nodin' => 'nullable|date',
                'tanggal_pengesahan' => 'nullable|date',
                'revisi_ke' => 'nullable|string|max:255',
                'jenis_revisi' => 'nullable|string|max:255',
                'pagu_awal' => 'nullable|numeric|min:0',
                'pagu_akhir' => 'nullable|numeric|min:0'
            ]);

            // Update the detail
            $detail->update([
                'tanggal_nodin' => $request->tanggal_nodin,
                'tanggal_pengesahan' => $request->tanggal_pengesahan,
                'revisi_ke' => $request->revisi_ke,
                'jenis_revisi' => $request->jenis_revisi,
                'pagu_awal' => $request->pagu_awal,
                'pagu_akhir' => $request->pagu_akhir
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data detail revisi berhasil diperbarui'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $e->errors())
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating revisi detail: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data'
            ]);
        }
    }

    public function deleteDetail($id)
    {
        try {
            $detail = \App\Models\RevisiDetail::find($id);
            
            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data detail revisi tidak ditemukan'
                ]);
            }

            $detail->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data detail revisi berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting revisi detail: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ]);
        }
    }
}
