@extends('layouts.master')
@section('title', $kategori->kategori_adi )
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('anasayfa') }}">Anasayfa</a></li>
            <li class="active">{{ $kategori->kategori_adi  }}</li>
        </ol>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Kategori Adı</div>
                    @if(count($alt_kategori) > 0)
                        <div class="panel-body">
                            <h3>Alt Kategoriler</h3>
                            <div class="list-group categories">
                                @foreach($alt_kategori as $value)
                                    <a href="{{ route('kategori', $value->slug)  }}" class="list-group-item">
                                        <i class="fa fa-arrow-circle-right"></i> {{ $value->kategori_adi  }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-light">
                            Bu karegotiya alt kategoriya bulunmadi
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="products bg-content">
                    @if(count($urunler) > 0)
                        Sırala
                        <a href="?order=cok_satan" class="btn btn-default">Çok Satanlar</a>
                        <a href="?order=yeni" class="btn btn-default">Yeni Ürünler</a>
                        <hr>
                    @endif
                    @if(count($urunler) == 0)
                        <div class="alert alert-danger">Bu kategoriyada urun bulunmadi</div>
                    @endif
                    <div class="row">
                        @foreach($urunler as $value)
                            <div class="col-md-3 product">
                                <a href="{{ route('urun', $value->slug )  }}"><img src="/img/kategori/kate1.jpg"></a>
                                <p><a href="{{ route('urun', $value->slug) }}">{{ $value->urun_adi  }}</a></p>
                                <p class="price">{{ $value->fiyati }} Azn</p>
                                <p><a href="javascript:void(0);" class="btn btn-theme sepet_ekle" data-id="{{ $value->id }}">Sepete Ekle</a></p>
                            </div>
                        @endforeach
                    </div>
                        <span style="float: right">{{  request()->has('order') ? $urunler->appends(['order' => request('order')])->links() : $urunler->links() }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.sepet_ekle').click(function () {
            var id = $(this).data('id'),
                _token = '{{ csrf_token() }}';

            $.post('{{ route('sepet.ekle') }}', {'id': id, '_token': _token  }, function (responce) {
                window.location = '/sepet';
            });

        });
    </script>
@endsection