$('.btn-back').click(function(){
    if(history.length === 1){
        window.location = url('/admin/')
    } else {
        history.back();
    }
});

$('.select-date').datepicker({
    autoclose: true,
    dateFormat: 'dd/mm/yy'
});

$('.select2-drop').select2({
    tags: true,
    placeholder: '',
    allowClear: true,
});

$(".btn-delete").click(function(){
    if (!confirm("Yakin menghapus data tersebut ?")){
        return false;
    }
});