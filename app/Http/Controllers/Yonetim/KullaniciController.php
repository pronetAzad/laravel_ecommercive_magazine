<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use Illuminate\Support\Facades\Hash;


class KullaniciController extends Controller
{
    public function oturumAc(){
        return view('yonetim.oturumac');
    }

    public function oturumAcProses(){

        $validator = validator(request()->all(), [
            'email'  => 'required|email|exists:kullanici,email',
            'sifre'  => 'required|min:5|max:15'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        else{

            $create = [
                'email' => request('email'),
                'password' => request('sifre'),
                'yonetici_mi' => 1
            ];

            if(auth()->guard('yonetim')->attempt($create, request()->has('benihatirla')))
            {
                return redirect()->route('yonetim.anasayfa');
            }
            else
            {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
        }
    }

    public function index()
    {
        $list = Kullanici::orderBy('created_at', 'desc')->paginate(5);
        return view('yonetim.kullanici.index', compact('list'));
    }

    public function form($id = 0)
    {
        $entry = new Kullanici;
        if($id > 0)
        {
            $entry = Kullanici::find($id);
        }

        return view('yonetim.kullanici.form', compact('entry'));
    }

    public function kaydet($id = 0)
    {
        $validator = validator(request()->all(), [
            'adsoyad' => 'required',
            'email'   => 'required|unique:kullanici,email,'.$id.',id,deleted_at,NULL'
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
            $userObj = Kullanici::find($id);
        }
        else
        {
            $userObj = new Kullanici();
        }

        $userObj->adsoyad = request('adsoyad');
        $userObj->email   = request('email');
        $userObj->aktif_mi = request()->has('aktif_mi') ? 1 : 0;
        $userObj->yonetici_mi = request()->has('yonetici_mi') ? 1 : 0;

        if(request()->filled('sifre'))
        {
            $userObj->sifre = Hash::make(request('sifre'));
        }

        $userObj->save();

       KullaniciDetay::updateOrCreate(
            ['kullanici_id' => $userObj->id],
            [
                'adres'       => request('adres'),
                'telefon'     => request('telefon'),
                'ceptelefonu' => request('ceptelefonu')
            ]
        );

        return redirect()
            ->route('yonetim.kullanici.duzenle', $userObj->id)
            ->with('mesaj', ($id > 0 ? 'Guncellendi' : 'Kaydedildi'))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Kullanici::destroy($id);

        return redirect()
            ->route('yonetim.kullanici')
            ->with('mesaj', 'Kayit silindi')
            ->with('mesaj_tur', 'success');
    }

    public function indexPost()
    {
        if(request()->filled('aranan'))
        {
            request()->flash();
            $aranan = request('aranan');
            $list = Kullanici::where('adsoyad', 'like', "%$aranan%")
                ->orWhere('email', 'like', "%$aranan%")
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
        else
        {
            $list = Kullanici::orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('yonetim.kullanici.index',compact('list'));
    }

}
