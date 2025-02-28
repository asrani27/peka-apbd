<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $skpd = Skpd::get();
        return view('superadmin.penilaian.index', compact('skpd'));
    }
}
