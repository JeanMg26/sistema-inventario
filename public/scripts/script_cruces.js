$(document).ready(function() {

    function init() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#tabla_cruces').DataTable({
            // ordering: false,
            serverSide: true,
            pageLength: 15,
            processing: true,
            select: true,
            order: [
                [1, 'asc'],
                [3, 'asc']
            ],
            dom: 'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('cruces.data'),
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
                {
                    data: 'year',
                    name: 'cruces.created_at',
                    visible: false
                },
                {
                    data: 'acciones',
                    name: 'acciones',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [{
                targets: [10],
                render: function(data) {
                    return moment(data).format('YYYY');
                }
            }, ],
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
        });

        $('#buscar_select1').change(function() {
            table.columns(1).search(this.value).draw();
        });

        $('#year').change(function() {
            table.columns(10).search(this.value).draw();
        });

        $('#buscar_columna2').on('keyup', function() {
            table.columns(2).search(this.value).draw();
        });

        $('#buscar_columna3').on('keyup', function() {
            table.columns(3).search(this.value).draw();
        });


        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_cruces thead tr th').css('pointer-events', 'none');



        events();
    }

    function events() {

        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');
            $.ajax({
                url: "cruces/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#lnom_equipo').text(data.equipo.nombre);
                    $('#lcodbien').text(data.bien.codbien);
                    $('#lnom_bien').text(data.bien.descripcion);

                    $('#llocal_db').text(data.local_db.codlocal + ' - ' + data.local_db.descripcion);
                    $('#larea_db').text(data.area_db.codarea + ' - ' + data.area_db.descripcion);
                    $('#loficina_db').text(data.oficina_db.codoficina + ' - ' + data.oficina_db.descripcion);

                    $('#llocal_enc').text(data.local_enc.codlocal + ' - ' + data.local_enc.descripcion);
                    $('#larea_enc').text(data.area_enc.codarea + ' - ' + data.area_enc.descripcion);
                    $('#loficina_enc').text(data.oficina_enc.codoficina + ' - ' + data.oficina_enc.descripcion);

                    // ESTADO
                    if (data.cruce.estado == '0') {
                        $('#lestado').text('CRUZADO');
                    } else {
                        $('#lestado').text('POR CRUZAR');
                    }

                    // OBSERVACIONES
                    if (data.cruce.observacion == '' | data.cruce.observacion == null) {
                        $('#lobservacion').text('-------------------------');
                    } else {
                        $('#lobservacion').text(data.cruce.observacion);
                    }

                    $('#lusuario').text(data.usuario.name);

                    $('.modal-title').text('Detalle del Registro');
                    $('#showModal').modal('show');
                }
            })
        });


        // ************* CRUZAR BIEN DESDE AJAX - MODAL *************
        var cruce_id;
        $(document).on('click', '.cruce', function() {
            cruce_id = $(this).attr('id');
            cruce_estado = 1;
            $('#cruceModal').modal('show');
            $('.modal-title').text('Cruzar Bien');
            $('#cruce_button').text('Si, Cruzar');
        });
        $('#cruce_button').on('click', function() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: route('cruzar.bien'),
                data: { 'cruce_id': cruce_id, 'cruce_estado': cruce_estado },
                beforeSend: function() {
                    $('#cruce_button').text('Cruzando...');
                    toastr['info']('Bien cruzado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#tabla_cruces').DataTable().ajax.reload();
                        $('#cruceModal').modal('hide');
                    }, 400);
                }
            });
        });

        $('#buscar_select1').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
            dropdownParent: $('#parent')
        });

        $('#year').select2({
            width: '100%',
            placeholder: "SELECCIONAR AÑO DE INVENTARIO",
            allowClear: true,
            language: "es",
            dropdownParent: $('#btn-year')
        });

    }

    init();

});
