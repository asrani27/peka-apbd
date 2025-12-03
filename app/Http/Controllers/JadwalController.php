<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Sample data - in a real application, this would come from database
        $jadwalList = [
            [
                'id' => 1,
                'kegiatan' => 'Penilaian Triwulan 1',
                'periode' => 'Triwulan 1 - Semester 1',
                'tanggal_mulai' => '2025-04-01',
                'tanggal_selesai' => '2025-04-30',
                'status' => 'aktif',
                'target_skpd' => 45
            ],
            [
                'id' => 2,
                'kegiatan' => 'Penilaian Semester 1',
                'periode' => 'Semester 1',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2025-07-31',
                'status' => 'draft',
                'target_skpd' => 45
            ],
            [
                'id' => 3,
                'kegiatan' => 'Penilaian Triwulan 3',
                'periode' => 'Triwulan 3 - Semester 2',
                'tanggal_mulai' => '2025-10-01',
                'tanggal_selesai' => '2025-10-31',
                'status' => 'draft',
                'target_skpd' => 45
            ]
        ];

        return view('superadmin.jadwal.index', compact('jadwalList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('superadmin.jadwal.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020|max:2030',
            'semester' => 'required|integer|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:draft,aktif',
            'triwulan' => 'nullable|integer|in:1,2,3,4',
            'deskripsi' => 'nullable|string|max:1000'
        ]);

        // In a real application, you would save this to the database
        // For now, we'll just flash a success message
        
        Session::flash('success', 'Jadwal penilaian berhasil disimpan!');
        
        return redirect('/superadmin/jadwal');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // In a real application, you would fetch the jadwal from database
        $jadwal = [
            'id' => $id,
            'kegiatan' => 'Penilaian Triwulan 1',
            'tahun' => 2025,
            'semester' => 1,
            'tanggal_mulai' => '2025-04-01',
            'tanggal_selesai' => '2025-04-30',
            'status' => 'aktif',
            'triwulan' => 1,
            'deskripsi' => 'Penilaian untuk triwulan pertama tahun 2025'
        ];

        return view('superadmin.jadwal.edit', compact('jadwal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020|max:2030',
            'semester' => 'required|integer|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:draft,aktif,selesai',
            'triwulan' => 'nullable|integer|in:1,2,3,4',
            'deskripsi' => 'nullable|string|max:1000'
        ]);

        // In a real application, you would update the database
        // For now, we'll just flash a success message
        
        Session::flash('success', 'Jadwal penilaian berhasil diperbarui!');
        
        return redirect('/superadmin/jadwal');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // In a real application, you would delete from database
        // For now, we'll just flash a success message
        
        Session::flash('success', 'Jadwal penilaian berhasil dihapus!');
        
        return redirect('/superadmin/jadwal');
    }
}
