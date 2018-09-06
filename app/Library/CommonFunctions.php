<?php
/**
 * Created by PhpStorm.
 * User: telim3
 * Date: 31.08.2018
 * Time: 13:01
 */

namespace App\Library;

use App\Models\Kategori;
use App\Models\Kullanici;
use App\Models\Siparis;
use App\Models\Urun;
use Illuminate\Support\Facades\Cache;

class CommonFunctions
{
    public static function Dashboard()
    {
        $bitisZamani = now()->addMinutes(10);
        $istatistika = Cache::remember('istatistika', $bitisZamani, function () {
            return [
                'bekleyen_sifaris' => Siparis::where('durum', 'Siparisiniz alindi')->count(),
                'tamamlanan_sifaris' => Siparis::where('durum', 'Siparisiniz tamamlanan')->count(),
                'toplam_urun' => Urun::count(),
                'toplam_kategori' => Kategori::count(),
                'toplam_kullanici' => Kullanici::count()
            ];
        });

        return $istatistika;
    }
}