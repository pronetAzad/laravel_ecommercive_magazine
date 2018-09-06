<div class="list-group">
    <a href="{{ route('yonetim.anasayfa') }}" class="list-group-item">
        <span class="fa fa-fw fa-dashboard"></span> Giriş</a>
    <a href="{{ route('yonetim.urun') }}" class="list-group-item">
        <span class="fa fa-fw fa-cubes"></span> Ürünlər
        <span class="badge badge-dark badge-pill pull-right">
            {{ \App\Library\CommonFunctions::Dashboard()['toplam_urun'] }}
        </span>
    </a>
    <a href="{{ route('yonetim.kategori')  }}" class="list-group-item">
        <span class="fa fa-fw fa-cubes"></span> Kategoriler
        <span class="badge badge-dark badge-pill pull-right">
            {{ \App\Library\CommonFunctions::Dashboard()['toplam_kategori'] }}
        </span>
    </a>
    <a href="#" class="list-group-item collapsed" data-target="#submenu1"
       data-toggle="collapse"
       data-parent="#sidebar"><span class="fa fa-fw fa-folder"></span> Kategori Urunleri<span class="caret arrow"></span></a>
    <div class="list-group collapse" id="submenu1">
        <a href="#" class="list-group-item">Kategoriler</a>
        <a href="#" class="list-group-item">Category</a>
    </div>
    <a href="{{ route('yonetim.kullanici') }}" class="list-group-item">
        <span class="fa fa-fw fa-users"></span> Kullanicilar
        <span class="badge badge-dark badge-pill pull-right">
            {{ \App\Library\CommonFunctions::Dashboard()['toplam_kullanici'] }}
        </span>
    </a>
    <a href="#" class="list-group-item">
        <span class="fa fa-fw fa-shopping-cart"></span> Siparişlər
        <span class="badge badge-dark badge-pill pull-right">
            {{ \App\Library\CommonFunctions::Dashboard()['bekleyen_sifaris'] }}
        </span>
    </a>
</div>