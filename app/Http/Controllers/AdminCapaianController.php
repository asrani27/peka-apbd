<?php

namespace App\Http\Controllers;

use App\Models\Capaian;
use Illuminate\Http\Request;
use App\Imports\CapaianImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AdminCapaianController extends Controller
{

    public function index()
    {
        $data = Capaian::where('skpd_id', Auth::user()->skpd->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.ikpa.capaian.index', compact('data'));
    }
    public function add()
    {
        return view('admin.ikpa.capaian.create');
    }
    public function edit($id)
    {
        $data = Capaian::find($id);
        return view('admin.ikpa.capaian.edit', compact('data'));
    }
    public function delete($id)
    {
        $data = Capaian::find($id)->delete();
        Session::flash('success', 'Berhasil Dihapus');
        return back();
    }
    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {

            $capaian = Capaian::find($id);
            if ($capaian) {
                $capaian->detail()->delete(); // Menghapus semua detail yang terkait
            }

            Excel::import(new CapaianImport($req->tahun, $req->skpd_id, $capaian), $req->file);

            DB::commit(); // Jika semua operasi berhasil, commit transaksi

            Session::flash('success', 'Berhasil Diupdate');
            return redirect('/admin/ikpa/capaian');
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, rollback transaksi
            Session::flash('error', $e);
            return back();
        }
    }
    public function store(Request $req)
    {

        $check = Capaian::where('skpd_id', Auth::user()->skpd->id)->where('tahun', $req->tahun)->first();

        if ($check == null) {
            DB::beginTransaction();
            try {

                $new = new capaian();
                $new->skpd_id = Auth::user()->skpd->id;
                $new->tahun = $req->tahun;
                $new->save();

                Excel::import(new capaianImport($req->tahun, $req->skpd_id, $new), $req->file);

                DB::commit(); // Jika semua operasi berhasil, commit transaksi

                Session::flash('success', 'Berhasil Disimpan');
                return redirect('/admin/ikpa/capaian');
            } catch (\Exception $e) {
                DB::rollBack(); // Jika ada error, rollback transaksi
                Session::flash('error', $e);
                return back();
            }
        } else {
            Session::flash('warning', 'data pada tahun ini sudah di tambah, jika ingin update, klik edit');
            return back();
        }
    }
    public function detail($id)
    {
        $data = Capaian::find($id);
        return view('admin.ikpa.capaian.detail', compact('data'));
    }
}
