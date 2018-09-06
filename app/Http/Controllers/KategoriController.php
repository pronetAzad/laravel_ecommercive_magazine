<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index($slug_kategoriadi)
    {
        $kategori     = Kategori::where('slug', $slug_kategoriadi)->firstOrFail();
        $alt_kategori = DB::table('Kategori')->where('ust_id', $kategori->id)->get();

        $order = request('order');
        if($order == 'cok_satan')
        {
            $urunler = $kategori->urunler()
                ->distinct()
                ->join('urun_detay', 'urun_detay.urun_id', 'urun.id')
                ->orderBy('goster_cok_satan', 'decs')
                ->paginate(2);
        }
        elseif ($order == 'yeni')
        {
            $urunler  = $kategori->urunler()->distinct()->orderBy('created_at', 'decs')->paginate(2);
        }
        else
        {
            $urunler  = $kategori->urunler()->distinct()->paginate(2);
        }

        return view('kategori', compact('kategori', 'alt_kategori', 'urunler'));
    }
}
