<?php

namespace App\Http\Controllers;

use App\Models\Ikpa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IkpaController extends Controller
{
    public function index()
    {
        $data = Ikpa::paginate(10);
        return view('superadmin.ikpa.index', compact('data'));
    }
    public function create()
    {
        return view('superadmin.ikpa.create');
    }
    public function store(Request $req)
    {
        Ikpa::create($req->all());
        Session::flash('success', 'Berhasil Disimpan');
        return redirect('/superadmin/ikpa');
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
        return redirect('/superadmin/ikpa');
    }

    public function delete($id)
    {
        Ikpa::find($id)->delete();
        return redirect('/superadmin/ikpa');
    }
}
