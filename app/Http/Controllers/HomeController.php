<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Ikpa;
use App\Models\DeviasiDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function superadmin(Request $request)
    {
        // Handle form submission
        if ($request->isMethod('post')) {
            $penilaian = $request->input('penilaian');
            $triwulan = $request->input('triwulan');
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
            
            $bulan = $triwulan ? $getTriwulanMonth($triwulan) : null;
            
            // Get all SKPD data
            $skpdData = Skpd::all();
            
            $skpd = $skpdData->map(function ($item) use ($penilaian, $semester, $tahun, $bulan) {
                $param['label'] = $item->singkatan ?: $item->nama;
                $param['y'] = 0;
                
                // Get IKPA data for this SKPD
                $ikpaData = Ikpa::where('skpd_id', $item->id)
                               ->where('tahun', $tahun)
                               ->first();
                
                if ($ikpaData) {
                    switch (strtoupper($penilaian)) {
                        case 'REVISI':
                            // For REVISI, use triwulan to get the month
                            if ($bulan) {
                                // Convert month to semester (1-6 = Semester 1, 7-12 = Semester 2)
                                $semesterFromBulan = ($bulan <= 6) ? 1 : 2;
                                $param['y'] = $ikpaData->skorRevisiTertimbang($semesterFromBulan);
                            } elseif ($semester) {
                                $param['y'] = $ikpaData->skorRevisiTertimbang($semester);
                            }
                            break;
                        case 'DEVIASI':
                            if ($tahun && $bulan) {
                                $param['y'] = $ikpaData->skorDeviasiTertimbang($tahun, $bulan);
                            }
                            break;
                        case 'PENYERAPAN':
                            if ($tahun && $bulan) {
                                $param['y'] = $ikpaData->skorPenyerapanTertimbang($tahun, $bulan);
                            }
                            break;
                        case 'CAPAIAN':
                            if ($tahun && $bulan) {
                                // Convert month to semester for CAPAIAN calculation
                                $semesterFromBulan = ($bulan <= 6) ? 1 : 2;
                                $totalScore = $ikpaData->skorRevisiTertimbang($semesterFromBulan) + 
                                            $ikpaData->skorDeviasiTertimbang($tahun, $bulan) + 
                                            $ikpaData->skorPenyerapanTertimbang($tahun, $bulan);
                                $param['y'] = $totalScore;
                            }
                            break;
                    }
                }
                
                return $param;
            })->toArray();
            
            return view('superadmin.home', compact('skpd', 'penilaian', 'triwulan', 'tahun', 'semester'));
        }
        
        // Default view - show all SKPD with empty values
        $skpd = Skpd::all()->map(function ($item) {
            $param['label'] = $item->singkatan ?: $item->nama;
            $param['y'] = 0;
            return $param;
        })->toArray();
        
        return view('superadmin.home', compact('skpd'));
    }
}
