$(document).ready(function() {

    function init() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#tabla_locales').DataTable({
            // ordering: false,
            serverSide: true,
            pageLength: 15,
            processing: true,
            order: [
                [1, 'asc']
            ],
            dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            buttons: {
                dom: {
                    container: {
                        tag: 'div',
                        className: 'flexcontent d-flex justify-content-center justify-content-md-start'
                    },
                    buttonLiner: {
                        tag: null
                    }
                },
                buttons: [{
                        extend: 'excel',
                        title: 'LOCALES DE LA INSTITUCIÓN',
                        text: '<i class="fal fa-file-excel mr-1"></i>Excel',
                        className: 'btn btn-success btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                    },

                    {
                        extend: 'pdf',
                        title: 'LOCALES DE LA INSTITUCIÓN',
                        text: '<i class="fal fa-file-pdf mr-1"></i>PDF',
                        className: 'btn btn-danger btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2]
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
                            doc.content[1].layout = objLayout;

                            doc.styles.tableHeader = {
                                    fillColor: '#e46a76',
                                    color: 'white',
                                    alignment: 'center'
                                },
                                // doc.defaultStyle.alignment = 'center';
                                doc.content[1].table.widths = ['10%', '40%', '50%']

                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fal fa-print mr-1"></i>Imprimir',
                        title: 'LOCALES DE LA INSTITUCIÓN',
                        className: 'btn btn-info btn-sm',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        customize: function(win) {
                            $(win.document.body).find('table').css('text-align', 'center');
                            $(win.document.body).find('h1').css('text-align', 'center');
                        }
                    },
                ],


            },
            ajax: {
                url: route('locales.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'codlocal',
                    name: 'codlocal'
                },
                {
                    data: 'descripcion',
                    name: 'descripcion'
                },
                {
                    data: 'checkbox-estado',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'acciones',
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                url: 'js/datatable-es.json',
            },
            fnDrawCallback: function() {
                $('.toggle-class').bootstrapToggle({
                    on: '<i class="far fa-check"></i>',
                    off: '<i class="far fa-times"></i>'
                });
            }
        });


        // ***************************************************************************
        // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

        table.on('click', '.toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var toggle_id = $(this).find('.toggle-class').attr('id');
            var local_id = $(this).find('.toggle-class').data('id');

            if ($('#' + toggle_id).prop("checked")) {

                Swal.fire({
                    title: "¿Estas seguro?",
                    text: "El registro será desactivado.",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonText: "Si, Desactivar",
                    cancelButtonText: "No, Cancelar",
                    customClass: {
                        confirmButton: 'btn btn-success btn-lg mr-3',
                        cancelButton: 'btn btn-secondary btn-lg'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "Desactivado",
                            text: "El registro fue desactivado exitosamente",
                            type: "success",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: 'btn btn-success btn-lg px-4',
                            },
                            buttonsStyling: false
                        });

                        $('#' + toggle_id).bootstrapToggle('off');
                        var estado = '0';

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: route('cambiar.estadolocal'),
                            data: { 'estado': estado, 'local_id': local_id },
                            beforeSend: function() {
                                toastr.info('Estado actualizado correctamente');
                            },
                            success: function(data) {
                                console.log(data.success);
                            }
                        });
                    }
                });

            } else {

                Swal.fire({
                    title: "¿Estas seguro?",
                    text: "El registro será activado.",
                    type: "question",
                    showCancelButton: true,
                    confirmButtonText: "Si, Activar",
                    cancelButtonText: "No, Cancelar",
                    customClass: {
                        confirmButton: 'btn btn-success btn-lg mr-3',
                        cancelButton: 'btn btn-secondary btn-lg'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "Activado",
                            text: "El registro fue activado exitosamente",
                            type: "success",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: 'btn btn-success btn-lg px-4',
                            },
                            buttonsStyling: false
                        });

                        $('#' + toggle_id).bootstrapToggle('on');
                        var estado = '1';

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: route('cambiar.estadolocal'),
                            data: { 'estado': estado, 'local_id': local_id },
                            beforeSend: function() {
                                toastr.info('Estado actualizado correctamente');
                            },
                            success: function(data) {
                                console.log(data.success);
                            }
                        });
                    }
                });
            }
        });

        // ********************* /FIN - ACTUALIZAR REGISTRO *********************


        // BUSQUEDA INDIVIDUAL POR COLUMNA
        $('#buscar_columna1').on('keyup', function() {
            table.columns(1).search(this.value).draw();
        });

        $('#buscar_columna2').on('keyup', function() {
            table.columns(2).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_locales thead tr th').css('pointer-events', 'none');


        alerts();
        events();
    }

    function events() {

        // LLAMANDO A MODAL PARA AGREGAR REGISTRO
        $('#crear_registro').on('click', function() {
            $('.modal-title').text('Nuevo Local');
            $('.action_button').text('Guardar');
            $('.action_button').prepend('<i class="fas fa-save mr-2">');
            $('.action_button').removeClass('btn-info');
            $('.action_button').addClass('btn-danger');
            $('#action').val('Agregar');

            $('#cod_local-error').empty();
            $('#des_local-error').empty();
            $('#est_local-error').empty();
            $('#cod_local-error').addClass('d-none');
            $('#des_local-error').addClass('d-none');
            $('#est_local-error').addClass('d-none');
            $('#cod_local').removeClass('is-invalid');
            $('#des_local').removeClass('is-invalid');
            $('#est_local').removeClass('is-invalid');
            $('#est_local').parent().removeClass(' has-error-select2');
            $('#cod_local').val('');
            $('#des_local').val('');
            $('#est_local').val("1").trigger("change");

            $('#est_local option:eq(2)').prop('disabled', true);
            $('#modalLocal').modal('show');
        });

        // VERIFICAR SI EXISTE ERRORES
        $('#form-local').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            // Accione para agregar
            if ($('#action').val() == 'Agregar') {
                action_url = route('locales.store');

            }

            // Accione para editar
            if ($('#action').val() == 'Editar') {
                action_url = route('locales.update');
            }

            $.ajax({
                url: action_url,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        if (data.errors.cod_local) {
                            $('#cod_local-error').removeClass('d-none');
                            $('#cod_local').addClass('is-invalid');
                            $('#cod_local-error').html(data.errors.cod_local[0]);
                        }

                        if (data.errors.des_local) {
                            $('#des_local-error').removeClass('d-none');
                            $('#des_local').addClass('is-invalid');
                            $('#des_local-error').html(data.errors.des_local[0]);
                        }

                        if (data.errors.est_local) {
                            $('#est_local-error').removeClass('d-none');
                            $('#est_local').parent().addClass(' has-error-select2');
                            $('#est_local-error').html(data.errors.est_local[0]);
                        }
                    }

                    if (data.success) {
                        if ($('#action').val() == 'Editar') {
                            toastr['info']('Registro actualizado correctamente');
                            // Limpiar errores y campos
                            $('#form-local')[0].reset();
                            $('#cod_local-error').empty();
                            $('#des_local-error').empty();
                            $('#est_local-error').empty();
                            $('#cod_local-error').addClass('d-none');
                            $('#des_local-error').addClass('d-none');
                            $('#est_local-error').addClass('d-none');
                            $('#cod_local').removeClass('is-invalid');
                            $('#des_local').removeClass('is-invalid');
                            $('#est_local').removeClass('is-invalid');
                            $('#est_local').parent().removeClass(' has-error-select2');
                            $('#cod_local').val('');
                            $('#des_local').val('');
                            $('#est_local').val("1").trigger("change");
                            $('#tabla_locales').DataTable().ajax.reload();
                            $('#modalLocal').modal('hide');
                        } else {
                            toastr['success']('Registro agregado correctamente');
                            // Limpiar errores y campos
                            $('#form-local')[0].reset();
                            $('#cod_local-error').empty();
                            $('#des_local-error').empty();
                            $('#est_local-error').empty();
                            $('#cod_local-error').addClass('d-none');
                            $('#des_local-error').addClass('d-none');
                            $('#est_local-error').addClass('d-none');
                            $('#cod_local').removeClass('is-invalid');
                            $('#des_local').removeClass('is-invalid');
                            $('#est_local').removeClass('is-invalid');
                            $('#est_local').parent().removeClass(' has-error-select2');
                            $('#cod_local').val('');
                            $('#des_local').val('');
                            $('#est_local').val("1").trigger("change");
                            $('#tabla_locales').DataTable().ajax.reload();
                            $('#cod_local').focus();
                        }
                    }
                }
            });
        });


        // ************* LLAMANDO AL EDIT MODAL DESDE AJAX *************
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $('#cod_local-error').empty();
            $('#des_local-error').empty();
            $('#est_local-error').empty();
            $('#cod_local-error').addClass('d-none');
            $('#des_local-error').addClass('d-none');
            $('#est_local-error').addClass('d-none');
            $('#cod_local').removeClass('is-invalid');
            $('#des_local').removeClass('is-invalid');
            $('#est_local').removeClass('is-invalid');
            $('#est_local').parent().removeClass(' has-error-select2');
            $('#est_local option:eq(2)').prop('disabled', true);

            $.ajax({
                url: '/locales/' + id + '/edit',
                dataType: 'json',
                success: function(data) {
                    $('#cod_local').val(data.local.codlocal);
                    $('#des_local').val(data.local.descripcion);
                    $('#est_local').val(data.local.estado).trigger("change");
                    $('#est_local option:eq(2)').prop('disabled', false);
                    $('#local_id').val(id);
                    $('.modal-title').text('Actualizar Local');
                    $('.action_button').text('Actualizar');
                    $('.action_button').prepend('<i class="far fa-sync-alt mr-2"></i>');
                    $('.action_button').removeClass('btn-danger');
                    $('.action_button').addClass('btn-info');
                    $('#action').val('Editar');
                    $('#modalLocal').modal('show');
                }
            });

        });

        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            $('.modal-title').text('Detalle delregistro');
            var show_id = $(this).attr('id');

            $.ajax({
                url: "locales/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#lcod_local').text(data.local.codlocal);
                    $('#ldes_local').text(data.local.descripcion);
                    if (data.local.estado == '1') {
                        $('#lest_local').text('ACTIVO');
                    } else {
                        $('#lest_local').text('INACTIVO');
                    }
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
                url: '/locales/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_locales').DataTable().ajax.reload();
                    }, 400);
                }

            })
        });


        // ****************** BORRRAR FILTROS **********************
        $('#btn-filtro').on('click', function() {
            $('#buscar_columna1').val('').keyup();
            $('#buscar_columna2').val('').keyup();
        });


        // AUTOFOCUS PARA SELECT2 MODAL
        $('#modalLocal').on('shown.bs.modal', function() {
            $('#cod_local').focus();
        });

        // *********** SELECT2 *****************
        $('#est_local').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
        });

    }

    function alerts() {

        // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
        $('#cod_local').on('keyup', function() {
            if ($('#cod_local-error').text() != '') {
                if ($(this).val().length) {
                    $('#cod_local-error').addClass('d-none');
                    $('#cod_local').removeClass('is-invalid');
                } else {
                    $('#cod_local-error').removeClass('d-none');
                    $('#cod_local').addClass('is-invalid');
                }
            }
        });

        $('#des_local').on('keyup', function() {
            if ($('#des_local-error').text() != '') {
                if ($(this).val().length) {
                    $('#des_local-error').addClass('d-none');
                    $('#des_local').removeClass('is-invalid');
                } else {
                    $('#des_local-error').removeClass('d-none');
                    $('#des_local').addClass('is-invalid');
                }
            }
        });

        $('#est_local').on('change', function() {
            if ($('#est_local-error').text() != '') {
                if ($(this).val() == '') {
                    $('#est_local-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#est_local-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });


    }



    init();

});
