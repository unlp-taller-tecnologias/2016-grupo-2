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
