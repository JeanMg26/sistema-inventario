$(document).ready(function() {

    function init() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var table = $('#tabla_equipos').DataTable({
            serverSide: true,
            pageLength: 15,
            order: [
                [1, 'asc']
            ],
            dom: '<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('equipos.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
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
                    data: 'opciones',
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
            },

        });

        // BUSQUEDA INDIVIDUAL POR COLUMNA
        $('#buscar_columna1').on('keyup', function() {
            table.columns(1).search(this.value).draw();
        });

        $('#buscar_columna2').on('keyup', function() {
            table.columns(2).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_equipos thead tr th').css('pointer-events', 'none');

        // ***************************************************************************
        // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

        table.on('click', '.toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var toggle_id = $(this).find('.toggle-class').attr('id');
            var equipo_id = $(this).find('.toggle-class').data('id');

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
                            url: route('cambiar.estadoequipo'),
                            data: { 'estado': estado, 'equipo_id': equipo_id },
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
                            url: route('cambiar.estadoequipo'),
                            data: { 'estado': estado, 'equipo_id': equipo_id },
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

        alerts();
        events();
    }

    function events() {

        // LLAMANDO A MODAL PARA AGREGAR REGISTRO
        $('#crear_registro').on('click', function() {
            $('.modal-title').text('Nuevo Equipo');
            $('.action_button').text('Guardar');
            $('.action_button').prepend('<i class="fas fa-save mr-2">');
            $('.action_button').removeClass('btn-info');
            $('.action_button').addClass('btn-danger');
            $('#action').val('Agregar');

            $('#nom_equi-error').empty();
            $('#est_equi-error').empty();
            $('#nom_equi-error').addClass('d-none');
            $('#est_equi-error').addClass('d-none');
            $('#nom_equi').removeClass('is-invalid');
            $('#est_equi').parent().removeClass(' has-error-select2');
            $('#nom_equi').val('');
            $('#est_equi').val("1").trigger("change");

            $('#est_equi option:eq(2)').prop('disabled', true);
            $('#modalEquipo').modal('show');
        });

        // VERIFICAR SI EXISTE ERRORES
        $('#form-equipo').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            // Accione para agregar
            if ($('#action').val() == 'Agregar') {
                action_url = route('equipos.store');

            }

            // Accione para editar
            if ($('#action').val() == 'Editar') {
                action_url = route('equipos.update');
            }

            $.ajax({
                url: action_url,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        if (data.errors.nom_equi) {
                            $('#nom_equi-error').removeClass('d-none');
                            $('#nom_equi').addClass('is-invalid');
                            $('#nom_equi-error').html(data.errors.nom_equi[0]);
                        }

                        if (data.errors.est_equi) {
                            $('#est_equi-error').removeClass('d-none');
                            $('#est_equi').parent().addClass(' has-error-select2');
                            $('#est_equi-error').html(data.errors.est_equi[0]);
                        }
                    }

                    if (data.success) {
                        if ($('#action').val() == 'Editar') {
                            toastr['info']('Registro actualizado correctamente');
                            // Limpiar errores y campos
                            $('#form-equipo')[0].reset();
                            $('#nom_equi-error').empty();
                            $('#est_equi-error').empty();
                            $('#nom_equi-error').addClass('d-none');
                            $('#est_equi-error').addClass('d-none');
                            $('#nom_equi').removeClass('is-invalid');
                            $('#est_equi').parent().removeClass(' has-error-select2');
                            $('#nom_equi').val('');
                            $('#est_equi').val("1").trigger("change");
                            $('#tabla_equipos').DataTable().ajax.reload();
                            $('#modalEquipo').modal('hide');
                        } else {
                            toastr['success']('Registro agregado correctamente');
                            // Limpiar errores y campos
                            $('#form-equipo')[0].reset();
                            $('#nom_equi-error').empty();
                            $('#est_equi-error').empty();
                            $('#nom_equi-error').addClass('d-none');
                            $('#est_equi-error').addClass('d-none');
                            $('#nom_equi').removeClass('is-invalid');
                            $('#est_equi').parent().removeClass(' has-error-select2');
                            $('#nom_equi').val('');
                            $('#est_equi').val("1").trigger("change");
                            $('#tabla_equipos').DataTable().ajax.reload();
                            $('#nom_equi').focus();
                        }
                    }

                }
            })
        });

        // ************* LLAMANDO AL EDIT MODAL DESDE AJAX *************
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $('#nom_equi-error').empty();
            $('#est_equi-error').empty();
            $('#nom_equi-error').addClass('d-none');
            $('#est_equi-error').addClass('d-none');
            $('#nom_equi').removeClass('is-invalid');
            $('#est_equi').parent().removeClass(' has-error-select2');
            $('#est_equi option:eq(2)').attr('disabled', false);

            $.ajax({
                url: '/equipos/' + id + '/edit',
                dataType: 'json',
                success: function(data) {
                    $('#nom_equi').val(data.result.nombre);
                    $('#est_equi').val(data.result.estado).trigger('change');
                    $('#equipo_id').val(id);
                    $('.modal-title').text('Actualizar Equipo');
                    $('.action_button').text('Actualizar');
                    $('.action_button').prepend('<i class="far fa-sync-alt mr-2"></i>');
                    $('.action_button').removeClass('btn-danger');
                    $('.action_button').addClass('btn-info');
                    $('#action').val('Editar');
                    $('#modalEquipo').modal('show');
                }
            });

        });


        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            $('.modal-title').text('Detalle del Registro');
            var show_id = $(this).attr('id');

            $.ajax({
                url: "equipos/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#lnom_equipo').text(data.equipo.nombre);
                    if (data.equipo.estado == '1') {
                        $('#lest_equi').text('ACTIVO');
                    } else {
                        $('#lest_equi').text('INACTIVO');
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
                url: '/equipos/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_equipos').DataTable().ajax.reload();
                    }, 400);
                }

            });
        });

        // AUTOFOCUS PARA SELECT2 MODAL
        $('#modalEquipo').on('shown.bs.modal', function() {
            $('#nom_equi').focus();
        });

        // ********* SELECT2 ************
        $('#est_equi').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
        });
    }


    function alerts() {

        // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
        $('#nom_equi').on('keyup', function() {
            if ($('#nom_equi-error').text() != '') {
                if ($(this).val().length) {
                    $('#nom_equi-error').addClass('d-none');
                    $('#nom_equi').removeClass('is-invalid');
                } else {
                    $('#nom_equi-error').removeClass('d-none');
                    $('#nom_equi').addClass('is-invalid');
                }
            }
        });


        $('#est_equi').on('change', function() {
            if ($('#est_equi-error').text() != '') {
                if ($(this).val() == '') {
                    $('#est_equi-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#est_equi-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

    }



    init();

});
