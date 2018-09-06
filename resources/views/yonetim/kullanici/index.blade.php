@extends('yonetim.layouts.master')
@section('title', 'Kullanici yonetimi')
@section('content')
    <h1 class="page-header">Kullanici Yonetimi</h1>

    @include('layouts.partials.alert')

    <h3 class="sub-header">Kullanici Listesi</h3>

    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{ route('yonetim.kullanici.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.kullaniciPost') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan"
                       id="aranan" placeholder="Ad, Email Ara..." value="{{ old('aranan')  }}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{ route('yonetim.kullanici') }}" class="btn btn-primary" id="temizle">Temizle</a>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Ad Soyad</th>
                <th>Email</th>
                <th>Aktif Mi</th>
                <th>Yonetici Mi</th>
                <th>Kayir Tariyi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->adsoyad }}</td>
                    <td>{{ $entry->email }}</td>
                    <td>
                        @if($entry->aktif_mi)
                            <span class="label label-success">Aktif</span>
                         @else
                            <span class="label label-warning">Aktif</span>
                        @endif
                    </td>
                    <td>
                        @if($entry->yonetici_mi)
                            <span class="label label-success">Yönetici</span>
                        @else
                            <span class="label label-warning">Müştəri</span>
                        @endif
                    </td>
                    <td>{{  Carbon\Carbon::parse($entry->created_at)->format('M d Y H:s') }}</td>
                    <td style="width: 100px">
                        <a href="{{ route('yonetim.kullanici.duzenle', $entry->id) }}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzənlə">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{ route('yonetim.kullanici.sil', $entry->id) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin siniz?')">
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