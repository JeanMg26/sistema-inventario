$(document).ready(function() {

    function init() {

        var collapsedGroups = {};
        var table = $('#tabla_permisos').DataTable({
            serverSide: true,
            pageLength: 50,
            orderFixed: {
                "pre": [
                    [1, 'asc'],
                    [2, 'asc']
                ]
            },
            processing: true,
            dom: 'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('permisos.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'module',
                    name: 'module'
                },
                {
                    data: 'nombre',
                    name: 'nombre'
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
            rowGroup: {
                endRender: null,
                dataSrc: 'module',
                startRender: function(rows, group) {
                    var collapsed = !!collapsedGroups[group];

                    rows.nodes().each(function(r) {
                        r.style.display = 'none';
                        if (collapsed) {
                            r.style.display = '';
                        }
                    });

                    return $('<tr/>')
                        .append('<td colspan="1"><button type="button" class="btn-collapse"><i class="far fa-plus"></i></button></td>')
                        .append('<td colspan="2" class="font-weight">' + group + ' (' + rows.count() + ')</td>')
                        .append('<td colspan="2" class="font-weight"></td>')
                        .attr('data-name', group)
                        .attr('id', 'grupo')
                        .toggleClass('collapsed', collapsed);
                },
            },
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

        $(document).on('click', '.btn-collapse', function() {
            var name = $(this).closest('tr').data('name');
            collapsedGroups[name] = !collapsedGroups[name];
            table.draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_permisos thead tr th').css('pointer-events', 'none');


        // ***************************************************************************
        // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

        table.on('click', '.toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var toggle_id = $(this).find('.toggle-class').attr('id');
            var permiso_id = $(this).find('.toggle-class').data('id');

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
                            url: route('cambiar.estadopermiso'),
                            data: { 'estado': estado, 'permiso_id': permiso_id },
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
                            url: route('cambiar.estadopermiso'),
                            data: { 'estado': estado, 'permiso_id': permiso_id },
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

        guardarPermiso();
        alerts();
        events();
    }


    function events() {


        // LLAMANDO A MODAL PARA AGREGAR REGISTRO
        $('#crear_registro').on('click', function() {
            $('.modal-title').text('Nuevo Permiso');
            $('.action_button').text('Guardar');
            $('.action_button').prepend('<i class="fas fa-save mr-2">');
            $('.action_button').removeClass('btn-info');
            $('.action_button').addClass('btn-danger');
            $('.action').val('Agregar');

            $('#nom_permiso-error').empty();
            $('#mod_permiso-error').empty();
            $('#est_permiso-error').empty();
            $('#nom_permiso-error').addClass('d-none');
            $('#mod_permiso-error').addClass('d-none');
            $('#est_permiso-error').addClass('d-none');
            $('#nom_permiso').removeClass('is-invalid');
            $('#mod_permiso').removeClass('is-invalid');
            $('#est_permiso').parent().removeClass(' has-error-select2');
            $('#nom_permiso').val('');
            $('#mod_permiso').val('');
            $('#est_permiso').val("1").trigger("change");

            $('#est_permiso option:eq(2)').prop('disabled', true);
            $('#modalPermiso').modal('show');
        });

        // VERIFICAR SI EXISTE ERRORES
        $('#form-permiso').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            // Accione para agregar
            if ($('.action').val() == 'Agregar') {
                action_url = route('permisos.store');

            }

            // Accione para editar
            if ($('.action').val() == 'Editar') {
                action_url = route('permisos.update');
            }

            $.ajax({
                url: action_url,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        // MOSTRAR ERRORES PARA EL CAMPO PERMISO 
                        if (data.errors.mod_permiso) {
                            $('#mod_permiso-error').removeClass('d-none');
                            $('#mod_permiso').addClass('is-invalid');
                            $('#mod_permiso-error').html(data.errors.mod_permiso[0]);
                        }

                        if (data.errors.nom_permiso_hidden) {
                            $('#nom_permiso-error').removeClass('d-none');
                            $('#nom_permiso').addClass('is-invalid');
                            $('#nom_permiso-error').html(data.errors.nom_permiso_hidden[0]);
                        }

                        if (data.errors.est_permiso) {
                            $('#est_permiso-error').removeClass('d-none');
                            $('#est_permiso').parent().addClass(' has-error-select2');
                            $('#est_permiso-error').html(data.errors.est_permiso[0]);
                        }
                    }

                    if (data.success) {
                        if ($('.action').val() == 'Editar') {
                            toastr['info']('Registro actualizado correctamente');
                            // Limpiar errores y campos
                            $('#form-permiso')[0].reset();
                            $('#nom_permiso-error').empty();
                            $('#mod_permiso-error').empty();
                            $('#est_permiso-error').empty();
                            $('#nom_permiso-error').addClass('d-none');
                            $('#mod_permiso-error').addClass('d-none');
                            $('#est_permiso-error').addClass('d-none');
                            $('#nom_permiso').removeClass('is-invalid');
                            $('#mod_permiso').removeClass('is-invalid');
                            $('#est_permiso').parent().removeClass(' has-error-select2');
                            $('#nom_permiso').val('');
                            $('#mod_permiso').val('');
                            $('#est_permiso').val("1").trigger("change");
                            $('#tabla_permisos').DataTable().ajax.reload();
                            $('#modalPermiso').modal('hide');
                        } else {
                            toastr['success']('Registro agregado correctamente');
                            // Limpiar errores y campos
                            $('#form-permiso')[0].reset();
                            $('#nom_permiso-error').empty();
                            $('#mod_permiso-error').empty();
                            $('#est_permiso-error').empty();
                            $('#nom_permiso-error').addClass('d-none');
                            $('#mod_permiso-error').addClass('d-none');
                            $('#est_permiso-error').addClass('d-none');
                            $('#nom_permiso').removeClass('is-invalid');
                            $('#mod_permiso').removeClass('is-invalid');
                            $('#est_permiso').parent().removeClass(' has-error-select2');
                            $('#nom_permiso').val('');
                            $('#mod_permiso').val('');
                            $('#est_permiso').val("1").trigger("change");
                            $('#tabla_permisos').DataTable().ajax.reload();
                            $('#mod_permiso').focus();
                        }
                    }
                }
            });
        });


        // ************* LLAMANDO AL EDIT MODAL DESDE AJAX *************
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $('#nom_permiso-error').empty();
            $('#mod_permiso-error').empty();
            $('#est_permiso-error').empty();
            $('#nom_permiso-error').addClass('d-none');
            $('#mod_permiso-error').addClass('d-none');
            $('#est_permiso-error').addClass('d-none');
            $('#nom_permiso').removeClass('is-invalid');
            $('#mod_permiso').removeClass('is-invalid');
            $('#est_permiso').parent().removeClass(' has-error-select2');
            $('#est_permiso option:eq(2)').attr('disabled', false);

            $.ajax({
                url: '/permisos/' + id + '/edit',
                dataType: 'json',
                success: function(data) {

                    var cadena = data.permiso.name;
                    var contiene = cadena.includes("-");
                    var final = cadena.split('-');
                    if (contiene == true) {
                        nombre = final[1];
                    } else {
                        nombre = cadena;
                    }

                    $('#mod_permiso').val(data.permiso.module);
                    $('#nom_permiso').val(nombre);
                    $('#est_permiso').val(data.permiso.status).trigger('change');
                    $('#permiso_id').val(id);
                    $('.modal-title').text('Actualizar Permiso');
                    $('.action_button').text('Actualizar');
                    $('.action_button').prepend('<i class="far fa-sync-alt mr-2"></i>');
                    $('.action_button').removeClass('btn-danger');
                    $('.action_button').addClass('btn-info');
                    $('.action').val('Editar');
                    $('#modalPermiso').modal('show');
                }
            });
        });


        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');

            $.ajax({
                url: "permisos/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#lmod_permiso').text(data.permiso.module);

                    var cadena = data.permiso.name;
                    var contiene = cadena.includes("-");
                    var final = cadena.split('-');
                    if (contiene == true) {
                        nombre = final[1];
                    } else {
                        nombre = cadena;
                    }

                    $('#lnom_permiso').text(nombre);
                    if (data.permiso.status == '1') {
                        $('#lest_permiso').text('ACTIVO');
                    } else {
                        $('#lest_permiso').text('INACTIVO');
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
                url: '/permisos/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_permisos').DataTable().ajax.reload();
                    }, 400);
                }

            });
        });

        // SELECT2
        $('#est_permiso').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
        });

        // AUTOFOCUS PARA SELECT2 MODAL
        $('#modalPermiso').on('shown.bs.modal', function() {
            $('#mod_permiso').focus();
        });

    }

    // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
    function alerts() {

        $('#nom_permiso').on('keyup', function() {
            if ($('#nom_permiso-error').text() != '') {
                if ($(this).val().length) {
                    $('#nom_permiso-error').addClass('d-none');
                    $('#nom_permiso').removeClass('is-invalid');
                } else {
                    $('#nom_permiso-error').removeClass('d-none');
                    $('#nom_permiso').addClass('is-invalid');
                }
            }
        });

        $('#mod_permiso').on('keyup', function() {
            if ($('#mod_permiso-error').text() != '') {
                if ($(this).val().length) {
                    $('#mod_permiso-error').addClass('d-none');
                    $('#mod_permiso').removeClass('is-invalid');
                } else {
                    $('#mod_permiso-error').removeClass('d-none');
                    $('#mod_permiso').addClass('is-invalid');
                }
            }
        });

        $('#est_permiso').on('change', function() {
            if ($('#est_permiso-error').text() != '') {
                if ($(this).val() == '') {
                    $('#est_permiso-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#est_permiso-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });
    }



    // **************** GUARDAR PERMISO EN CAMPO OCULTO *******************
    function guardarPermiso() {

        $('.action_button').on('click', function() {
            var modulo = $('#mod_permiso').val().toUpperCase();
            var nombre = $('#nom_permiso').val().toUpperCase();
            var final = modulo + '-' + nombre;
            if (modulo != '' && nombre != '') {
                $('#nom_permiso_hidden').val(final);
                console.log('final');
            }
        });
    }


    init();

});
