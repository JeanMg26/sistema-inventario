$(document).ready(function() {


    function init() {

        var collapsedGroups = {};
        var table = $('#tabla_supervisiones').DataTable({
            serverSide: true,
            pageLength: 50,
            processing: true,
            orderFixed: {
                "pre": [
                    [1, 'asc'],
                    [4, 'asc']
                ]
            },
            dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            buttons: {
                dom: {
                    container: {
                        tag: 'div',
                        className: 'flexcontent d-flex justify-content-center justify-content-md-start',
                    },
                    buttonLiner: {
                        tag: null
                    }
                },
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'SUPERVISIÓN DE INVENTARIO',
                        title: '',
                        text: '<i class="fal fa-file-excel mr-1"></i>Excel',
                        className: 'btn btn-success btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                    },

                    {
                        extend: 'pdf',
                        filename: 'SUPERVISIÓN DE INVENTARIO',
                        title: '',
                        orientation: 'landscape',
                        text: '<i class="fal fa-file-pdf mr-1"></i>PDF',
                        className: 'btn btn-danger btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        customize: function(doc) {
                            // Agregar border a tablas
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) { return .8; };
                            objLayout['vLineWidth'] = function(i) { return .5; };
                            objLayout['hLineColor'] = function(i) { return '#aaa'; };
                            objLayout['vLineColor'] = function(i) { return '#aaa'; };
                            objLayout['paddingLeft'] = function(i) { return 8; };
                            objLayout['paddingRight'] = function(i) { return 8; };
                            doc.content[0].layout = objLayout;

                            doc.styles.tableHeader = { fillColor: '#e46a76', color: 'white', alignment: 'center' };
                            doc.content[0].table.widths = ['*', '*', '*', '*', '*'];
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fal fa-print mr-1"></i>Imprimir',
                        filename: 'SUPERVISIÓN DE INVENTARIO',
                        title: '',
                        className: 'btn btn-info btn-sm mr-1',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                    },
                    {
                        text: '<i class="fal fa-chart-bar mr-2"></i>Gráficos',
                        className: 'btn btn-reload btn-sm',
                        action: function(e, dt, node, config) {
                            window.location = route('graficos.index');
                        }
                    }
                ],

            },
            ajax: {
                url: route('supervisiones.data'),
                type: 'GET',
                data: function(d) {
                    d.fecha_desde = $('#fecha_desde').val();
                    d.fecha_hasta = $('#fecha_hasta').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'equipo',
                    name: 'equipos.nombre',
                },
                {
                    data: 'bienes_enc',
                    name: 'supervisiones.bienes_enc'
                },
                {
                    data: 'bienes_adic',
                    name: 'supervisiones.bienes_adic'
                },
                {
                    data: 'fecha',
                    name: 'supervisiones.fecha'
                },

                {
                    data: 'fecha',
                    name: 'supervisiones.fecha',
                    visible: false
                },
                {
                    data: 'acciones',
                    orderable: false,
                    searchable: false
                },
            ],
            rowGroup: {
                endRender: null,
                dataSrc: 'equipo',
                startRender: function(rows, group) {
                    var collapsed = !!collapsedGroups[group];

                    rows.nodes().each(function(r) {
                        r.style.display = 'none';
                        if (collapsed) {
                            r.style.display = '';
                        }
                    });

                    var b_enc = rows.data().pluck('bienes_enc').sum();
                    b_enc = $.fn.dataTable.render.number('.', ',', 0, '').display(b_enc);

                    var b_adic = rows.data().pluck('bienes_adic').sum();
                    b_adic = $.fn.dataTable.render.number('.', ',', 0, '').display(b_adic);

                    return $('<tr/>')
                        .append('<td colspan="1"><button type="button" id="3" class="btn-collapse"><i class="far fa-plus"></i></button></td>')
                        .append('<td colspan="1" class="font-weight-bold">' + group + ' (' + rows.count() + ')</td>')
                        .append('<td colspan="1" class="font-weight-bold">' + b_enc + '</td>')
                        .append('<td colspan="1" class="font-weight-bold">' + b_adic + '</td>')
                        .append('<td colspan="2" class="font-weight-bold"></td>')
                        .attr('data-name', group)
                        .attr('id', 'grupo')
                        .toggleClass('collapsed', collapsed);
                },
            },
            columnDefs: [{
                    targets: [4],
                    render: function(data) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                {
                    targets: [5],
                    render: function(data) {
                        return moment(data).format('YYYY');
                    }
                },
            ],
            drawCallback: function() {
                var api = this.api();

                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                var tb_enc = api.column(2).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var tb_adic = api.column(3).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                $('#ltotal').html('TOTAL');
                $('#total_bienes_enc').html(tb_enc);
                $('#total_bienes_adic').html(tb_adic);
                $('#vacio').html();
            },
            language: {
                url: 'js/datatable-es.json',
            }
        });



        $('#buscar_select1').on('change', function() {
            table.columns(1).search(this.value).draw();
        });

        $('#dropdownMenu2').on('change', function() {
            table.columns(4).search(this.value).draw();
        });

        $('#year').on('change', function() {
            table.columns(4).search(this.value).draw();
        });

        $(document).on('click', '.btn-collapse', function() {
            var name = $(this).closest('tr').data('name');
            collapsedGroups[name] = !collapsedGroups[name];
            table.draw();
        });


        $('#filtrar').click(function() {

            var fecha_desde = $('#fecha_desde').val();
            var fecha_hasta = $('#fecha_hasta').val();
            if (fecha_desde != '' && fecha_hasta != '') {
                $('#tabla_supervisiones').DataTable().draw(true);
            } else {
                swal("Atención!", "Ingrese ambas fechas para filtrar.", "warning");
            }
        });

        $('#reiniciar').click(function() {
            $('#fecha_desde').val('').datepicker('setDate', null);
            $('#fecha_hasta').val('').datepicker('setDate', null);
            $('#buscar_select1').val('').trigger('change');
            $('#tabla_supervisiones').DataTable().draw(true);
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_supervisiones thead tr th').css('pointer-events', 'none');


        events();
        alerts();

    }

    function events() {


        // LLAMANDO A MODAL PARA AGREGAR REGISTRO
        $('#crear_registro').on('click', function() {
            $('.modal-title').text('Nuevo Registro');
            $('#action_button').text('Agregar');
            $('#action_button').prepend('<i class="fas fa-save mr-2">');
            $('#action_button').removeClass('btn-info');
            $('#action_button').addClass('btn-danger');
            $('#action').val('Agregar');

            $('#equipo-error').empty();
            $('#bienes_enc-error').empty();
            $('#bienes_adic-error').empty();
            $('#fecha-error').empty();
            $('#observacion-error').empty();
            $('#equipo-error').addClass('d-none');
            $('#bienes_enc-error').addClass('d-none');
            $('#bienes_adic-error').addClass('d-none');
            $('#fecha-error').addClass('d-none');
            $('#observacion-error').addClass('d-none');
            $('#bienes_enc').removeClass('is-invalid');
            $('#bienes_adic').removeClass('is-invalid');
            $('#fecha').removeClass('is-invalid');
            $('#observacion').removeClass('is-invalid');
            $('#equipo').parent().removeClass(' has-error-select2');
            $('#bienes_enc').val('');
            $('#bienes_adic').val('');
            $('#observacion').val('');
            $('#equipo').val('').trigger('change');
            $('#fecha').datepicker('setDate', new Date());

            $('#modalSupervision').modal('show');
        });

        // VERIFICAR SI EXISTE ERRORES
        $('#form-supervision').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            // Accione para agregar
            if ($('#action').val() == 'Agregar') {
                action_url = route('supervisiones.store');

            }

            // Accione para editar
            if ($('#action').val() == 'Editar') {
                action_url = route('supervisiones.update');
            }

            $.ajax({
                url: action_url,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        if (data.errors.equipo) {
                            $('#equipo-error').removeClass('d-none');
                            $('#equipo').parent().addClass(' has-error-select2');
                            $('#equipo-error').html(data.errors.equipo[0]);

                        }

                        if (data.errors.bienes_enc) {
                            $('#bienes_enc-error').removeClass('d-none');
                            $('#bienes_enc').addClass('is-invalid');
                            $('#bienes_enc-error').html(data.errors.bienes_enc[0]);
                        }

                        if (data.errors.bienes_adic) {
                            $('#bienes_adic-error').removeClass('d-none');
                            $('#bienes_adic').addClass('is-invalid');
                            $('#bienes_adic-error').html(data.errors.bienes_adic[0]);
                        }

                        if (data.errors.fecha) {
                            $('#fecha-error').removeClass('d-none');
                            $('#fecha').addClass('is-invalid');
                            $('#fecha-error').html(data.errors.fecha[0]);
                        }

                        if (data.errors.observacion) {
                            $('#observacion-error').removeClass('d-none');
                            $('#observacion').addClass('is-invalid');
                            $('#observacion-error').html(data.errors.observacion[0]);
                        }
                    }

                    if (data.success) {
                        if ($('#action').val() == 'Editar') {
                            toastr['info']('Registro actualizado correctamente');
                            $('#form-supervision')[0].reset();
                            // Limpiar errores y campos
                            $('#equipo-error').empty();
                            $('#bienes_enc-error').empty();
                            $('#bienes_adic-error').empty();
                            $('#fecha-error').empty();
                            $('#observacion-error').empty();
                            $('#equipo-error').addClass('d-none');
                            $('#bienes_enc-error').addClass('d-none');
                            $('#bienes_adic-error').addClass('d-none');
                            $('#fecha-error').addClass('d-none');
                            $('#observacion-error').addClass('d-none');
                            $('#bienes_enc').removeClass('is-invalid');
                            $('#bienes_adic').removeClass('is-invalid');
                            $('#fecha').removeClass('is-invalid');
                            $('#observacion').removeClass('is-invalid');
                            $('#equipo').parent().removeClass(' has-error-select2');
                            $('#bienes_enc').val('');
                            $('#bienes_adic').val('');
                            $('#observacion').val('');
                            $('#equipo').val('').trigger('change');
                            $('#fecha').datepicker('setDate', new Date());
                            $('#tabla_supervisiones').DataTable().ajax.reload();
                            $('#modalSupervision').modal('hide');
                        } else {
                            toastr['success']('Registro agregado correctamente');
                            $('#form-supervision')[0].reset();
                            // Limpiar errores y campos
                            $('#equipo-error').empty();
                            $('#bienes_enc-error').empty();
                            $('#bienes_adic-error').empty();
                            $('#fecha-error').empty();
                            $('#observacion-error').empty();
                            $('#equipo-error').addClass('d-none');
                            $('#bienes_enc-error').addClass('d-none');
                            $('#bienes_adic-error').addClass('d-none');
                            $('#fecha-error').addClass('d-none');
                            $('#observacion-error').addClass('d-none');
                            $('#bienes_enc').removeClass('is-invalid');
                            $('#bienes_adic').removeClass('is-invalid');
                            $('#fecha').removeClass('is-invalid');
                            $('#observacion').removeClass('is-invalid');
                            $('#equipo').parent().removeClass(' has-error-select2');
                            $('#bienes_enc').val('');
                            $('#bienes_adic').val('');
                            $('#observacion').val('');
                            $('#equipo').val('').trigger('change');
                            $('#fecha').datepicker('setDate', new Date());
                            $('#tabla_supervisiones').DataTable().ajax.reload();
                        }
                    }

                },

            })
        });

        // *************  EDITAR MODAL DESDE AJAX *************
        $(document).on('click', '.edit', function() {

            var id = $(this).attr('id');
            $('#form_result').html('');

            $.ajax({
                url: '/supervisiones/' + id + '/edit',
                dataType: 'json',
            }).done(function(data) {
                $('#equipo').val(data.super.equipos_id).trigger('change');
                $('#bienes_enc').val(data.super.bienes_enc);
                $('#bienes_adic').val(data.super.bienes_adic);
                // ******** FECHA ************
                var fecha = data.super.fecha;
                var ffecha = moment(fecha).format('DD-MM-YYYY');
                $('#fecha').val(ffecha);

                $('#observacion').val(data.super.observacion);
                $('#supervision_id').val(id);

                $('.modal-title').text('Actualizar Registro');
                $('#action_button').text('Actualizar');
                $('#action_button').prepend('<i class="far fa-sync-alt mr-2"></i>');
                $('#action_button').removeClass('btn-danger');
                $('#action_button').addClass('btn-info');
                $('#action').val('Editar');
                $('#modalSupervision').modal('show');
            });
        });

        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');

            $.ajax({
                url: "supervisiones/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#lequipo').text(data.equipo.nombre);
                    $('#lbienes_enc').text(data.super.bienes_enc);
                    $('#lbienes_adic').text(data.super.bienes_adic);
                    // FECHA
                    var fecha = data.super.fecha;
                    var ffecha = moment(fecha).format('DD-MM-YYYY');
                    $('#lfecha').text(ffecha);

                    $('#lobservacion').text(data.super.observacion);
                    $('.modal-title').text('Detalle del Registro');
                    $('#showModal').modal('show');
                }
            });

        });


        // ************* ELIMINAR MODAL DESDE AJAX *************
        var delete_id;
        $(document).on('click', '.delete', function() {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('Eliminar Registro');
            $('#ok_button').text('Si, Eliminar');

        });

        $('#ok_button').on('click', function() {
            $.ajax({
                url: '/supervisiones/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_supervisiones').DataTable().ajax.reload();
                    }, 400);
                }

            })
        });


        // *********** SELECT2 ****************
        $('#equipo').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
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


        $('#fecha').datepicker({
            language: "es",
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        });

        $('#fecha_desde').datepicker({
            language: "es",
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            orientation: 'bottom auto',
        });

        $('#fecha_hasta').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            language: "es",
            orientation: 'bottom auto',
        });


        // AUTOFOCUS PARA SELECT2 MODAL
        $('#modalSupervision').on('shown.bs.modal', function() {
            $('#equipo').select2('focus');
        });


    }


    function alerts() {

        // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
        $('#bienes_enc').on('keyup', function() {
            if ($('#bienes_enc-error').text() != '') {
                if ($(this).val().length) {
                    $('#bienes_enc-error').addClass('d-none');
                    $('#bienes_enc').removeClass('is-invalid');
                } else {
                    $('#bienes_enc-error').removeClass('d-none');
                    $('#bienes_enc').addClass('is-invalid');
                }
            }
        });

        $('#bienes_adic').on('keyup', function() {
            if ($('#bienes_adic-error').text() != '') {
                if ($(this).val().length) {
                    $('#bienes_adic-error').addClass('d-none');
                    $('#bienes_adic').removeClass('is-invalid');
                } else {
                    $('#bienes_adic-error').removeClass('d-none');
                    $('#bienes_adic').addClass('is-invalid');
                }
            }
        });

        $('#fecha').on('change', function() {
            if ($('#fecha-error').text() != '') {
                if ($(this).val().length) {
                    $('#fecha-error').addClass('d-none');
                    $('#fecha').removeClass('is-invalid');
                } else {
                    $('#fecha-error').removeClass('d-none');
                    $('#fecha').addClass('is-invalid');
                }
            }
        });


        $('#observacion').on('keyup', function() {
            if ($('#observacion-error').text() != '') {
                if ($(this).val().length) {
                    $('#observacion-error').addClass('d-none');
                    $('#observacion').removeClass('is-invalid');
                } else {
                    $('#observacion-error').removeClass('d-none');
                    $('#observacion').addClass('is-invalid');
                }
            }
        });


        $('#equipo').on('change', function() {
            if ($('#equipo-error').text() != '') {
                if ($(this).val() == '') {
                    $('#equipo-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#equipo-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

    }

    init();





});
