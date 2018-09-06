<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use SoftDeletes;
    protected $table = "urun";

    public function kategori()
    {
        return $this->belongsToMany('App\Models\Kategori', 'kategori_urun');
    }

    public function detay()
    {
        return $this->hasOne(UrunDetay::class)->withDefault();
    }
}
