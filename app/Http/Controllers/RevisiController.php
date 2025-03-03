<?php

namespace App\Http\Controllers;

use App\Models\Ikpa;
use App\Models\Revisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RevisiController extends Controller
{
    public function index($id)
    {
        $data = Ikpa::find($id);

        $revisi = $data->revisi->map(function ($item) {
            $item->pp = $item->pagu_awal === $item->pagu_akhir ? 'Tidak' : 'Ya';
            $item->top = $item->pp == 'Ya' ? 'Tidak' : 'Ya';
            return $item;
        });

        $jml_revisi = $revisi->where('top', 'Ya')->count();
        $nkra_semester = $jml_revisi <= 1 ? 110 : ($jml_revisi <= 2 ? 100 : 50);
        $nkra_tahunan = $nkra_semester * 0.5;

        $skor = $data->semester == 1 ? $nkra_semester : $nkra_tahunan;
        $bobot_revisi = 0.15;
        $sit = $skor * $bobot_revisi;

        $bobot_deviasi = 0.20;
        return view('superadmin.ikpa.revisi', compact('data', 'revisi', 'jml_revisi', 'nkra_semester', 'nkra_tahunan', 'skor', 'bobot_revisi', 'sit', 'bobot_deviasi'));
    }

    public function store(Request $req, $id)
    {
        $param = $req->all();
        $param['ikpa_id'] = $id;

        Revisi::create($param);

        Session::flash('success', 'Disimpan');
        return redirect('/superadmin/ikpa/revisi/' . $id);
    }
    public function delete($id, $revisi_id)
    {
        Revisi::find($revisi_id)->delete();
        Session::flash('success', 'Dihapus');
        return redirect('/superadmin/ikpa/revisi/' . $id);
    }
    public function edit($id, $revisi_id)
    {
        $data = Ikpa::find($id);
        $revisi = $data->revisi->map(function ($item) {
            $item->pp = $item->pagu_awal === $item->pagu_akhir ? 'Tidak' : 'Ya';
            $item->top = $item->pp == 'Ya' ? 'Tidak' : 'Ya';
            return $item;
        });
        $jml_revisi = $revisi->where('top', 'Ya')->count();
        $nkra_semester = $jml_revisi <= 1 ? 110 : ($jml_revisi <= 2 ? 100 : 50);
        $nkra_tahunan = $nkra_semester * 0.5;

        $skor = $data->semester == 1 ? $nkra_semester : $nkra_tahunan;
        $bobot_revisi = 0.15;
        $sit = $skor * $bobot_revisi;
        return view('superadmin.ikpa.revisi_edit', compact('data', 'revisi', 'revisi_id', 'jml_revisi', 'nkra_semester', 'nkra_tahunan', 'skor', 'bobot_revisi', 'sit'));
    }
    public function update(Request $req, $id, $revisi_id)
    {
        $param = $req->all();
        $param['ikpa_id'] = $id;

        Revisi::find($revisi_id)->update($param);

        Session::flash('success', 'Diupdate');
        return redirect('/superadmin/ikpa/revisi/' . $id);
    }
}
