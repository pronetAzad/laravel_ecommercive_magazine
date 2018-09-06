<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Urun;
use Cart;
use Illuminate\Http\Request;
use Validator;

class SepetController extends Controller
{
    public function index()
    {
        return view('sepet');
    }

    public function ekle()
    {
        $urun = Urun::find(request('id'));
        $cartItem = Cart::add($urun->id, $urun->urun_adi, 1, $urun->fiyati, ['slug' => $urun->slug]);

        if(auth()->check())
        {
            $aktif_sepet_id = session('aktif_sepet_id');

            if(!isset($aktif_sepet_id))
            {
                $aktif_sepet = Sepet::create([
                   'kullanici_id' => auth()->id()
                ]);

                $aktif_sepet_id = $aktif_sepet->id;
                session()->put('aktif_sepet_id', $aktif_sepet_id);
            }

            SepetUrun::updateOrCreate(
                ['sepet_id' => $aktif_sepet_id, 'urun_id' => $urun->id],
                ['adet' => $cartItem->qty, 'fiyati' => $urun->fiyati, 'durum' => 'Beklemede']
            );
        }

        return redirect()->route('sepet')
            ->with('mesaj', 'Urun sepete eklendi');
    }

    public function kaldir()
    {
        if(auth()->id())
        {
            $aktif_sepet_id = session('aktif_sepet_id');
            $carItems = Cart::get(request('id'));
            SepetUrun::where('sepet_id', $aktif_sepet_id)
                    ->where('urun_id', $carItems->id)
                    ->delete();
        }

        Cart::remove(request('id'));
    }

    public function bosalt()
    {
        if(auth()->check())
        {
            $aktif_sepet_id = session('aktif_sepet_id');
            SepetUrun::where('sepet_id', $aktif_sepet_id)->delete();
        }

        Cart::destroy();
        return redirect()->route('sepet');
    }

    public function guncelle()
    {
        $validator = Validator::make(request()->all(), [
            'adet' => 'required|numeric|between:1,5'
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 'error']);
        }

        if(auth()->check())
        {
            $aktif_sepet_id = session('aktif_sepet_id');
            $carItems = Cart::get(request('id'));
            SepetUrun::where('sepet_id', $aktif_sepet_id)
                ->where('urun_id', $carItems->id)
                ->update(['adet' => request('adet')]);
        }

        Cart::update(request('id'), request('adet'));
        return response()->json(['status' => 'success']);
    }
}
