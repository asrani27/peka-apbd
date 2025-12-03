<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SkpdController extends Controller
{
    public function index()
    {
        $skpd = Skpd::get();
        return view('superadmin.skpd.index', compact('skpd'));
    }
    public function createuser($id)
    {
        DB::beginTransaction();

        try {
            $skpd = Skpd::find($id);

            $check = User::where('username', $skpd->kode)->first();
            if ($check == null) {
                $user = new User();
                $user->username = $skpd->kode;
                $user->name = $skpd->nama;
                $user->password = Hash::make('adminpeka');
                $user->roles = 'admin';
                $user->save();

                $skpd->update([
                    'user_id' => $user->id,
                ]);
            } else {
            }
            DB::commit();
            Session::flash('success', 'password : adminpeka');
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', $e);
            return back();
        }
    }
    public function resetpass($id)
    {
        Skpd::find($id)->user->update([
            'password' =>  Hash::make('adminpeka'),
        ]);
        Session::flash('success', 'password : adminpeka');
        return back();
    }

    public function edit($id)
    {
        $skpd = Skpd::find($id);
        return view('superadmin.skpd.edit', compact('skpd'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255|unique:skpd,kode,' . $id,
            'nama' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $skpd = Skpd::find($id);
            
            // Update SKPD data
            $skpd->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
            ]);

            // Update associated user if exists
            if ($skpd->user) {
                $skpd->user->update([
                    'username' => $request->kode,
                    'name' => $request->nama,
                ]);
            }

            DB::commit();
            Session::flash('success', 'Data SKPD berhasil diperbarui');
            return redirect('/superadmin/skpd');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }
}
