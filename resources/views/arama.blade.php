@extends('layouts.master')
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('anasayfa') }}">Anasayfa</a></li>
            <li class="action">Arama Sonucu</li>
        </ol>

        <div class="products bg-content">
            <form id="urun_sayfala" action="{{ route('urun_ara')  }}" method="post">
                {{ csrf_field() }}
                <div class="col-md-12" align="right">
                    <label>Sira:</label>
                    <select name="sira" class="form-control">
                        <option value="4">4</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </form>
            <div class="row">
                @if(count($urunler) == 0)
                    <div class="col-md-12 text-center alert alert-danger">
                        Bir urun bulunmadi!
                    </div>
                @endif
                @foreach($urunler as $urun)
                    <div class="col-md-3 product">
                        <a href="{{ route('urun', $urun->slug)  }}"><img src="img/tab2.jpg"></a>
                        <p><a href="{{ route('urun', $urun->slug)  }}">{{ $urun->urun_adi }}</a></p>
                        <p class="price">{{ $urun->fiyati  }} Azn</p>
                    </div>
                @endforeach
            </div>
            <span style="float: right;">{{ $urunler->appends(['aranan' => old('aranan')])->links() }}</span>
        </div>

    </div>
@endsection
{{--@section('js')
    <script>
        $('select[name="sira"]').on('change',function(){
                var sira = $(this).val(),
                    _token = '{{ csrf_token() }}';
            $.post('{{ route('urun_ara') }}',{'sira' : sira,'_token' : _token},function(response){

            });
        });
    </script>
@endsection--}}