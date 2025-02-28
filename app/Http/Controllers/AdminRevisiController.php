<?php

namespace App\Http\Controllers;

use App\Models\Ikpa;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminRevisiController extends Controller
{
    public function index()
    {
        $data = Ikpa::where('skpd_id', Auth::user()->skpd->id)->paginate(10);
        return view('admin.ikpa.revisi.index', compact('data'));
    }

    public function storeKeberatan(Request $req, $id)
    {
        $data = Ikpa::find($id);
        $new = new Keberatan();
        $new->ikpa_id = $id;
        $new->isi = $req->isi;
        $new->save();
        Session::flash('success', 'Keberatan dikirim');
        return back();
    }
    public function deleteKeberatan($id)
    {
        Keberatan::find($id)->delete();
        Session::flash('success', 'Keberatan dihapus');
        return back();
    }
    public function detail($id)
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
        return view('admin.ikpa.revisi.revisi', compact('data', 'revisi', 'jml_revisi', 'nkra_semester', 'nkra_tahunan', 'skor', 'bobot_revisi', 'sit'));
    }
}
