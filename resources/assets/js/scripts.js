$(function () {
    $(".datatable").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "language": {
            url: "plugins/datatables/languages/ru.json"
        }
    });

    $('.datepicker').datepicker({
        format: 'dd.mm.yyyy',
        language: 'ru',
        autoclose: true
    });

    $('.datepicker').mask("00.00.0000", {
        placeholder: "__.__.____"
    });
});