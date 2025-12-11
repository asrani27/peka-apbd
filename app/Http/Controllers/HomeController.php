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
                        
                    case 'HASIL':
                        // Calculate total nilai capaian like in penilaian page
                        $currentSemester = $semester ?? 1;
                        
                        // Get data once per SKPD
                        $deviasiData = Deviasi::where('skpd_id', $item->id)
                                          ->where('tahun', $tahun)
                                          ->first();
                        $revisiData = Revisi::where('skpd_id', $item->id)
                                         ->where('tahun', $tahun)
                                         ->first();
                        $capaianData = Capaian::where('skpd_id', $item->id)
                                            ->where('tahun', $tahun)
                                            ->first();
                        
                        $totalDecimal = 0;
                        
                        // Calculate Revisi DPA value
                        $revisiDpaValue = 0;
                        if ($revisiData) {
                            $revisiDpaValue = ($currentSemester == 1)
                                ? $revisiData->skorITSemester1()
                                : $revisiData->skorITSemester2();
                        }
                        
                        // Calculate Deviasi DPA and Penyerapan Anggaran values
                        $deviasiDpaValue = 0;
                        $penyerapanAnggaranValue = 0;
                        if ($deviasiData) {
                            // Convert month number to month name
                            $monthNames = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            $bulanNama = $monthNames[$bulan] ?? null;
                            
                            if ($bulanNama) {
                                // Get DeviasiDetail for selected month
                                $deviasiDetail = DeviasiDetail::where('deviasi_id', $deviasiData->id)
                                                             ->where('bulan', $bulanNama)
                                                             ->first();
                                
                                if ($deviasiDetail) {
                                    // Calculate cumulative values like in penilaian page
                                    $details = DeviasiDetail::where('deviasi_id', $deviasiData->id)
                                                               ->orderBy('id', 'asc')
                                                               ->get();
                                    
                                    $akumulasiDeviasiTotal = 0;
                                    $cumulativeData = [];
                                    
                                    foreach ($details as $index => $detail) {
                                        $bulanAngka = $detail->bulanKeAngka($detail->bulan);
                                        $seluruhDeviasi = $detail->seluruhDeviasi();
                                        $akumulasiDeviasiTotal += $seluruhDeviasi;
                                        
                                        $deviasiRataRata = $bulanAngka > 0 ? ($akumulasiDeviasiTotal / $bulanAngka) : 0;
                                        $nilaiIkpa = ($deviasiRataRata <= 15) ? 100 : (100 - $deviasiRataRata);
                                        $penyerapanAnggaran = $detail->penyerapanAnggaran();
                                        
                                        $cumulativeData[$detail->id] = [
                                            'nilai_ikpa' => $nilaiIkpa,
                                            'penyerapan_anggaran' => $penyerapanAnggaran,
                                        ];
                                        
                                        // Stop at the selected month
                                        if ($detail->bulan === $bulanNama) {
                                            $deviasiDpaValue = $nilaiIkpa * 0.2;
                                            $penyerapanAnggaranValue = $penyerapanAnggaran * 0.3;
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                        
                        // Calculate Capaian Output value
                        $capaianOutputValue = 0;
                        if ($capaianData && $triwulan) {
                            $capaianOutputValue = $capaianData->getSkorIndikatorTertimbangDenganBobot($triwulan);
                        }
                        
                        // Calculate total decimal
                        $totalDecimal = $revisiDpaValue + $deviasiDpaValue + $penyerapanAnggaranValue + $capaianOutputValue;
                        $param['y'] = round($totalDecimal, 2);
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
    
    public function exportChartToPDF(Request $request)
    {
        $penilaian = $request->get('penilaian');
        $triwulan = $request->get('triwulan');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $semester = $request->get('semester');
        
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
        
        // Use triwulan only if bulan is not set
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
                    $revisiData = Revisi::where('skpd_id', $item->id)
                                     ->where('tahun', $tahun)
                                     ->first();
                    
                    if ($revisiData && $semester) {
                        $skorIT = $semester == 1 ? $revisiData->skorITSemester1() : $revisiData->skorITSemester2();
                        $param['y'] = round($skorIT, 2);
                    }
                    break;
                    
                case 'DEVIASI':
                    $deviasiData = Deviasi::where('skpd_id', $item->id)
                                      ->where('tahun', $tahun)
                                      ->first();
                    
                    if ($deviasiData && $tahun && $bulan) {
                        $monthNames = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $bulanName = $monthNames[$bulan] ?? null;
                        
                        if ($bulanName) {
                            $deviasiDetail = DeviasiDetail::where('deviasi_id', $deviasiData->id)
                                                         ->where('bulan', $bulanName)
                                                         ->first();
                            
                            if ($deviasiDetail) {
                                $param['y'] = round($deviasiDetail->nilai_ikpa * 0.2, 2);
                            }
                        }
                    }
                    break;
                    
                case 'PENYERAPAN':
                    $penyerapanData = Deviasi::where('skpd_id', $item->id)
                                          ->where('tahun', $tahun)
                                          ->first();
                    
                    if ($penyerapanData && $tahun && $bulan) {
                        $monthNames = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $bulanName = $monthNames[$bulan] ?? null;
                        
                        if ($bulanName) {
                            $penyerapanDetail = DeviasiDetail::where('deviasi_id', $penyerapanData->id)
                                                           ->where('bulan', $bulanName)
                                                           ->first();
                            
                            if ($penyerapanDetail) {
                                $param['y'] = round($penyerapanDetail->penyerapanAnggaran(), 2);
                            }
                        }
                    }
                    break;
                    
                case 'CAPAIAN':
                    $capaianData = Capaian::where('skpd_id', $item->id)
                                        ->where('tahun', $tahun)
                                        ->first();
                    
                    if ($capaianData && $triwulan) {
                        $skorDenganBobot = $capaianData->getSkorIndikatorTertimbangDenganBobot($triwulan);
                        $param['y'] = round($skorDenganBobot, 2);
                    }
                    break;
                    
                case 'HASIL':
                    $currentSemester = $semester ?? 1;
                    
                    $deviasiData = Deviasi::where('skpd_id', $item->id)
                                      ->where('tahun', $tahun)
                                      ->first();
                    $revisiData = Revisi::where('skpd_id', $item->id)
                                     ->where('tahun', $tahun)
                                     ->first();
                    $capaianData = Capaian::where('skpd_id', $item->id)
                                        ->where('tahun', $tahun)
                                        ->first();
                    
                    $totalDecimal = 0;
                    
                    // Calculate Revisi DPA value
                    $revisiDpaValue = 0;
                    if ($revisiData) {
                        $revisiDpaValue = ($currentSemester == 1)
                            ? $revisiData->skorITSemester1()
                            : $revisiData->skorITSemester2();
                    }
                    
                    // Calculate Deviasi DPA and Penyerapan Anggaran values
                    $deviasiDpaValue = 0;
                    $penyerapanAnggaranValue = 0;
                    if ($deviasiData) {
                        $monthNames = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $bulanNama = $monthNames[$bulan] ?? null;
                        
                        if ($bulanNama) {
                            $deviasiDetail = DeviasiDetail::where('deviasi_id', $deviasiData->id)
                                                         ->where('bulan', $bulanNama)
                                                         ->first();
                            
                            if ($deviasiDetail) {
                                $details = DeviasiDetail::where('deviasi_id', $deviasiData->id)
                                                           ->orderBy('id', 'asc')
                                                           ->get();
                                
                                $akumulasiDeviasiTotal = 0;
                                
                                foreach ($details as $index => $detail) {
                                    $bulanAngka = $detail->bulanKeAngka($detail->bulan);
                                    $seluruhDeviasi = $detail->seluruhDeviasi();
                                    $akumulasiDeviasiTotal += $seluruhDeviasi;
                                    
                                    $deviasiRataRata = $bulanAngka > 0 ? ($akumulasiDeviasiTotal / $bulanAngka) : 0;
                                    $nilaiIkpa = ($deviasiRataRata <= 15) ? 100 : (100 - $deviasiRataRata);
                                    $penyerapanAnggaran = $detail->penyerapanAnggaran();
                                    
                                    if ($detail->bulan === $bulanNama) {
                                        $deviasiDpaValue = $nilaiIkpa * 0.2;
                                        $penyerapanAnggaranValue = $penyerapanAnggaran * 0.3;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    
                    // Calculate Capaian Output value
                    $capaianOutputValue = 0;
                    if ($capaianData && $triwulan) {
                        $capaianOutputValue = $capaianData->getSkorIndikatorTertimbangDenganBobot($triwulan);
                    }
                    
                    // Calculate total decimal
                    $totalDecimal = $revisiDpaValue + $deviasiDpaValue + $penyerapanAnggaranValue + $capaianOutputValue;
                    $param['y'] = round($totalDecimal, 2);
                    break;
            }
            
            return $param;
        })->toArray();
        
        // Sort by nilai
        usort($skpd, function($a, $b) {
            return $a['y'] - $b['y'];
        });
        
        // Get chart title
        $chartTitle = $this->getChartTitle($penilaian);
        
        // Generate filename
        $filename = 'grafik_' . strtolower($penilaian) . '_';
        if ($semester) $filename .= 'semester_' . $semester . '_';
        if ($triwulan) $filename .= 'triwulan_' . $triwulan . '_';
        if ($bulan) {
            $monthNames = [1 => 'januari', 2 => 'februari', 3 => 'maret', 4 => 'april', 5 => 'mei', 6 => 'juni', 7 => 'juli', 8 => 'agustus', 9 => 'september', 10 => 'oktober', 11 => 'november', 12 => 'desember'];
            $filename .= $monthNames[$bulan] . '_';
        }
        $filename .= 'tahun_' . $tahun . '.pdf';
        
        // Load PDF view
        $html = view('superadmin.home.pdf', compact('skpd', 'chartTitle', 'penilaian', 'semester', 'triwulan', 'bulan', 'tahun'))->render();
        
        // Create PDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // Stream PDF to browser (view first, then download option)
        return $dompdf->stream($filename, array("Attachment" => false));
    }
    
    private function getChartTitle($penilaian)
    {
        switch(strtoupper($penilaian)) {
            case 'REVISI':
                return 'NILAI SKOR IT REVISI DPA PER SKPD';
            case 'DEVIASI':
                return 'NILAI DEVIASI DPA PER SKPD';
            case 'PENYERAPAN':
                return 'NILAI PENYERAPAN ANGGARAN PER SKPD';
            case 'CAPAIAN':
                return 'SKOR INDIKATOR TERTIMBANG CAPAIAN (35%) PER SKPD';
            case 'HASIL':
                return 'HASIL PENILAIAN SKPD';
            default:
                return 'CAPAIAN PER SKPD';
        }
    }
}
