<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviasiDetail extends Model
{
    protected $table = 'deviasi_detail';
    protected $guarded = ['id'];

    // Comment out to prevent automatic loading and improve performance
    // protected $appends = ['nilai_ikpa'];

    public function deviasi()
    {
        return $this->belongsTo(Deviasi::class);
    }

    public function deviasi51()
    {
        $hasil = ($this->kolom_c == 0) ? 0 : abs(($this->kolom_g - $this->kolom_c) / $this->kolom_c * 100);
        return $hasil;
    }
    public function deviasi52()
    {
        $hasil = ($this->kolom_d == 0) ? 0 : abs(($this->kolom_h - $this->kolom_d) / $this->kolom_d * 100);
        return $hasil;
    }
    public function deviasi53()
    {
        $hasil = ($this->kolom_e == 0) ? 0 : abs(($this->kolom_i - $this->kolom_e) / $this->kolom_e * 100);
        return $hasil;
    }
    public function deviasi54()
    {
        $hasil = ($this->kolom_f == 0) ? 0 : abs(($this->kolom_j - $this->kolom_f) / $this->kolom_f * 100);
        return $hasil;
    }
    public function koreksi51()
    {
        return ($this->deviasi51() > 100) ? 100 : $this->deviasi51();
    }
    public function koreksi52()
    {
        return ($this->deviasi52() > 100) ? 100 : $this->deviasi52();
    }
    public function koreksi53()
    {
        return ($this->deviasi53() > 100) ? 100 : $this->deviasi53();
    }
    public function koreksi54()
    {
        return ($this->deviasi54() > 100) ? 100 : $this->deviasi54();
    }
    public function deviasiTertimbang51()
    {
        return $this->deviasi ? $this->deviasi->proporsiPaguRAK51() * $this->koreksi51() / 100 : 0;
    }
    public function deviasiTertimbang52()
    {
        return $this->deviasi ? $this->deviasi->proporsiPaguRAK52() * $this->koreksi52() / 100 : 0;
    }
    public function deviasiTertimbang53()
    {
        return $this->deviasi ? $this->deviasi->proporsiPaguRAK53() * $this->koreksi53() / 100 : 0;
    }
    public function deviasiTertimbang54()
    {
        return $this->deviasi ? $this->deviasi->proporsiPaguRAK54() * $this->koreksi54() / 100 : 0;
    }
    public function seluruhDeviasi()
    {
        return $this->deviasiTertimbang51() + $this->deviasiTertimbang52() + $this->deviasiTertimbang53() + $this->deviasiTertimbang54();
    }
    public function akumulasiDeviasi()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->seluruhDeviasi();
        });

        return $akumulasi;
    }
    public function RAKKomulatif51()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_c;
        });

        return $akumulasi;
    }
    public function RAKKomulatif52()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_d;
        });

        return $akumulasi;
    }
    public function RAKKomulatif53()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_e;
        });

        return $akumulasi;
    }
    public function RAKKomulatif54()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_f;
        });

        return $akumulasi;
    }
    public function RAKKomulatifKB()
    {
        return $this->RAKKomulatif51() + $this->RAKKomulatif52() + $this->RAKKomulatif53() + $this->RAKKomulatif54();
    }
    public function RAKRealisasi51()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_g;
        });

        return $akumulasi;
    }
    public function RAKRealisasi52()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_h;
        });

        return $akumulasi;
    }
    public function RAKRealisasi53()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_i;
        });

        return $akumulasi;
    }
    public function RAKRealisasi54()
    {
        $details = self::where('deviasi_id', $this->deviasi_id)
            ->where('id', '<=', $this->id)
            ->get();

        $akumulasi = $details->sum(function ($detail) {
            return $detail->kolom_j;
        });

        return $akumulasi;
    }
    public function RAKRealisasiKB()
    {
        return $this->RAKRealisasi51() + $this->RAKRealisasi52() + $this->RAKRealisasi53() + $this->RAKRealisasi54();
    }
    public function penyerapanAnggaran()
    {
        $totalPagu = $this->deviasi->totalPagu();
        return $totalPagu > 0 ? ($this->RAKRealisasiKB() / $totalPagu) * 100 : 0;
    }
    function bulanKeAngka($bulan)
    {
        $bulan = strtolower($bulan);
        $listBulan = [
            'januari' => 1,
            'februari' => 2,
            'maret' => 3,
            'april' => 4,
            'mei' => 5,
            'juni' => 6,
            'juli' => 7,
            'agustus' => 8,
            'september' => 9,
            'oktober' => 10,
            'november' => 11,
            'desember' => 12
        ];

        return $listBulan[$bulan] ?? null;
    }
    function deviasiRataRata()
    {
        return ($this->akumulasiDeviasi() / $this->bulanKeAngka($this->bulan));
    }
    function getNilaiIkpaAttribute()
    {
        return ($this->deviasiRataRata() <= 15) ? 100 : (100 - $this->deviasiRataRata());
    }
}
