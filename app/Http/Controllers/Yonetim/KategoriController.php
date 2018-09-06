<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index()
    {
        $aranan = request('aranan');
        $ust_id = request('ust_id');

        $list = Kategori::with('ust_kategori')
            ->where('kategori_adi', 'like', "%$aranan%")
            ->where('ust_id', $ust_id)
            ->orderBy('id', 'desc')
            ->paginate(8);

        $anakategoriya = Kategori::whereNull('ust_id')->get();

        return view('yonetim.kategori.index', compact('list', 'anakategoriya'));
    }

    public function form()
    {
        $entry = Kategori::whereNull('ust_id')
                        ->whereNull('deleted_at')
                        ->get();

        return view('yonetim.kategori.form', compact('entry'));
    }

    public function kaydet()
    {
        $id   = request('id');
        $slug = str_slug(request('kategori_adi'));
        request()->merge(['slug' => $slug]);

        $validator = validator(request()->all(), [
            'kategori_adi' => 'required',
            'slug'   => 'unique:kategori,slug'
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'messag' => $validator->errors()]);
        }

        if($id > 0)
        {
            $userObj = Kategori::find($id);
        }
        else
        {
            $userObj = new Kategori();
        }

        $userObj->kategori_adi = request('kategori_adi');
        $userObj->slug   = request('slug');
        $userObj->ust_id = NULL;
        $userObj->save();

        return response()->json(['status' => 'success']);
    }

    public function sil()
    {
        $id = request('id');
        Kategori::destroy($id);
    }

}
