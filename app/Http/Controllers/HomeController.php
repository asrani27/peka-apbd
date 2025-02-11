<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function superadmin()
    {
        $skpd = Skpd::get()->map(function ($item) {
            $param['label'] = $item->singkatan;
            $param['y'] = rand(60, 100);
            return $param;
        })->toArray();
        return view('superadmin.home', compact('skpd'));
    }
}
