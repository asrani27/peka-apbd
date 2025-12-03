<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deviasi extends Model
{
    protected $table = 'deviasi';
    protected $guarded = ['id'];
    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }
    public function detail()
    {
        return $this->hasMany(DeviasiDetail::class);
    }
    public function jumlahRAK51()
    {
        return $this->detail()->sum('kolom_c');
    }
    public function jumlahRAK52()
    {
        return $this->detail()->sum('kolom_d');
    }
    public function jumlahRAK53()
    {
        return $this->detail()->sum('kolom_e');
    }
    public function jumlahRAK54()
    {
        return $this->detail()->sum('kolom_f');
    }
    public function totalPagu()
    {
        return ($this->jumlahRAK51() + $this->jumlahRAK52() + $this->jumlahRAK53() + $this->jumlahRAK54()) - $this->jumlahRAK53();
    }
    public function proporsiPaguRAK51()
    {
        $total = $this->totalPagu();
        return $total > 0 ? ($this->jumlahRAK51() / $total) * 100 : 0;
    }

    public function proporsiPaguRAK52()
    {
        $total = $this->totalPagu();
        return $total > 0 ? ($this->jumlahRAK52() / $total) * 100 : 0;
    }

    public function proporsiPaguRAK53()
    {
        return 0;
    }

    public function proporsiPaguRAK54()
    {
        $total = $this->totalPagu();
        return $total > 0 ? ($this->jumlahRAK54() / $total) * 100 : 0;
    }
    public function totalProporsiPagu()
    {
        return $this->proporsiPaguRAK51() + $this->proporsiPaguRAK52() + $this->proporsiPaguRAK53() + $this->proporsiPaguRAK54();
    }

    public function skorDeviasi($tahun, $bulan)
    {
        // Convert month number to month name
        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $bulanNama = $monthNames[$bulan] ?? $bulan;

        return optional($this->detail()->where('tahun', $tahun)->where('bulan', $bulanNama)->first())->nilai_ikpa ?? 0;
    }
    public function skorDeviasiTertimbang($tahun, $bulan)
    {
        return round($this->skorDeviasi($tahun, $bulan) * 20 / 100, 2);
    }
}
