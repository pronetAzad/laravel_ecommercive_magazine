<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Siparis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnasayfaController extends Controller
{
    public function index()
    {
        $cok_satan_urunler = DB::select("
                                    SELECT u.urun_adi, SUM(su.adet) adet
                                    FROM siparis si
                                      INNER JOIN sepet s ON S.id = si.sepet_id
                                      INNER JOIN sepet_urun su ON s.id = su.sepet_id
                                      INNER JOIN urun u ON u.id = su.urun_id
                                    GROUP BY u.urun_adi
                                    ORDER BY SUM(su.adet) DESC
                                ");

        return view('yonetim.anasayfa', compact('cok_satan_urunler'));
    }

    public function yonetimikapat()
    {
        Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect()->route('yonetim.oturumac');
    }
}
