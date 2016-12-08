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
            var filter_status_id = $('#filter_status_id :selected');
            var filter_client_id = $('#filter_client_id :selected');
            var filter_format_id = $('#filter_format_id :selected');
            var filter_place_id = $('#filter_place_id :selected');
            var values = [];
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

            if (filter_status_id.length > 0) {
                values = [];
                filter_status_id.each(function (i, selected) {
                    values.push($(selected).text());
                });
                if ($.inArray(data[0], values) == -1) {
                    return false;
                }
            }

            if (filter_client_id.length > 0) {
                values = [];
                filter_client_id.each(function (i, selected) {
                    values.push($(selected).text());
                });
                if ($.inArray(data[1], values) == -1) {
                    return false;
                }
            }

            if (filter_format_id.length > 0) {
                values = [];
                filter_format_id.each(function (i, selected) {
                    values.push($(selected).text());
                });
                if ($.inArray(data[3], values) == -1) {
                    return false;
                }
            }

            if (filter_place_id.length > 0) {
                values = [];
                filter_place_id.each(function (i, selected) {
                    values.push($(selected).text());
                });
                if ($.inArray(data[6], values) == -1) {
                    return false;
                }
            }

            return true;
        }
    );

    $('#filter_active, #filter_work_hours, .filter').on('change', function () {
        $('.datatable').DataTable().draw();
    });

    /**
     * Date picker
     */
    $('.datepicker').datepicker({
        format: 'dd.mm.yyyy',
        language: 'ru',
        autoclose: true
    });

    /**
     * Date picker jQuery version fix
     *
     * @returns {*}
     */
    Object.getPrototypeOf($('.datepicker')).size = function() { return this.length; };

    /**
     * Date mask
     */
    $('.datepicker').mask("00.00.0000", {
        placeholder: "__.__.____"
    });

    /**
     * Phone mask
     */
    $('.phone').mask("+7 (000) 000-00-00", {
        placeholder: "+7 (___) ___-__-__"
    });

    /**
     * Time mask
     */
    $('.time').mask("00:00", {
        placeholder: "00:00"
    });

    /**
     * Select2
     */
    $(".select2").select2();

    /**
     * Edit column
     */
    $("#events a[data-name=\"status_id\"]").editable({ source: "/api/v1/events/statuses", url: "/api/v1/events/save" });
    $("#events a[data-name=\"client_id\"]").editable({ source: "/api/v1/events/clients",  url: "/api/v1/events/save" });
    $("#events a[data-name=\"format_id\"]").editable({ source: "/api/v1/events/formats",  url: "/api/v1/events/save" });
    $("#events a[data-name=\"persons\"]").editable({                                      url: "/api/v1/events/save" });
    $("#events a[data-name=\"tables\"]").editable({                                       url: "/api/v1/events/save" });
    $("#events a[data-name=\"place_id\"]").editable({  source: "/api/v1/events/places",   url: "/api/v1/events/save" });

    $('input#cost, input#markup').on('keyup', function () {
        $('input#price').val(
            Math.round(
                Number($('input#cost').val()) +
                Number($('input#cost').val()) / 100 * Number($('input#markup').val())
            )
        );
    });

    /**
     * Set maximum discount
     */
    $('input#discount').on('keyup, change', function () {
        console.log($(this).val());
        if (Number($(this).val()) > Number($(this).data('max'))) {
            $(this).val($(this).data('max'));
        }
        if (Number($(this).val()) < 0) {
            $(this).val(0);
        }
    });

    setAbsolutionAndPercentsEvents('service');
    setAbsolutionAndPercentsEvents('administration');
    setAbsolutionAndPercentsEvents('fare');
    setAbsolutionAndPercentsEvents('equipment');
    setAbsolutionAndPercentsEvents('mirror_collection');
    setAbsolutionAndPercentsEvents('extras');
});

function setAbsolutionAndPercentsEvents(name) {
    var leftElement = $('#' + name + '_absolution');
    var rightElement = $('#' + name + '_percents');
    var hiddenElement = $('#' + name);

    if (!leftElement.length || !rightElement.length || !hiddenElement.length) {
        return false;
    }

    leftElement.on('keyup', function () {
        hiddenElement.val(leftElement.val());
        rightElement.val('');
    });

    rightElement.on('keyup', function () {
        hiddenElement.val(rightElement.val() + '%');
        leftElement.val('');
    });
}

/**
 * Set list filter active
 * @param el
 */
function setFilter(el) {
    $(el).toggleClass('active');
    $('table.datatable').DataTable().draw();
}