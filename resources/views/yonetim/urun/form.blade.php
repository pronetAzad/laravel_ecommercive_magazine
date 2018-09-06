@extends('yonetim.layouts.master')
@section('title', 'Urun Yonetimi')
@section('content')
    <h1 class="page-header">Urun Yonetimi</h1>

    <form method="post" action="{{ route('yonetim.urun.kaydet', @$entry->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{ @$entry->id > 0 ? 'Guncelle' : 'Kaydet' }}
            </button>
        </div>
        <h2 class="sub-header">
            Urun {{ @$entry->id > 0 ? 'Duzenle' : 'Ekle' }}
        </h2>

        @include('layouts.partials.errors')
        @include('layouts.partials.alert')

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="adsoyad">Urun Adi</label>
                    <input type="text" class="form-control"
                           id="urun_adi" name="urun_adi"
                           placeholder="Urun Adi"
                           value="{{ old('urun_adi', $entry->urun_adi) }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="aciklama">Aciklama</label>
                    <textarea class="form-control"
                           id="aciklama" name="aciklama"
                           placeholder="Aciklama">{{ old('urun_adi', $entry->aciklama) }}</textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="fiyati">Fiyati</label>
                    <input type="text" class="form-control"
                           id="fiyati" name="fiyati"
                           placeholder="Fiyati"
                           value="{{ old('fiyati', $entry->fiyati) }}">
                </div>
            </div>
        </div>
        
        <div class="checkbox">
            <label>
                <input type="hidden" name="goster_slider" value="0">
                <input type="checkbox" name="goster_slider" value="1"
                {{ old('goster_slider', $entry->detay->goster_slider) ? 'checked' : '' }}> Slider Goster
            </label>

            <label>
                <input type="hidden" name="goster_gunun_firsati" value="0">
                <input type="checkbox" name="goster_gunun_firsati" value="1" {{ old('goster_gunun_firsati', $entry->detay->goster_gunun_firsati) ? 'checked' : '' }} > Slider Goster
            </label>

            <label>
                <input type="hidden" name="goster_one_cikan" value="0">
                <input type="checkbox" name="goster_one_cikan" value="1"
                        {{ old('goster_one_cikan', $entry->detay->goster_one_cikan) ? 'checked' : '' }}> One cikan Alaninda Goster
            </label>

            <label>
                <input type="hidden" name="goster_cok_satan" value="0">
                <input type="checkbox" name="goster_cok_satan" value="1"
                        {{ old('goster_cok_satan', $entry->detay->goster_cok_satan) ? 'checked' : '' }}> Cok satan Urunleri goster
            </label>

            <label>
                <input type="hidden" name="goster_indirimli" value="0">
                <input type="checkbox" name="goster_indirimli" value="1"
                        {{ old('goster_indirimli', $entry->detay->goster_indirimli) ? 'checked' : '' }}> Indirimli Urunleri goster
            </label>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="kategoriler">Kategoriler</label>
                    <select name="kategoriler[]" class="form-control" id="kategoriler" multiple>
                        @foreach($kategori as $value)
                            <option value="{{ $value->id }}"
                            {{ collect(old('kategoriler', $urun_karegoriler))->contains($value->id) ? 'selected' : '' }}>
                            {{$value->kategori_adi }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            @if($entry->detay->urun_resmi != NULL)
                <img src="{{ asset('uploads/urunler/'.$entry->detay->urun_resmi) }}"
                     alt="Resim" style="height: 100px; margin-right: 20px" class="thumbnail pull-left">
            @endif
            <label for="urun_resmi">Ürün Resmi</label>
            <input type="file" name="urun_resmi" id="urun_resmi">
        </div>
        
    </form>
@endsection
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('js')
    <script src="//cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(function () {
           $("#kategoriler").select2({
               placeholder: "Kategori vacib sahedi"
           });

           CKEDITOR.replace('aciklama');
        });
    </script>
@endsection