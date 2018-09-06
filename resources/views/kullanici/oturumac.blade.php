@extends('layouts.master')
@section('title', 'Oturumac')
@section('content')
    <div class="container">
        <div class="row">
            @include('layouts.partials.alert');
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Oturum Aç</div>
                    @if(!empty($errors->first('error')))
                        <div class="col-md-12 container text-center">
                            <div class="alert alert-danger"> <span>{{ $errors->first('error') }}</span>  </div>
                        </div>
                    @endif
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('kullanici.oturumac') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Email</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sifre" class="col-md-4 control-label">Şifre</label>
                                <div class="col-md-6">
                                    <input id="sifre" type="password" class="form-control" name="sifre" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="benihatirla" checked> Beni hatırla
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Giriş yap
                                    </button>

                                    {{--<a class="btn btn-link" href="{{ route('kullanici.sifre_form') }}">
                                        Şifremi Unuttum
                                    </a>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection