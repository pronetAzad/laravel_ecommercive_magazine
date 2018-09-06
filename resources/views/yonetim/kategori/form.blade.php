@extends('yonetim.layouts.master')
@section('title', 'Kategori Yonetimi')
@section('content')
    <h1 class="page-header">Kategori MSK</h1>

    <div class="col-md-6">
        <div class="table-scrollable">
            <table class="table table-hover table-bordered" id="kategori_table">
                <thead>
                <tr>
                    <th> # </th>
                    <th> Kategorinin Adi </th>
                    <th class="text-center">
                        <a href="#" class="btn btn-primary" id="eleva_et"> Əlavə et</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                        @foreach($entry as $key=>$value)
                            <tr tr_id="{{ $value->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $value->kategori_adi }}</td>
                                <td>
                                    <a href="#" class="btn btn-xl btn-success purple" data-toggle="tooltip" data-placement="top" title="Düzənlə">
                                        <span class="fa fa-pencil"></span>
                                    </a>
                                    <a href="#" class="btn btn-xl btn-danger red" data-toggle="tooltip" data-placement="top" title="Sil">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
            <script type="text/html" id="kategori_table_row">
                <tr tr_id='0'>
                    <td></td>
                    <td> <input type='text' class='form-control' name='kategori_adi' id='kategori_adi' placeholder='Kategori Adi'></td>
                    <td>
                        <a href='#' class='btn btn-xl btn-info blue' data-toggle='tooltip' data-placement='top' title='Yatda saxla'>
                            <span class='fa fa-save'></span></a>
                        <a href='#' class='btn btn-xl btn-warning yellow' data-toggle='tooltip' data-placement='top' title='Imtina'>
                            <span class='fa fa-remove'></span></a>
                    </td>
                </tr>
            </script>

        </div>
    </div>

    <div class="col-md-6">
        <div class="table-scrollable">
            <table class="table table-hover table-bordered" id="alt_kategori_table">
                <thead>
                <tr>
                    <th> # </th>
                    <th> Alt Kategorinin Adi </th>
                    <th class="text-center">
                        <a href="#" class="btn btn-primary" id="alt_eleva_et"> Əlavə et</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <script type="text/html" id="alt_kategori_row">
                <tr data-id='0'>
                    <td></td>
                    <td> <input type='text' class='form-control' name='alt_kategori_adi' id='alt_kategori_adi' placeholder='Alt Kategori Adi'></td>
                    <td>
                        <a href='#' class='btn btn-xl btn-info blue' data-toggle='tooltip' data-placement='top' title='Yatda saxla'>
                            <span class='fa fa-save'></span></a>
                        <a href='#' class='btn btn-xl btn-warning yellow' data-toggle='tooltip' data-placement='top' title='Imtina'>
                            <span class='fa fa-remove'></span></a>
                    </td>
                </tr>
            </script>

        </div>
    </div>

    <script type="underscore/template" id="alt_category_row">
        <tr data-id="<%- id %>" data-ust-id="<%- ust_id %>">
            <td></td>
            <td><%- kategori_adi %></td>
            <td>
                <a href="#" class="btn btn-xl btn-success purple" data-toggle="tooltip" data-placement="top" title="Düzənlə">
                    <span class="fa fa-pencil"></span>
                </a>
                <a href="#" class="btn btn-xl btn-danger red" data-toggle="tooltip" data-placement="top" title="Sil">
                    <span class="fa fa-trash"></span>
                </a>
            </td>
        </tr>
    </script>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js\underscore-min.js') }}"></script>
    <script>
        var modal = $('#kategori_table tbody'),
            altModal = $('#alt_kategori_table tbody');

        $('#eleva_et').click(function () {
            var tb_row = $('#kategori_table_row').html();
            modal.prepend(tb_row);
            kategoriOrder(modal);
        });

        modal.on('click', 'tr:first .yellow', function () {
            $(this).parent('td').parent('tr').remove();
            kategoriOrder(modal);
        });

        modal.on('click', 'tr .blue', function () {
            var kategori_adi = $('[name="kategori_adi"]').val(),
                tr_id  = $(this).parent('td').parent('tr').attr('tr_id'),
                _token = '{{ csrf_token() }}';

            $.post('{{ route('yonetim.kategori.kaydet') }}',
                {'kategori_adi': kategori_adi, 'id' : tr_id, '_token': _token},
                function (response) {

                if(response.status == 'error')
                {
                    var message = ((typeof response.messag['kategori_adi'] !== 'undefined')
                                  ? response.messag['kategori_adi']
                                  : response.messag['slug']);
                    swal("Serh",  ""+ message +"", "error");
                }

                if(response.status == 'success')
                {
                    swal({
                        title: "Kategori Adi",
                        text: "Kategori Adi yuklendi",
                        icon: "success",
                        buttons: false,
                    });
                    setTimeout(function(){location.reload();}, 1000);
                }
            });
        });

        modal.on('click', 'tr .red', function () {
            var id     = $(this).parent('td').parent('tr').attr('tr_id'),
                _token = '{{ csrf_token() }}';

            swal({
                title: "Kategori",
                text: "Kategori silmeg istersin!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.post(' {{ route('yonetim.kategori.sil') }} ', {'id': id, '_token': _token}, function (response) {
                        location.reload();
                    });
                }
            });
        });

        modal.on('click', 'tr .purple', function () {
           var td   = $(this).closest('tr').children('td'),
               th   = $(this).parent('td').parent('tr'),
               sayi = td.eq(0).text(),
               adi  = td.eq(1).text();

           $(this).parent('td').parent('tr').html("<td> " + sayi + "</td>" +
                        "<td> <input type='text' class='form-control' name='kategori_adi' id='kategori_adi' placeholder='Kategori Adi' value='"+ adi +"'>  </td>" +
                        "<td> <a href='#' class='btn btn-xl btn-info blue' data-toggle='tooltip' data-placement='top' title='Yatda saxla'>" +
                        "<span class='fa fa-save'></span></a>\n" +
                        "<a href='#' class='btn btn-xl btn-warning yellow' data-toggle='tooltip' data-placement='top' title='Imtina'>" +
                        "<span class='fa fa-remove'></span></a> </td>");

           th.find('.yellow').click(function () {
              th.html("<td> " + sayi + "</td>" +
                  "<td> "+ adi +" </td>" +
                  "<td> <a href='#' class='btn btn-xl btn-success purple' data-toggle='tooltip' data-placement='top' title='Düzənlə'>" +
                  "<span class='fa fa-pencil'></span></a>\n" +
                  "<a href='#' class='btn btn-xl btn-danger red' data-toggle='tooltip' data-placement='top' title='Sil'>" +
                  "<span class='fa fa-trash'></span></a> </td>");
           });

        });

        modal.on('click', 'tr', function () {
            modal.find('tr').removeAttr("class");
            $(this).attr('class', 'active');

            var id     = $(this).attr('tr_id'),
                _token = '{{ csrf_token() }}';
                loader(1);

            altModal.attr('ust_id', id);

            $.post('{{ route('yonetim.altKategori') }}', {'id' : id, '_token' : _token}, function (res) {
                $('#alt_kategori_table tbody').html('');

                _.each(res,function(cat){
                    var template = _.template($('#alt_category_row').html());
                    $('#alt_kategori_table tbody').append(template(cat));
                });

                kategoriOrder(altModal);
                loader(0);
            });
        });

        $('#alt_eleva_et').click(function () {
            var td_row = $('#alt_kategori_row').html();
            altModal.prepend(td_row);
            kategoriOrder(altModal);
        });

        altModal.on('click', 'tr .blue', function () {
            var alt_kategori_adi = $('[name="alt_kategori_adi"]').val(),
                ust_id = altModal.attr('ust_id');
                tr_id  = $(this).parent('td').parent('tr').attr('data-id'),
                _token = '{{ csrf_token() }}';

            $.post('{{ route('yonetim.altKategori.kaydet') }}',
                {'alt_kategori_adi': alt_kategori_adi, 'id' : tr_id, 'ust_id': ust_id, '_token': _token},
                function (response) {

                    if(response.status == 'error')
                    {
                        var message = ((typeof response.messag['alt_kategori_adi'] !== 'undefined')
                            ? response.messag['alt_kategori_adi']
                            : response.messag['slug']);
                        swal("Serh",  ""+ message +"", "error");
                    }

                    if(response.status == 'success')
                    {
                        swal({
                            title: "Kategori Adi",
                            text: "Alt Kategori Adi yuklendi",
                            icon: "success"
                        });
                        modal.find('tr.active').trigger('click');
                    }
                });
        });

        altModal.on('click', 'tr:first .yellow', function () {
            $(this).parent('td').parent('tr').remove();
            kategoriOrder(altModal);
        });

        altModal.on('click', 'tr .purple', function () {
            var td   = $(this).closest('tr').children('td'),
                th   = $(this).parent('td').parent('tr'),
                sayi = td.eq(0).text(),
                adi  = td.eq(1).text();

            $(this).parent('td').parent('tr').html("<td> " + sayi + "</td>" +
                "<td> <input type='text' class='form-control' name='alt_kategori_adi' id='alt_kategori_adi' placeholder='Alt Kategori Adi' value='"+ adi +"'>  </td>" +
                "<td> <a href='#' class='btn btn-xl btn-info blue' data-toggle='tooltip' data-placement='top' title='Yatda saxla'>" +
                "<span class='fa fa-save'></span></a>\n" +
                "<a href='#' class='btn btn-xl btn-warning yellow' data-toggle='tooltip' data-placement='top' title='Imtina'>" +
                "<span class='fa fa-remove'></span></a> </td>");

            th.find('.yellow').click(function () {
                th.html("<td> " + sayi + "</td>" +
                    "<td> "+ adi +" </td>" +
                    "<td> <a href='#' class='btn btn-xl btn-success purple' data-toggle='tooltip' data-placement='top' title='Düzənlə'>" +
                    "<span class='fa fa-pencil'></span></a>\n" +
                    "<a href='#' class='btn btn-xl btn-danger red' data-toggle='tooltip' data-placement='top' title='Sil'>" +
                    "<span class='fa fa-trash'></span></a> </td>");
            });

        });

        altModal.on('click', 'tr .red', function () {
            var id     = $(this).parent('td').parent('tr').attr('data-id'),
                _token = '{{ csrf_token() }}';

            swal({
                title: "Alt Kategori",
                text: "Alt Kategori silmeg istersin!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.post(' {{ route('yonetim.altKategori.sil') }} ', {'id': id, '_token': _token}, function () {
                        modal.find('tr.active').trigger('click');
                    });
                }
            });
        });

        function kategoriOrder(modal){
            var count = 0;
            modal.find('tr').each(function () {
                $(this).find('td:eq(0)').text(++count);
            });
        }

    </script>
@endsection
