@extends('yonetim.layouts.master')
@section('title', 'Kategori yonetimi')
@section('content')
    <h1 class="page-header">Kategori Yonetimi</h1>

    @include('layouts.partials.alert')

    <h3 class="sub-header">Kategori Listesi</h3>

    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{ route('yonetim.kategori.yeni') }}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{ route('yonetim.kategori') }}" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan"
                       id="aranan" placeholder="Kategori Ara..." value="{{ request('aranan')  }}">
                <label for="ust_id">Üst Kategori</label>
                <select name="ust_id" id="ust_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($anakategoriya as $value)
                        <option value="{{ $value->id }}" {{ request('ust_id') == $value->id ? 'selected' : ''  }}>
                            {{ $value->kategori_adi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{ route('yonetim.kategori') }}" class="btn btn-primary" id="temizle">Temizle</a>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Üst Karegori</th>
                <th>Slug</th>
                <th>Kategori Adi</th>
                <th>Kayit Tarihi</th>
            </tr>
            </thead>
            <tbody>
            @if(count($list) == 0)
                <tr>
                    <td colspan="5" class="text-center">Kayit bulunamadi!</td>
                </tr>
            @endif
            @foreach($list as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->ust_kategori->kategori_adi }}</td>
                    <td>{{ $entry->slug }}</td>
                    <td>{{ $entry->kategori_adi }}</td>
                    <td>{{  Carbon\Carbon::parse($entry->created_at)->format('M d Y H:s') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right">
            {{ $list->appends(['aranan' => request('aranan'), 'ust_id' => request('ust_id')])->links() }}
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