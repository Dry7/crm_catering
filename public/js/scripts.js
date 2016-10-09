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
});