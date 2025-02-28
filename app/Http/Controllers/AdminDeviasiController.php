<?php

namespace App\Http\Controllers;

use App\Models\Deviasi;
use Illuminate\Http\Request;
use App\Imports\DeviasiImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AdminDeviasiController extends Controller
{

    public function index()
    {
        $data = Deviasi::where('skpd_id', Auth::user()->skpd->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.ikpa.deviasi.index', compact('data'));
    }
    public function add()
    {
        return view('admin.ikpa.deviasi.create');
    }
    public function edit($id)
    {
        $data = Deviasi::find($id);
        return view('admin.ikpa.deviasi.edit', compact('data'));
    }
    public function delete($id)
    {
        $data = Deviasi::find($id)->delete();
        Session::flash('success', 'Berhasil Dihapus');
        return back();
    }
    public function update(Request $req, $id)
    {
        DB::beginTransaction();
        try {

            $deviasi = Deviasi::find($id);
            if ($deviasi) {
                $deviasi->detail()->delete(); // Menghapus semua detail yang terkait
            }

            Excel::import(new DeviasiImport($req->tahun, $req->skpd_id, $deviasi), $req->file);

            DB::commit(); // Jika semua operasi berhasil, commit transaksi

            Session::flash('success', 'Berhasil Diupdate');
            return redirect('/admin/ikpa/deviasi');
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, rollback transaksi
            Session::flash('error', $e);
            return back();
        }
    }
    public function store(Request $req)
    {

        $check = Deviasi::where('skpd_id', Auth::user()->skpd->id)->where('tahun', $req->tahun)->first();

        if ($check == null) {
            DB::beginTransaction();
            try {

                $new = new Deviasi();
                $new->skpd_id = $req->skpd_id;
                $new->tahun = $req->tahun;
                $new->save();

                Excel::import(new DeviasiImport($req->tahun, $req->skpd_id, $new), $req->file);

                DB::commit(); // Jika semua operasi berhasil, commit transaksi

                Session::flash('success', 'Berhasil Disimpan');
                return redirect('/admin/ikpa/deviasi');
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
}
