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
        
        // Set default values if not provided
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
        
        // Get all SKPD with their IKPA data
        $skpd = Skpd::with(['ikpa' => function($query) use ($tahun) {
            $query->where('tahun', $tahun);
        }])->get();
        
        // Filter data if needed
        if ($semester || $triwulan || $tahun) {
            // You can add additional filtering logic here if needed
            // For now, we'll pass all data and filter in the view
        }
        
        return view('superadmin.penilaian.index', compact('skpd', 'semester', 'triwulan', 'tahun', 'bulan'));
    }
}
