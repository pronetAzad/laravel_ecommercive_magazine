@if(session()->has('mesaj_tur'))
    <div class="col-md-12 container text-center">
        <div class="alert alert-{{ session('mesaj_tur') }}"> <span>{{ session('mesaj') }}</span>  </div>
    </div>
@endif