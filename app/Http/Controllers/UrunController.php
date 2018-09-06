<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urun;

class UrunController extends Controller
{
    public function index($slug_urunadi)
    {
        $urun = Urun::whereSlug($slug_urunadi)->firstOrFail();
        $kategori = $urun->kategori()->distinct()->get();
        return view('urun', compact('urun', 'kategori'));
    }

    public function ara(Request $request)
    {
        $aranan = $request->input('aranan');
        $urunler = Urun::where('urun_adi', 'like', "%$aranan%")
            ->orWhere('aciklama', 'like', "%$aranan%")
            ->paginate(4);

        $request->flash();
        return view('arama', compact('urunler'));
    }
}
