<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capaian extends Model
{
    protected $table = 'capaian';
    protected $guarded = ['id'];
    public function detail()
    {
        return $this->hasMany(CapaianDetail::class);
    }
    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }
}
