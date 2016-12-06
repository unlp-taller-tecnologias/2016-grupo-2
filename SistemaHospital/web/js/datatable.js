
    $(document).ready(function () {
        $('.datatable').DataTable({
            "processing": true,
            "paging": false,
            "ordering": false,
            "info": false,
            "responsive": true,
            "language": {
                "search": "Busqueda por pagina:"
            },
            "dom": "<'row'<'col-sm-6'<'pull-left'f>><'col-sm-6'<'pull-right'B>>>" +
            "<'row'<'col-sm-12'tr>>",
            buttons: [
                {
                    extend: 'collection',
                    text: ' <i class="fa fa-share"></i><span class="hidden-xs"> Herramientas </span><i class="fa fa-angle-down"></i>',
                    className: 'btn btn-primary',
                    buttons: [{
                        extend: "print", text: '<i class="fa fa-print"></i> Print'
                    }
                        , {
                            extend: "copy", text: '<i class="fa fa-check-circle-o"></i> Copy'
                        }
                        , {
                            extend: "pdf", text: ' <i class="fa fa-file-pdf-o "></i> PDF'
                        }
                        , {
                            extend: "excel", text: '<i class="fa fa-file-excel-o"></i> Excel'
                        }
                        , {
                            extend: "csv", text: '<i class="fa fa-cloud-upload"></i> CSV'
                        }
                    ]

                }
            ]

        });

        $('#datatableReservaPend').DataTable({
            "processing": true,
            "paging": false,
            "language": {
                "search": "Busqueda por pagina:",
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
                        extend: "print", text: '<i class="fa fa-print"></i> Print'
                    }
                        , {
                            extend: "copy", text: '<i class="fa fa-check-circle-o"></i> Copy'
                        }
                        , {
                            extend: "pdf", text: ' <i class="fa fa-file-pdf-o "></i> PDF'
                        }
                        , {
                            extend: "excel", text: '<i class="fa fa-file-excel-o"></i> Excel'
                        }
                        , {
                            extend: "csv", text: '<i class="fa fa-cloud-upload"></i> CSV'
                        }
                    ]

                }
            ]
        });


        $('#datatableOpeNoFinalizada').DataTable({
            "processing": true,
            "paging": true,
            "language": {
                "search": "Busqueda por pagina:",
                "paginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                // "processing":"Procesando...",
                "lengthMenu":     "_MENU_ registros",
            },
            "ordering": true,
            "searching": true,
            "responsive": {details: "inline"},
            "dom": "<'row'<'col-sm-5'<'pull-left'f>><'col-sm-3'<'pull-right'l>><'col-sm-4'<'pull-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12'p>>",
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
                    className: 'btn btn-success',
                    buttons: [{
                        extend: "print", text: '<i class="fa fa-print"></i> Print'
                    }
                        , {
                            extend: "copy", text: '<i class="fa fa-check-circle-o"></i> Copy'
                        }
                        , {
                            extend: "pdf", text: ' <i class="fa fa-file-pdf-o "></i> PDF'
                        }
                        , {
                            extend: "excel", text: '<i class="fa fa-file-excel-o"></i> Excel'
                        }
                        , {
                            extend: "csv", text: '<i class="fa fa-cloud-upload"></i> CSV'
                        }
                    ]

                }//, {
                //    extend: "colvis", text: '<i class="fa fa-refresh"></i> Refrecar Columnas'
                //}
            ]
        });

})


