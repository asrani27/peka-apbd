<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyerapan extends Model
{
    protected $table = 'deviasi';
    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }
    public function detail()
    {
        return $this->hasMany(DeviasiDetail::class);
    }
}
