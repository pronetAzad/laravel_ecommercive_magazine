<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $table    = "kategori";
    protected $fillable = ['kategori_adi', 'slug'];

    public function urunler()
    {
        return $this->belongsToMany(Urun::class, 'kategori_urun');
    }

    public function ust_kategori()
    {
        return $this->belongsTo(Kategori::class, 'ust_id')->withDefault([
            'kategori_adi' => 'Ana Kategori'
        ]);
    }

}
