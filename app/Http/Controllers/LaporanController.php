<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Revisi;
use App\Models\Deviasi;
use App\Models\DeviasiDetail;
use App\Models\Capaian;
use App\Models\CapaianDetail;
use App\Models\RevisiDetail;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Handle form submission for filtering
        if ($request->isMethod('post')) {
            $semester = $request->input('semester');
            $tahun = $request->input('tahun');
            $skpd_id = $request->input('skpd_id');
            
            // Set default values
            $tahun = $tahun ?: date('Y');
            
            $laporanData = [];
            $rfkData = null;
            
            // If specific SKPD is selected, fetch API data
            if ($skpd_id) {
                $skpd = Skpd::find($skpd_id);
                if ($skpd) {
                    $rfkData = $this->fetchRfkData($skpd->kode, $tahun);
                }
            }
            
            // Get SKPD data
            $skpdQuery = Skpd::query();
            if ($skpd_id) {
                $skpdQuery->where('id', $skpd_id);
            }
            $skpdData = $skpdQuery->orderBy('kode')->get();
            
            foreach ($skpdData as $skpd) {
                $skpdInfo = [
                    'skpd' => $skpd,
                    'data' => []
                ];
                
                // Get Revisi data
                $revisiData = Revisi::where('skpd_id', $skpd->id)
                                 ->where('tahun', $tahun)
                                 ->first();
                
                if ($revisiData) {
                    $skpdInfo['data']['revisi'] = $revisiData;
                    if ($semester) {
                        $skorIT = $semester == 1 ? $revisiData->skorITSemester1() : $revisiData->skorITSemester2();
                        $skpdInfo['data']['skor_it'] = round($skorIT, 2);
                    }
                }
                
                // Get Deviasi data
                $deviasiData = Deviasi::where('skpd_id', $skpd->id)
                                  ->where('tahun', $tahun)
                                  ->first();
                
                if ($deviasiData) {
                    $skpdInfo['data']['deviasi'] = $deviasiData;
                    
                    // Get all deviasi details for the year
                    $deviasiDetails = DeviasiDetail::where('deviasi_id', $deviasiData->id)->get();
                    $skpdInfo['data']['deviasi_details'] = $deviasiDetails;
                    
                    // Calculate semester averages
                    if ($semester) {
                        $semesterMonths = $semester == 1 ? [1, 2, 3, 4, 5, 6] : [7, 8, 9, 10, 11, 12];
                        $monthNames = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        
                        $totalDeviasi = 0;
                        $totalPenyerapan = 0;
                        $count = 0;
                        
                        foreach ($semesterMonths as $month) {
                            $monthName = $monthNames[$month];
                            $detail = $deviasiDetails->where('bulan', $monthName)->first();
                            if ($detail) {
                                $totalDeviasi += $detail->nilai_ikpa * 0.2;
                                $totalPenyerapan += $detail->penyerapanAnggaran();
                                $count++;
                            }
                        }
                        
                        if ($count > 0) {
                            $skpdInfo['data']['avg_deviasi'] = round($totalDeviasi / $count, 2);
                            $skpdInfo['data']['avg_penyerapan'] = round($totalPenyerapan / $count, 2);
                        }
                    }
                }
                
                // Get Capaian data
                $capaianData = Capaian::where('skpd_id', $skpd->id)
                                    ->where('tahun', $tahun)
                                    ->first();
                
                if ($capaianData) {
                    $skpdInfo['data']['capaian'] = $capaianData;
                    
                    // Get capaian details
                    $capaianDetails = CapaianDetail::where('capaian_id', $capaianData->id)->get();
                    $skpdInfo['data']['capaian_details'] = $capaianDetails;
                    
                    // Calculate semester averages
                    if ($semester) {
                        $semesterTriwulans = $semester == 1 ? [1, 2] : [3, 4];
                        $totalCapaian = 0;
                        $count = 0;
                        
                        foreach ($semesterTriwulans as $triwulan) {
                            $skorDenganBobot = $capaianData->getSkorIndikatorTertimbangDenganBobot($triwulan);
                            $totalCapaian += $skorDenganBobot;
                            $count++;
                        }
                        
                        if ($count > 0) {
                            $skpdInfo['data']['avg_capaian'] = round($totalCapaian / $count, 2);
                        }
                    }
                }
                
                $laporanData[] = $skpdInfo;
            }
            
            $skpdList = Skpd::orderBy('kode')->get();
            return view('superadmin.laporan.index', compact('laporanData', 'semester', 'tahun', 'skpd_id', 'skpdList', 'rfkData'));
        }
        
        // Default view - show empty form
        $laporanData = [];
        $skpdList = Skpd::orderBy('kode')->get();
        return view('superadmin.laporan.index', compact('laporanData', 'skpdList'));
    }
    
    public function exportExcel(Request $request)
    {
        $semester = $request->input('semester');
        $tahun = $request->input('tahun');
        $skpd_id = $request->input('skpd_id');
        
        // Validate required parameters
        if (!$semester || !$tahun || !$skpd_id) {
            return redirect()->back()->with('error', 'Parameter tidak lengkap untuk export Excel');
        }
        
        // Get SKPD data
        $skpd = Skpd::find($skpd_id);
        if (!$skpd) {
            return redirect()->back()->with('error', 'SKPD tidak ditemukan');
        }
        
        // Fetch API data
        $rfkData = $this->fetchRfkData($skpd->kode, $tahun);
        
        if (!$rfkData) {
            return redirect()->back()->with('error', 'Data API tidak tersedia untuk SKPD ini');
        }
        
        // Create filename
        $filename = 'Laporan_RAK_' . str_replace(' ', '_', $skpd->nama) . '_Tahun_' . $tahun . '_Semester_' . $semester . '.xlsx';
        
        // Export Excel
        return Excel::download(new LaporanExport($rfkData, $semester, $tahun, $skpd), $filename);
    }
    
    private function fetchRfkData($kode_skpd, $tahun)
    {
        try {
            $url = "https://kenangan.banjarmasinkota.go.id/api/rfk/{$kode_skpd}/{$tahun}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        } catch (\Exception $e) {
            // Log error or handle gracefully
        }
        
        return null;
    }
}
