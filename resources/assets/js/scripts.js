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
            var filter_kitchen = $('#filter_kitchen li a.active');
            var filter_type = $('#filter_type li a.active');
            var row = $('#' + settings.sTableId).DataTable().row(dataIndex).node().innerHTML;
            if (filter_active > 0) {
                /** Filter active staff */
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

            /** Filter work hours */
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

            /** Filter product kitchen */
            if (filter_kitchen.length > 0) {
                var actives = [];
                filter_kitchen.each(function () {
                    actives.push($(this).data('value'));
                });
                if ($.inArray(data[3], actives) == -1) {
                    return false;
                }
            }

            /** Filter product type */
            if (filter_type.length > 0) {
                var checked = [];
                filter_type.each(function () {
                    checked.push($(this).data('value'));
                });
                if ($.inArray(data[4], checked) == -1) {
                    return false;
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

/**
 * Set list filter active
 * @param el
 */
function setFilter(el) {
    $(el).toggleClass('active');
    $('table.datatable').DataTable().draw();
}