<?php

namespace App\Http\Controllers;

use App\Imports\CapaianImport;
use App\Models\Capaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class CapaianController extends Controller
{
    public function index()
    {
        $data = Capaian::orderBy('id', 'DESC')->paginate(10);
        return view('superadmin.ikpa.capaian.index', compact('data'));
    }

    public function detail($id)
    {
        $data = Capaian::find($id);
        return view('superadmin.ikpa.capaian.detail', compact('data'));
    }
    public function add()
    {
        return view('superadmin.ikpa.capaian.create');
    }
    public function edit($id)
    {
        $data = Capaian::find($id);
        return view('superadmin.ikpa.capaian.edit', compact('data'));
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

            $deviasi = Capaian::find($id);
            if ($deviasi) {
                $deviasi->detail()->delete(); // Menghapus semua detail yang terkait
            }

            Excel::import(new CapaianImport($req->tahun, $req->skpd_id, $deviasi), $req->file);

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
        $check = Capaian::where('skpd_id', $req->skpd_id)->where('tahun', $req->tahun)->first();

        if ($check == null) {
            DB::beginTransaction();
            try {

                $new = new Capaian();
                $new->skpd_id = $req->skpd_id;
                $new->tahun = $req->tahun;
                $new->save();

                Excel::import(new CapaianImport($req->tahun, $req->skpd_id, $new), $req->file);

                DB::commit(); // Jika semua operasi berhasil, commit transaksi

                Session::flash('success', 'Berhasil Disimpan');
                return redirect('/superadmin/ikpa/capaian');
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
