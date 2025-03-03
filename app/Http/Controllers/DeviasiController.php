<?php

namespace App\Http\Controllers;

use App\Models\Deviasi;
use Illuminate\Http\Request;
use App\Imports\DeviasiImport;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class DeviasiController extends Controller
{
    public function index()
    {
        $data = Deviasi::orderBy('id', 'DESC')->paginate(10);
        return view('superadmin.ikpa.deviasi.index', compact('data'));
    }
    public function detail($id)
    {
        $data = Deviasi::find($id);
        return view('superadmin.ikpa.deviasi.detail', compact('data'));
    }
    public function add()
    {
        return view('superadmin.ikpa.deviasi.create');
    }
    public function edit($id)
    {
        $data = Deviasi::find($id);
        return view('superadmin.ikpa.deviasi.edit', compact('data'));
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
            return redirect('/superadmin/ikpa/deviasi');
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, rollback transaksi
            Session::flash('error', $e);
            return back();
        }
    }
    public function store(Request $req)
    {
        $check = Deviasi::where('skpd_id', $req->skpd_id)->where('tahun', $req->tahun)->first();

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
                return redirect('/superadmin/ikpa/deviasi');
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
