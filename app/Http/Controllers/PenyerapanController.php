<?php

namespace App\Http\Controllers;

use App\Models\Deviasi;
use Illuminate\Http\Request;

class PenyerapanController extends Controller
{
    public function index()
    {
        // Sort by SKPD kode
        $data = Deviasi::with('skpd')
                      ->join('skpd', 'deviasi.skpd_id', '=', 'skpd.id')
                      ->orderBy('skpd.kode', 'asc')
                      ->select('deviasi.*')
                      ->get();
        return view('superadmin.ikpa.penyerapan.index', compact('data'));
    }
    public function detail($id)
    {
        $data = Deviasi::with(['skpd', 'detail' => function($query) {
            $query->orderBy('id', 'asc');
        }])->find($id);
        
        if (!$data) {
            abort(404);
        }

        // Pre-compute cumulative values to avoid N+1 queries
        $details = $data->detail;
        $cumulativeData = [];
        
        foreach ($details as $index => $detail) {
            // Get all details up to current index for cumulative calculations
            $previousDetails = $details->slice(0, $index + 1);
            
            $cumulativeData[$detail->id] = [
                'rak_komulatif_51' => $previousDetails->sum('kolom_c'),
                'rak_komulatif_52' => $previousDetails->sum('kolom_d'),
                'rak_komulatif_53' => $previousDetails->sum('kolom_e'),
                'rak_komulatif_54' => $previousDetails->sum('kolom_f'),
                'rak_komulatif_kb' => $previousDetails->sum(function($item) {
                    return $item->kolom_c + $item->kolom_d + $item->kolom_e + $item->kolom_f;
                }),
                'rak_realisasi_51' => $previousDetails->sum('kolom_g'),
                'rak_realisasi_52' => $previousDetails->sum('kolom_h'),
                'rak_realisasi_53' => $previousDetails->sum('kolom_i'),
                'rak_realisasi_54' => $previousDetails->sum('kolom_j'),
                'rak_realisasi_kb' => $previousDetails->sum(function($item) {
                    return $item->kolom_g + $item->kolom_h + $item->kolom_i + $item->kolom_j;
                }),
                'akumulasi_deviasi' => $previousDetails->sum(function($item) {
                    return $item->seluruhDeviasi();
                }),
            ];
            
            // Calculate penyerapan anggaran
            $totalPagu = $data->totalPagu();
            $cumulativeData[$detail->id]['penyerapan_anggaran'] = $totalPagu > 0 
                ? ($cumulativeData[$detail->id]['rak_realisasi_kb'] / $totalPagu) * 100 
                : 0;
        }
        
        // Pre-compute totals for summary row
        $totals = [
            'kolom_c' => $details->sum('kolom_c'),
            'kolom_d' => $details->sum('kolom_d'),
            'kolom_e' => $details->sum('kolom_e'),
            'kolom_f' => $details->sum('kolom_f'),
            'kolom_g' => $details->sum('kolom_g'),
            'kolom_h' => $details->sum('kolom_h'),
            'kolom_i' => $details->sum('kolom_i'),
            'kolom_j' => $details->sum('kolom_j'),
        ];
        
        // Make sure each detail item has access to the parent deviasi
        foreach ($details as $detail) {
            $detail->setRelation('deviasi', $data);
        }
        
        return view('superadmin.ikpa.penyerapan.detail', compact('data', 'cumulativeData', 'totals'));
    }
}
