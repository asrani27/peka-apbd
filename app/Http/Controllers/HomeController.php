<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Ikpa;
use App\Models\Revisi;
use App\Models\Deviasi;
use App\Models\DeviasiDetail;
use App\Models\Capaian;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function superadmin(Request $request)
    {
        // Handle form submission
        if ($request->isMethod('post')) {
            $penilaian = $request->input('penilaian');
            $triwulan = $request->input('triwulan');
            $bulan = $request->input('bulan'); // Direct bulan parameter
            $tahun = $request->input('tahun');
            $semester = $request->input('semester');
            
            // Set default values
            $tahun = $tahun ?: date('Y');
            
            // Function to get last month of triwulan
            $getTriwulanMonth = function($triwulan) {
                switch ($triwulan) {
                    case 1:
                        return 3;  // March (last month of Q1)
                    case 2:
                        return 6;  // June (last month of Q2)
                    case 3:
                        return 9;  // September (last month of Q3)
                    case 4:
                        return 12; // December (last month of Q4)
                    default:
                        return null;
                }
            };
            
            // Use triwulan only if bulan is not set (for PENYERAPAN and CAPAIAN)
            if (!$bulan && $triwulan) {
                $bulan = $getTriwulanMonth($triwulan);
            }
            
            // Get all SKPD data sorted by code
            $skpdData = Skpd::orderBy('kode')->get();
            
            $skpd = $skpdData->map(function ($item) use ($penilaian, $semester, $tahun, $bulan, $triwulan) {
                $param['label'] = $item->singkatan ?: $item->nama;
                $param['y'] = 0;
                
                switch (strtoupper($penilaian)) {
                    case 'REVISI':
                        // Get Revisi data for this SKPD
                        $revisiData = Revisi::where('skpd_id', $item->id)
                                         ->where('tahun', $tahun)
                                         ->first();
                        
                        if ($revisiData && $semester) {
                            // Get Skor IT for the selected semester
                            $skorIT = $semester == 1 ? $revisiData->skorITSemester1() : $revisiData->skorITSemester2();
                            $param['y'] = round($skorIT, 2);
                        }
                        break;
                        
                    case 'DEVIASI':
                        // Get Deviasi data for this SKPD
                        $deviasiData = Deviasi::where('skpd_id', $item->id)
                                          ->where('tahun', $tahun)
                                          ->first();
                        
                        if ($deviasiData && $tahun && $bulan) {
                            // Convert month number to month name
                            $monthNames = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            $bulanName = $monthNames[$bulan] ?? null;
                            
                            if ($bulanName) {
                                // Get DeviasiDetail for the specific month
                                $deviasiDetail = DeviasiDetail::where('deviasi_id', $deviasiData->id)
                                                             ->where('bulan', $bulanName)
                                                             ->first();
                                
                                if ($deviasiDetail) {
                                    // Calculate nilai_ikpa * 0.2 (20% weight)
                                    $param['y'] = round($deviasiDetail->nilai_ikpa * 0.2, 2);
                                }
                            }
                        }
                        break;
                        
                    case 'PENYERAPAN':
                        // Get Penyerapan data for this SKPD (uses deviasi table)
                        $penyerapanData = Deviasi::where('skpd_id', $item->id)
                                              ->where('tahun', $tahun)
                                              ->first();
                        
                        if ($penyerapanData && $tahun && $bulan) {
                            // Convert month number to month name
                            $monthNames = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            $bulanName = $monthNames[$bulan] ?? null;
                            
                            if ($bulanName) {
                                // Get DeviasiDetail for the specific month
                                $penyerapanDetail = DeviasiDetail::where('deviasi_id', $penyerapanData->id)
                                                               ->where('bulan', $bulanName)
                                                               ->first();
                                
                                if ($penyerapanDetail) {
                                    // Get penyerapan anggaran percentage
                                    $param['y'] = round($penyerapanDetail->penyerapanAnggaran(), 2);
                                }
                            }
                        }
                        break;
                        
                    case 'CAPAIAN':
                        // Get Capaian data for this SKPD
                        $capaianData = Capaian::where('skpd_id', $item->id)
                                            ->where('tahun', $tahun)
                                            ->first();
                        
                        if ($capaianData && $triwulan) {
                            // Get skor indikator tertimbang dengan bobot 35% untuk triwulan yang dipilih
                            $skorDenganBobot = $capaianData->getSkorIndikatorTertimbangDenganBobot($triwulan);
                            $param['y'] = round($skorDenganBobot, 2);
                        }
                        break;
                }
                
                return $param;
            })->toArray();
            
            return view('superadmin.home', compact('skpd', 'penilaian', 'triwulan', 'bulan', 'tahun', 'semester'));
        }
        
        // Default view - show all SKPD with empty values, sorted by code
        $skpd = Skpd::orderBy('kode')->get()->map(function ($item) {
            $param['label'] = $item->singkatan ?: $item->nama;
            $param['y'] = 0;
            return $param;
        })->toArray();
        
        return view('superadmin.home', compact('skpd'));
    }
}
