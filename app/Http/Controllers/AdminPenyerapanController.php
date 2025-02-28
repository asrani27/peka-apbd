<?php

namespace App\Http\Controllers;

use App\Models\Deviasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPenyerapanController extends Controller
{
    public function index()
    {
        $data = Deviasi::where('skpd_id', Auth::user()->skpd->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.ikpa.penyerapan.index', compact('data'));
    }
}
