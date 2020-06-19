$(document).ready(function() {

    function init() {

        var table = $('#tabla_cruces').DataTable({
            serverSide: true,
            "scrollY": "450px",
            "scrollCollapse": true,
            "paging": false,
            info: false,
            order: [
                [1, 'asc'],
                [3, 'asc']
            ],
            dom: 'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('cruces.datainicio'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'equipo',
                    name: 'equipos.nombre'
                },
                {
                    data: 'codbien',
                    name: 'bienes.codbien'
                },
                {
                    data: 'bienes',
                    name: 'bienes.descripcion'
                },
                {
                    data: "codlocalDB",
                    name: "localDB.codlocal",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['localDB'] + '">' + oData['codlocalDB'] + '</span>');
                    }
                },
                {
                    data: "codareaDB",
                    name: "areaDB.codarea",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['areaDB'] + '">' + oData['codareaDB'] + '</span>');
                    }
                },
                {
                    data: "codoficinaDB",
                    name: "oficinaDB.codoficina",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['oficinaDB'] + '">' + oData['codoficinaDB'] + '</span>');
                    }
                },
                {
                    data: "codlocalENC",
                    name: "localENC.codlocal",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['localENC'] + '">' + oData['codlocalENC'] + '</span>');
                    }
                },
                {
                    data: "codareaENC",
                    name: "areaENC.codarea",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['areaENC'] + '">' + oData['codareaENC'] + '</span>');
                    }
                },
                {
                    data: "codoficinaENC",
                    name: "oficinaENC.codoficina",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['oficinaENC'] + '">' + oData['codoficinaENC'] + '</span>');
                    }
                },
            ],
            language: {
                url: 'js/datatable-es.json',
            },
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            },
            rowCallback: function(row, data, index) {

                if (data['estadoCruce'] == '1') {
                    $(row).find('td').css('background-color', '#d3f9d8');
                } else {
                    $(row).find('td').css('background-color', '#ffe3e3');
                }

            },
            "fnInitComplete": function() {
                $('.dataTables_scrollBody').perfectScrollbar();
            },
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_cruces thead tr th').css('pointer-events', 'none');


    }


    init();




});
