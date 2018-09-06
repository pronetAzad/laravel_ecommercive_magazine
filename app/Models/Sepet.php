<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sepet extends Model
{
    use SoftDeletes;

    protected $table   = 'sepet';
    protected $guarded = [];

    public function siparis()
    {
        return $this->hasOne(Siparis::class);
    }

    public function sepet_urunler()
    {
        return $this->hasMany(SepetUrun::class);
    }

    public static function aktif_sepet_id()
    {
        $aktif_sepet = DB::table('Sepet')
            ->where('kullanici_id', auth()->id())
            ->orderByDesc('created_at')
            ->first();

        if(!is_null($aktif_sepet)) return $aktif_sepet->id;
    }

    public function sepet_urun_adet()
    {
        return DB::table('sepet_urun')
            ->where('sepet_id', $this->id)
            ->sum('adet');
    }
}
