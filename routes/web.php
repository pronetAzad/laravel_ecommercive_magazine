<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'yonetim', 'namespace' => 'Yonetim'], function (){
   Route::redirect('/', '/yonetim/oturumac');
   Route::get('/oturumac', 'KullaniciController@oturumAc')->name('yonetim.oturumac');
   Route::post('/oturumac', 'KullaniciController@oturumAcProses')->name('yonetim.oturumac.proses');
   Route::get('/kapat', 'AnasayfaController@yonetimikapat')->name('yonetim.kapat');

   Route::group(['middleware' => 'yonetim'], function (){
       Route::get('/anasayfa', 'AnasayfaController@index')->name('yonetim.anasayfa');

       // yonetim/kullanici/
       Route::group(['prefix' => 'kullanici'], function () {
            Route::get('/', 'KullaniciController@index')->name('yonetim.kullanici');
            Route::post('/', 'KullaniciController@indexPost')->name('yonetim.kullaniciPost');
            Route::get('/yeni', 'KullaniciController@form')->name('yonetim.kullanici.yeni');
            Route::get('/duzenle/{id}', 'KullaniciController@form')->name('yonetim.kullanici.duzenle');
            Route::post('/kaydet/{id?}', 'KullaniciController@kaydet')->name('yonetim.kullanici.kaydet');
            Route::get('/sil/{id}', 'KullaniciController@sil')->name('yonetim.kullanici.sil');
       });

       // yonetim/kategori/
       Route::group(['prefix' => 'kategori'], function () {
           Route::match(['get', 'post'], '/', 'KategoriController@index')->name('yonetim.kategori');
           Route::get('/yeni', 'KategoriController@form')->name('yonetim.kategori.yeni');
           Route::post('/kaydet', 'KategoriController@kaydet')->name('yonetim.kategori.kaydet');
           Route::post('/sil', 'KategoriController@sil')->name('yonetim.kategori.sil');
       });

       // yonetim/altKategori/
       Route::group(['prefix' => 'altKategori'], function () {
           Route::post('/', 'AltKategoriController@index')->name('yonetim.altKategori');
           Route::post('/kaydet', 'AltKategoriController@kaydet')->name('yonetim.altKategori.kaydet');
           Route::post('/sil', 'AltKategoriController@sil')->name('yonetim.altKategori.sil');
       });

       // yonetim/urun/
       Route::group(['prefix' => 'urun'], function () {
           Route::match(['get', 'post'], '/', 'UrunController@index')->name('yonetim.urun');
           Route::get('/yeni', 'UrunController@form')->name('yonetim.urun.yeni');
           Route::get('/duzenle/{id}', 'UrunController@form')->name('yonetim.urun.duzenle');
           Route::post('/kaydet/{id?}', 'UrunController@kaydet')->name('yonetim.urun.kaydet');
           Route::get('/sil/{id}', 'UrunController@sil')->name('yonetim.urun.sil');
       });
   });
});

Route::get('/', 'AnasayfaController@index')->name('anasayfa');
Route::get('/kategori/{slug_kategoriadi}', 'KategoriController@index')->name('kategori');
Route::get('/urun/{slug_urunadi?}', 'UrunController@index')->name('urun');
Route::post('/ara', 'UrunController@ara')->name('urun_ara');
Route::get('/ara', 'UrunController@ara')->name('urun_ara');

Route::group(['prefix' => 'sepet'], function () {
    Route::get('/', 'SepetController@index')->name('sepet');
    Route::post('/ekle', 'SepetController@ekle')->name('sepet.ekle');
    Route::post('/kaldir', 'SepetController@kaldir')->name('sepet.kaldir');
    Route::get('/bosalt', 'SepetController@bosalt')->name('sepet.bosalt');
    Route::post('/guncelle', 'SepetController@guncelle')->name('sepet.guncelle');
});

Route::get('/odeme', 'OdemeController@index')->name('odeme');
Route::post('/odeme', 'OdemeController@odemeyap')->name('odemeyap');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/siparisler', 'SiparislerController@index')->name('siparisler');
    Route::get('/siparisler/{id}', 'SiparislerController@detay')->name('siparis');
});

Route::group(['prefix' => 'kullanici'], function () {
    Route::get('/oturumac', 'KullaniciController@giris_form')->name('kullanici.oturumac');
    Route::post('/oturumac', 'KullaniciController@giris');
    Route::get('/kaydol', 'KullaniciController@kaydol_form')->name('kullanici.kaydol');
    Route::post('/kaydol', 'KullaniciController@kaydol');
    Route::get('/aktiflestir/{anahtar}', 'KullaniciController@aktiflestir')->name('aktiflestir');
    Route::post('/oturumukapat', 'KullaniciController@oturumukapat')->name('kullanici.oturumukapat');
});

Route::get('/test/mail', function () {
    return new App\Mail\KullaniciKayitMail();
});



