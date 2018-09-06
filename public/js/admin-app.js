$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function loader(state){
    if(state){
        $('.loader').show();
    }
    else{
        $('.loader').hide();
    }
}