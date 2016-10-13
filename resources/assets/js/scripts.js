$(function () {
    $(".datatable").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "language": {
            url: "plugins/datatables/languages/ru.json"
        }
    });

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var filter_active = Number($('#filter_active').val());
            var filter_work_hours = Number($('#filter_work_hours').val());
            var row = $('#' + settings.sTableId).DataTable().row(dataIndex).node().innerHTML;
            if (filter_active > 0) {
                switch (filter_active) {
                    case 1:
                        if (row.match(/data-active="1"/) == null) {
                            return false;
                        }
                        break;
                    case 2:
                        if (row.match(/data-active="0"/) == null) {
                            return false;
                        }
                        break;
                }
            }

            if (filter_work_hours > 0) {
                switch (filter_work_hours) {
                    case 1:
                        if (row.match(/data-work-hours="1"/) == null) {
                            return false;
                        }
                        break;
                    case 2:
                        if (row.match(/data-work-hours="0"/) == null) {
                            return false;
                        }
                        break;
                }
            }

            return true;
        }
    );

    $('#filter_active, #filter_work_hours').on('change', function () {
        $('#staff').DataTable().draw();
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