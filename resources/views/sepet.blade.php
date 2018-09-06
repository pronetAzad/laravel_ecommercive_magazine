@extends('layouts.master')
@section('title', 'Sepet')
@section('content')
    <div class="container">
        <div class="bg-content">
            <h2>Sepet</h2>

            @if(session()->has('mesaj'))
                <div class="row">
                    <div class="alert alert-success">{{ session('mesaj') }}</div>
                </div>
            @endif

            @if(count(Cart::content()) > 0)
                <table class="table table-bordererd table-hover">
                    <tr>
                        <th colspan="2">Ürün</th>
                        <th>Adet Fiyati</th>
                        <th>Adet</th>
                        <th>Tutar</th>
                    </tr>

                    @foreach(Cart::content() as $urunCartItem)
                        <tr>
                            <td style="width: 120px;">
                                <img src="/img/tab2.jpg" width="100">
                            </td>
                            <td>
                                <a href="{{ route('urun', $urunCartItem->options->slug) }}">{{ $urunCartItem->name }}</a>
                                <br>
                                <input type="hidden" name="id" value="{{ $urunCartItem->rowId }}">
                                <input type="submit" class="btn btn-danger btn-xs" name="sepet" value="Sepetten Kaldir" >
                            </td>
                            <td>{{ $urunCartItem->price }} Azn</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-xs btn-default urun-adet-azalt" data-id="{{ $urunCartItem->rowId }}" data-adet="{{ $urunCartItem->qty - 1 }}">-</a>
                                <span style="padding: 10px 20px">{{ $urunCartItem->qty }}</span>
                                <a href="javascript:void(0)" class="btn btn-xs btn-default urun-adet-artir" data-id="{{ $urunCartItem->rowId }}" data-adet="{{ $urunCartItem->qty + 1 }}">+</a>
                            </td>
                            <td class="text-right">
                                {{ $urunCartItem->subtotal }} Azn
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" class="text-right">Alt Toplam</th>
                        <td class="text-right">{{ Cart::subtotal() }} Azn</td>
                    </tr>

                    <tr>
                        <th colspan="4" class="text-right">KDV</th>
                        <td class="text-right">{{ Cart::tax() }} Azn</td>
                    </tr>

                    <tr>
                        <th colspan="4" class="text-right">Genal Toplam</th>
                        <td>{{ Cart::total() }} Azn</td>
                    </tr>

                </table>
                <div>
                    <a href="{{ route('sepet.bosalt') }}" class="btn btn-info pull-left">Sepeti Boşalt</a>
                    <a href="{{ route('odeme') }}" class="btn btn-success pull-right btn-lg">Ödeme Yap</a>
                </div>
            @else
                <p>Sepetinizde urun yok!</p>
            @endif

        </div>
    </div>
@endsection

@section('js')
    <script>

        $('input[name="sepet"]').click(function () {
            var id = $('input[name="id"]').val(),
                _token = ' {{ csrf_token() }} ';
                swal({
                    title: "Sepet",
                    text: "Urun sepetini silmeg istersin!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        loader(1);
                        $.post(' {{ route('sepet.kaldir') }} ', {'id': id, '_token': _token}, function (response) {
                            loader(0);
                            location.reload();
                        });
                    }
                });
        });

        $('.urun-adet-azalt, .urun-adet-artir').on('click', function () {
            var id = $(this).data('id'),
                adet = $(this).data('adet'),
                _token = '{{ csrf_token() }}';

            loader(1);
            $.post('{{ route('sepet.guncelle') }}', {'id': id, 'adet': adet, '_token': _token}, function (response) {
                if(response.status == "success")
                {
                    loader(0);
                    location.reload();
                }
                else if(response.status == "error")
                {
                    loader(0);
                    swal("Adet", "Adet deyeri 1 ve 5 arasi olmalidi", "error");
                }
            });

        });




    </script>
@endsection