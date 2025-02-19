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
}
