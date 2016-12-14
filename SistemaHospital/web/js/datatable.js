
    $(document).ready(function () {
        $('.datatable').DataTable({
            "processing": true,
            "paging": false,
            "ordering": false,
            "info": false,
            "responsive": true,
            "language": {
                "emptyTable": "No hay resultados.",
                "zeroRecords": "No hay resultados.",
                "lengthMenu": "Mostrando _MENU_ Resultados",
                "search": "Búsqueda por Página:"
            },
            "dom": "<'row'<'col-sm-6'<'pull-left'f>><'col-sm-6'<'pull-right'B>>>" +
            "<'row'<'col-sm-12'tr>>",
            buttons: [
                {
                    extend: 'collection',
                    text: ' <i class="fa fa-share"></i><span class="hidden-xs"> Herramientas </span><i class="fa fa-angle-down"></i>',
                    className: 'btn btn-primary',
                    buttons: [{
                        extend: "print", text: '<i class="fa fa-print"></i> Imprimir'
                    }
                        , {
                            extend: "copy", text: '<i class="fa fa-check-circle-o"></i> Copiar'
                        }
                        , {
                            extend: "pdf", text: ' <i class="fa fa-file-pdf-o "></i> Generar PDF'
                        }
                        , {
                            extend: "excel", text: '<i class="fa fa-file-excel-o"></i> Generar Excel'
                        }
                        , {
                            extend: "csv", text: '<i class="fa fa-cloud-upload"></i> Generar CSV'
                        }
                    ]

                }
            ]

        });

        $('#datatableReservaPend').DataTable({
            "processing": true,
            "paging": false,
            "language": {
                "emptyTable": "No hay resultados.",
                "zeroRecords": "No hay resultados.",
                "lengthMenu": "Mostrando _MENU_ Resultados",
                "search": "Búsqueda por Página:"
            },
            "ordering": false,
            "searching": false,
            "info": false,
            "responsive": {details: "inline"},
            "dom": "<'row'<'col-sm-12'<'pull-right'B>>>" +
            "<'row'<'col-sm-12'tr>>",

            buttons: [
                {
                    extend: 'collection',
                    text: ' <i class="fa fa-share"></i><span class="hidden-xs"> Herramientas </span><i class="fa fa-angle-down"></i>',
                    className: 'btn btn-primary',
                    buttons: [{
                        extend: "print", text: '<i class="fa fa-print"></i> Imprimir'
                    }
                        , {
                            extend: "copy", text: '<i class="fa fa-check-circle-o"></i> Copiar'
                        }
                        , {
                            extend: "pdf", text: ' <i class="fa fa-file-pdf-o "></i> Generar PDF'
                        }
                        , {
                            extend: "excel", text: '<i class="fa fa-file-excel-o"></i> Generar Excel'
                        }
                        , {
                            extend: "csv", text: '<i class="fa fa-cloud-upload"></i> Generar CSV'
                        }
                    ]

                }
            ]
        });


        $('#datatableOpeNoFinalizada').DataTable({
            "processing": true,
            "paging": true,
            "language": {
                "emptyTable": "No hay resultados.",
                "zeroRecords": "No hay resultados.",
                "lengthMenu": "Mostrando _MENU_ Resultados",
                "paginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente →",
                    "sPrevious": "← Anterior"
                },
                "search": "Búsqueda por Página:"
            },
            "ordering": true,
            "searching": true,
            "responsive": {details: "inline"},
            "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-5'B><'col-sm-7'>>" +
            "<'row'<'col-sm-12'tr>>",
            "info": false,
            buttons: [
                // {
                //     extend: 'pageLength',
                //     text: "Mostrar _MENU_ registros",
                //     className: 'btn btn-success'
                // },
                {
                    extend: 'collection',
                    text: ' <i class="fa fa-share"></i><span class="hidden-xs"> Herramientas </span><i class="fa fa-angle-down"></i>',
                    className: 'btn btn-primary',
                    buttons: [{
                        extend: "print", text: '<i class="fa fa-print"></i> Imprimir'
                    }
                        , {
                            extend: "copy", text: '<i class="fa fa-check-circle-o"></i> Copiar'
                        }
                        , {
                            extend: "pdf", text: ' <i class="fa fa-file-pdf-o "></i> Generar PDF'
                        }
                        , {
                            extend: "excel", text: '<i class="fa fa-file-excel-o"></i> Generar Excel'
                        }
                        , {
                            extend: "csv", text: '<i class="fa fa-cloud-upload"></i> Generar CSV'
                        }
                    ]

                }//, {
                //    extend: "colvis", text: '<i class="fa fa-refresh"></i> Refrecar Columnas'
                //}
            ]
        });

})


