<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Kategori;
use App\Models\UrunDetay;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Urun;

class UrunController extends Controller
{
    public function index()
    {
        if(request()->filled('aranan'))
        {
            request()->flash();
            $aranan = request('aranan');
            $list = Urun::where('urun_adi', 'like', "%$aranan%")
                ->orWhere('aciklama', 'like', "%$aranan%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        else
        {
            $list = Urun::orderBy('id', 'desc')
                ->paginate(5);
        }

        return view('yonetim.urun.index',compact('list'));
    }

    public function form($id = 0)
    {
        $entry = new Urun;
        $urun_karegoriler = [];
        if($id > 0)
        {
            $entry = Urun::find($id);
            $urun_karegoriler = $entry->kategori()->pluck('kategori_id')->all();
        }

        $kategori = Kategori::all();

        return view('yonetim.urun.form', compact('entry', 'kategori', 'urun_karegoriler'));
    }

    public function kaydet($id = 0)
    {
        $kategori_adi = request('kategoriler');
        $slug = str_slug(request('urun_adi'));
        request()->merge(['slug' => $slug]);

        $validator = validator(request()->all(), [
            'urun_adi'   => 'required',
            'fiyati'     => 'required',
            'slug'       => ($id > 0 ? '' : 'unique:urun,slug'),
            'urun_resmi' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails())
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        if($id > 0)
        {
            $userObj    = Urun::find($id);
            $urun_detay = UrunDetay::where('urun_id', $id)->firstOrFail();

            if (request()->hasFile('urun_resmi')){
                @unlink(public_path()."/uploads/urunler/".$userObj->detay->urun_resmi);
            }
        }
        else
        {
            $userObj      = new Urun();
            $urun_detay   = new UrunDetay();
        }

        $userObj->urun_adi    = request('urun_adi');
        $userObj->slug        = request('slug');
        $userObj->fiyati      = request('fiyati');
        $userObj->aciklama    = request('aciklama', '');
        $userObj->save();

        $urun_detay->urun_id = $userObj->id;
        $urun_detay->goster_slider = request('goster_slider');
        $urun_detay->goster_gunun_firsati = request('goster_gunun_firsati');
        $urun_detay->goster_one_cikan = request('goster_one_cikan');
        $urun_detay->goster_cok_satan = request('goster_cok_satan');
        $urun_detay->goster_indirimli = request('goster_indirimli');

        //Karegori_URUN INSERT
        if($id > 0)
        {
            $userObj->kategori()->sync($kategori_adi);
        }
        else {
            $userObj->kategori()->attach($kategori_adi);
        }

        if(request()->hasFile('urun_resmi'))
        {
            $urun_resmi = request()->file('urun_resmi');
            $dosyaadi = $userObj->id . "-" . time() . "." . $urun_resmi->extension();

            if($urun_resmi->isValid())
            {
                $urun_resmi->move('uploads/urunler', $dosyaadi);

                $urun_detay->urun_resmi = $dosyaadi;
            }
        }

        $urun_detay->save();

        return redirect()
            ->route('yonetim.urun.duzenle', $userObj->id)
            ->with('mesaj', ($id > 0 ? 'Guncellendi' : 'Kaydedildi'))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        $urun = Urun::find($id);
        $urun->kategori()->detach();
        $urun->delete();

        return redirect()
            ->route('yonetim.urun')
            ->with('mesaj', 'Kayit silindi')
            ->with('mesaj_tur', 'success');
    }
}
