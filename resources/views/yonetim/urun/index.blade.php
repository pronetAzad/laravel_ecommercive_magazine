@extends('yonetim.layouts.master')
@section('title', 'Ürün yonetimi')
@section('content')
    <h1 class="page-header">Ürün Yonetimi</h1>

    @include('layouts.partials.alert')

    <h3 class="sub-header">Ürün Listesi</h3>

    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{ route('yonetim.urun.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.urun') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan"
                       id="aranan" placeholder="Ürün Ara..." value="{{ old('aranan')  }}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{ route('yonetim.urun') }}" class="btn btn-primary" id="temizle">Temizle</a>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Resim</th>
                <th>Slug</th>
                <th>Ürün Adi</th>
                <th>Fiyati</th>
                <th>Kayir Tariyi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>
                        <img src="{{ $entry->detay->urun_resmi != NULL  ?
                                    asset('uploads/urunler/'.$entry->detay->urun_resmi) :
                                    'http://via.placeholder.com/120x120?text=UrunResmi'
                                    }}" style="width: 120px;">
                    </td>
                    <td>{{ $entry->slug }}</td>
                    <td>{{ $entry->urun_adi }}</td>
                    <td>{{ $entry->fiyati }}</td>
                    <td>{{  Carbon\Carbon::parse($entry->created_at)->format('M d Y H:s') }}</td>
                    <td style="width: 100px">
                        <a href="{{ route('yonetim.urun.duzenle', $entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzənlə">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{ route('yonetim.urun.sil', $entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin siniz?')">
                            <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right">
            {{ $list->appends('aranan', old('aranan'))->links() }}
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#temizle').click(function () {

           $('#aranan').val('');
        });

        $(document).ready(function() {
            var count = 0;

            $('tbody tr').each(function () {
                $(this).find('td').eq(0).text(++count);
            });
        });
    </script>
@endsection