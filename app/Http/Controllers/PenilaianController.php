<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Ikpa;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $semester = $request->get('semester');
        $triwulan = $request->get('triwulan');
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');

        // Only fetch data when filters are applied
        if ($semester || $triwulan || $tahun || $bulan) {
            // Set default year if not provided
            $tahun = $tahun ?: date('Y');

            // Function to get last month of triwulan
            $getTriwulanMonth = function ($triwulan) {
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

            $bulan = $bulan ?: ($triwulan ? $getTriwulanMonth($triwulan) : null);

            // Get all SKPD with their IKPA, Revisi, Deviasi, and Capaian data, sorted by kode
            // Also eager load deviasi details to avoid N+1 queries
            $skpd = Skpd::with(['ikpa' => function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            }, 'revisi' => function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            }, 'deviasi' => function ($query) use ($tahun) {
                $query->where('tahun', $tahun)
                      ->with(['detail' => function ($detailQuery) {
                          $detailQuery->orderBy('id', 'asc');
                      }]);
            }, 'capaian' => function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            }])->orderBy('kode')->get();

            // Pre-compute cumulative data for each SKPD's deviasi
            $deviasiCumulativeData = [];
            foreach ($skpd as $item) {
                $deviasiData = $item->deviasi->first();
                if ($deviasiData && $deviasiData->detail) {
                    $details = $deviasiData->detail;
                    $cumulativeData = [];
                    $akumulasiDeviasiTotal = 0;
                    
                    foreach ($details as $index => $detail) {
                        // Calculate seluruh deviasi for this detail
                        $seluruhDeviasi = $detail->seluruhDeviasi();
                        $akumulasiDeviasiTotal += $seluruhDeviasi;
                        
                        // Calculate deviasi rata-rata
                        $bulanAngka = $detail->bulanKeAngka($detail->bulan);
                        $deviasiRataRata = $bulanAngka > 0 ? ($akumulasiDeviasiTotal / $bulanAngka) : 0;
                        
                        // Calculate nilai IKPA
                        $nilaiIkpa = ($deviasiRataRata <= 15) ? 100 : (100 - $deviasiRataRata);
                        
                        // Calculate penyerapan anggaran
                        $penyerapanAnggaran = $detail->penyerapanAnggaran();
                        
                        $cumulativeData[$detail->id] = [
                            'akumulasi_deviasi' => $akumulasiDeviasiTotal,
                            'deviasi_rata_rata' => $deviasiRataRata,
                            'nilai_ikpa' => $nilaiIkpa,
                            'penyerapan_anggaran' => $penyerapanAnggaran,
                        ];
                    }
                    
                    $deviasiCumulativeData[$item->id] = [
                        'details' => $details,
                        'cumulativeData' => $cumulativeData,
                    ];
                }
            }
        } else {
            $skpd = collect(); // Empty collection when no filters
            $deviasiCumulativeData = [];
        }

        return view('superadmin.penilaian.index', compact('skpd', 'semester', 'triwulan', 'tahun', 'bulan', 'deviasiCumulativeData'));
    }
}
