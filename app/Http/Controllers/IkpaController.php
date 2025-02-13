<?php

namespace App\Http\Controllers;

use App\Models\Ikpa;
use Illuminate\Http\Request;
use App\Imports\DeviasiImport;
use App\Models\Deviasi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class IkpaController extends Controller
{
    public function index()
    {
        $data = Ikpa::paginate(10);
        return view('superadmin.ikpa.index', compact('data'));
    }
    public function add_deviasi()
    {
        return view('superadmin.ikpa.deviasi.create');
    }
    public function store_deviasi(Request $req)
    {
        $check = Deviasi::where('skpd_id', $req->skpd_id)->where('tahun', $req->tahun)->first();
        if ($check == null) {
            Excel::import(new DeviasiImport($req->tahun, $req->skpd_id), $req->file);
            Session::flash('success', 'Berhasil Disimpan');
        } else {

            Session::flash('warning', 'data pada tahun ini sudah di tambah, jika ingin update, klik edit');
        }
        return redirect('/superadmin/ikpa/deviasi');
    }
    public function revisi()
    {
        $data = Ikpa::paginate(10);
        return view('superadmin.ikpa.revisi.index', compact('data'));
    }
    public function deviasi()
    {
        $data = Ikpa::paginate(10);
        return view('superadmin.ikpa.deviasi.index', compact('data'));
    }
    public function create()
    {
        return view('superadmin.ikpa.create');
    }
    public function store(Request $req)
    {
        Ikpa::create($req->all());
        Session::flash('success', 'Berhasil Disimpan');
        return redirect('/superadmin/ikpa/revisi');
    }

    public function edit($id)
    {
        $data = Ikpa::find($id);
        return view('superadmin.ikpa.edit', compact('data'));
    }
    public function update(Request $req, $id)
    {
        Ikpa::find($id)->update($req->all());
        Session::flash('success', 'Berhasil Diupdate');
        return redirect('/superadmin/ikpa/revisi');
    }

    public function delete($id)
    {
        Ikpa::find($id)->delete();
        return redirect('/superadmin/ikpa/revisi');
    }
}
