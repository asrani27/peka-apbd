<?php

namespace App\Http\Controllers;

use App\Models\Deviasi;
use Illuminate\Http\Request;

class PenyerapanController extends Controller
{
    public function index()
    {
        $data = Deviasi::orderBy('id', 'DESC')->paginate(10);
        return view('superadmin.ikpa.penyerapan.index', compact('data'));
    }
    public function detail($id)
    {
        $data = Deviasi::find($id);
        return view('superadmin.ikpa.penyerapan.detail', compact('data'));
    }
}
