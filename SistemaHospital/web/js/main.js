/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

(function ($) {
    $(document).ready(function () {
        hljs.initHighlightingOnLoad();

        // Datetime picker initialization.
        // See http://eonasdan.github.io/bootstrap-datetimepicker/
        $('.datetimepicker').datetimepicker({
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check-circle-o',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            },
            format: "DD/MM/YYYY LT",
            locale: 'es'
        });

        $('.datetimepickerWithoutTime').datetimepicker({
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check-circle-o',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            },
            format: "DD/MM/YYYY",
            locale: 'es'
        });

        $('.datetimepickerWithoutDate').datetimepicker({
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check-circle-o',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            },
            format: "LT",
            locale: 'es'
        });

        /*Date time picker arreglados   */
        // $('#filtro_reserva_fechaIni').data("DateTimePicker").maxDate(e.date);
        // $('#filtro_operacion_fechaIni').data("DateTimePicker").maxDate(e.date);
        // $('#graffechaHasta').data("DateTimePicker").maxDate(datetime);

        $("#filtro_operacion_fechaIni").on("dp.change", function (e) {
            $('#filtro_operacion_fechaFin').data("DateTimePicker").minDate(e.date);
        });
        $("#filtro_operacion_fechaFin").on("dp.change", function (e) {
            $('#filtro_operacion_fechaIni').data("DateTimePicker").maxDate(e.date);
        });


        $("#filtro_reserva_fechaIni").on("dp.change", function (e) {
            $('#filtro_reserva_fechaFin').data("DateTimePicker").minDate(e.date);
        });
        $("#filtro_reserva_fechaFin").on("dp.change", function (e) {
            $('#filtro_reserva_fechaIni').data("DateTimePicker").maxDate(e.date);
        });

        $("#form_fechaIni").on("dp.change", function (e) {
            $('#form_fechaFin').data("DateTimePicker").minDate(e.date);
        });
        $("#form_fechaFin").on("dp.change", function (e) {
            $('#form_fechaIni').data("DateTimePicker").maxDate(e.date);
        });


        $("#graffechaDesde").on("dp.change", function (e) {
            $('#graffechaHasta').data("DateTimePicker").minDate(e.date);
        });
        $("#graffechaHasta").on("dp.change", function (e) {
            $('#graffechaDesde').data("DateTimePicker").maxDate(e.date);
        });




        //esto es para el nav del sidevar darles estilos
        $("#sidebar ul li a").click(function () {
            $(this).parent().attr("class","active");
            $(this).parent().siblings().removeAttr("class");
        });

        //path = $("#ejemplo").attr("data-path");
        //alert(path);

        //$.fn.dataTable.ext.errMode = 'throw';

        $("#ocultarFiltrosReserva").hide();
         $("#verFiltrosReservas").click(function(e){
             $("#ocultarFiltrosReserva").show();
             $("#verFiltrosReservas").hide();
         });

        $("#ocultarFiltrosOperaciones").hide();
        $("#verFiltrosOperaciones").click(function(e){
            $("#ocultarFiltrosOperaciones").show();
            $("#verFiltrosOperaciones").hide();
        });

        
        
    });

    // Handling the modal confirmation message.
    $(document).on('submit', 'form[data-confirmation]', function (event) {
        var $form = $(this),
            $confirm = $('#confirmationModal');

        if ($confirm.data('result') !== 'yes') {
            //cancel submit event
            event.preventDefault();

            $confirm
                .off('click', '#btnYes')
                .on('click', '#btnYes', function () {
                    $confirm.data('result', 'yes');
                    $form.find('input[type="submit"]').attr('disabled', 'disabled');
                    $form.submit();
                })
                .modal('show');
        }
    });
})(window.jQuery);
