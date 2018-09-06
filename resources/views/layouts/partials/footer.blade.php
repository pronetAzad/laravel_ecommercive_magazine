<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">Eticaret Yazılımı &copy; 2018</div>
            <div class="col-md-6 text-right"><a href="http://www.uzaktankurs.com">Uzaktan Kurs</a></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/app.js"></script>
    <script>
        function loader(val){
            if(val){
                $('.loader').show();
            }
            else{
                $('.loader').hide();
            }
        }
    </script>
    @yield('js')
</footer>