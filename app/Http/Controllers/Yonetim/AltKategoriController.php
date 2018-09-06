<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AltKategoriController extends Controller
{
    function index()
    {
        $id = request('id');
        $alt_kategori_list = Kategori::where('ust_id', $id)->get();

        return response()->json($alt_kategori_list);
    }

    public function kaydet()
    {
        $id     = request('id');
        $slug   = str_slug(request('alt_kategori_adi'));

        request()->merge(['slug' => $slug]);

        $validator = validator(request()->all(), [
            'alt_kategori_adi' => 'required',
            'slug'             => 'unique:kategori,slug'
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

        $userObj->kategori_adi = request('alt_kategori_adi');
        $userObj->slug         = request('slug');
        $userObj->ust_id       = request('ust_id');
        $userObj->save();

        return response()->json(['status' => 'success']);
    }

    public function sil()
    {
        $id = request('id');
        Kategori::destroy($id);
    }
}
