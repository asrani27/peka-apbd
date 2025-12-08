<?php

use Carbon\Carbon;
use App\Models\Skpd;


function bulan()
{
    Carbon::setLocale('id');
    // Array untuk menyimpan nama bulan
    $namaBulan = [];

    // Loop untuk mendapatkan nama semua bulan
    for ($i = 1; $i <= 12; $i++) {
        $namaBulan[] = Carbon::createFromDate(2024, $i, 1)->translatedFormat('F');
    }

    return $namaBulan;
}
function skpd()
{
    return Skpd::get();
}

function parseIndonesianNumber($str)
{
    // Remove dots (thousand separators) and replace comma (decimal separator) with dot
    $cleaned = str_replace('.', '', $str);
    $cleaned = str_replace(',', '.', $cleaned);
    return (float) $cleaned;
}
