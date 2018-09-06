<h1>{{ config('app.name')  }}</h1>
<p>Merhaba {{ $kullanici->adsoyad }}, Kaydiniz basarili bir sekilde yapildi</p>
<p>Kaydinizi aktivlesdirmek isin <a href="{{ config('app.url')  }}/kullanici/aktiflestir/{{ $kullanici->aktivasyon_anahtari }}">tikla</a>veya asagidaki baglantiyi tarayinizda acin </p>
<p>{{ config('app.url')  }}/kullanici/aktiflestir/{{ $kullanici->aktivasyon_anahtari }}</p>