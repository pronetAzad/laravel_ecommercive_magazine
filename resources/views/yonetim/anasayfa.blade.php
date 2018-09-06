@extends('yonetim.layouts.master')
@section('title', 'Anasayfa')
@section('content')
    <h1 class="page-header">Dashboard</h1>
    <section class="row text-center placeholders">
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Bekleyen Sifaris</div>
                <div class="panel-body">
                    <h4>{{ \App\Library\CommonFunctions::Dashboard()['bekleyen_sifaris'] }}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Tamamlanan Sifaris</div>
                <div class="panel-body">
                    <h4>{{ \App\Library\CommonFunctions::Dashboard()['tamamlanan_sifaris'] }}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Ürün</div>
                <div class="panel-body">
                    <h4>{{ \App\Library\CommonFunctions::Dashboard()['toplam_urun'] }}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Kullanici</div>
                <div class="panel-body">
                    <h4>{{ \App\Library\CommonFunctions::Dashboard()['toplam_kullanici'] }}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Cok satan Urunler</div>
                <div class="panel-body">
                    <canvas id="chartCokSatan"></canvas>
                </div>
            </div>

        </div>
    </section>

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <script>

        @php
            $labels = "";
            $data = "";

            foreach ($cok_satan_urunler as $rapor)
            {
                $labels .= "\"$rapor->urun_adi\",";
                $data .= "$rapor->adet, ";
            }
        @endphp

        var ctx = document.getElementById("chartCokSatan").getContext('2d');
        var chartCokSatan = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [{!! $labels !!}],
                datasets: [{
                    label: 'Cok satan Urunler',
                    data: [{!! $data !!}],
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                  position: 'bottom',
                  display: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    </script>
@endsection

