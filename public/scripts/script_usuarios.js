$(document).ready(function() {

    function init() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#tabla_usuarios').DataTable({
            // ordering: false,
            serverSide: true,
            pageLength: 15,
            order: [
                [3, 'asc']
            ],
            processing: true,
            dom: 'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('usuarios.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'rutaimagen',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (row.rutaimagen == '' || row.rutaimagen == null) {
                            return '<img class="img-fluid" width="50px" src="img/user.jpg">';
                        } else
                            return '<img class="img-fluid" width="50px" src="/uploads/' + data + '">';
                    }
                },
                {
                    data: 'name',
                    name: 'users.name'
                },
                {
                    data: 'email',
                    name: 'users.email'
                },
                {
                    data: 'role',
                    name: 'roles.name',
                    render: function(data, type, row) {
                        return '<label class="badge badge-success">' + row.role + '</label>';
                    }
                },
                {
                    data: 'checkbox-estado',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'users.created_at',
                    visible: false,
                },

                {
                    data: 'acciones',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [{
                targets: [6],
                render: function(data) {
                    return moment(data).format('YYYY');
                }
            }, ],
            language: {
                url: 'js/datatable-es.json',
            },
            drawCallback: function() {
                $('.toggle-class').bootstrapToggle({
                    on: '<i class="far fa-check"></i>',
                    off: '<i class="far fa-times"></i>'
                });
            }

        });

        // BUSQUEDA INDIVIDUAL POR COLUMNA

        $('#buscar_columna2').on('keyup', function() {
            table.columns(2).search(this.value).draw();
        });

        $('#buscar_columna3').on('keyup', function() {
            table.columns(3).search(this.value).draw();
        });

        $('#buscar_select1').change(function() {
            table.columns(4).search(this.value).draw();
        });

        $('#year').change(function() {
            table.columns(5).search(this.value).draw();
        });


        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_usuarios thead tr th').css('pointer-events', 'none');

        // ***************************************************************************
        // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

        table.on('click', '.toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var toggle_id = $(this).find('.toggle-class').attr('id');
            var usuario_id = $(this).find('.toggle-class').data('id');

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
                            url: route('cambiar.estadousuario'),
                            data: { 'estado': estado, 'usuario_id': usuario_id },
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
                            url: route('cambiar.estadousuario'),
                            data: { 'estado': estado, 'usuario_id': usuario_id },
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



        events();
    }

    function events() {



        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
         $('.modal-title').text('Detalle del Registro');
            var show_id = $(this).attr('id');

            $.ajax({
                url: "usuarios/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    if (data.usuario.empleados_id == null) {
                        $('#lnom_emp').text('---------------');
                        $('#lequipo_emp').text('---------------');
                        $('#lprof_emp').text('---------------');
                        $('#lnom_usu').text(data.usuario.name);
                        $('#lemail_usu').text(data.usuario.email);
                        $('#lrol_usu').text(data.rol.name);
                        // ESTADO DEL USUARIO Y EMPLEADO
                        if (data.usuario.status == '1') {
                            $('#lest_usu').text('ACTIVO');
                        } else {
                            $('#lest_usu').text('INACTIVO');
                        }
                        $('#limagen_emp').attr('src', '/img/user.jpg');
                        $('#usuario_empleado').addClass('d-none');
                        $('#showModal').modal('show');

                    } else {
                        $('#usuario_empleado').removeClass('d-none');

                        $('#lnom_emp').text(data.empleado.completos);
                        $('#lequipo_emp').text(data.equipo.nombre);
                        $('#lprof_emp').text(data.profesion.nombre);
                        $('#lnom_usu').text(data.usuario.name);
                        $('#lemail_usu').text(data.usuario.email);
                        $('#lrol_usu').text(data.rol.name);
                        if (data.empleado.rutaimagen == '') {
                            $('#limagen_emp').attr('src', '/img/user.jpg');
                        } else {
                            $('#limagen_emp').attr('src', '/uploads/' + data.empleado.rutaimagen);
                        }
                        // ESTADO DEL USUARIO Y EMPLEADO
                        if (data.usuario.status == '1') {
                            $('#lest_usu').text('ACTIVO');
                        } else {
                            $('#lest_usu').text('INACTIVO');
                        }
                        $('.modal-title').text('Detalle del Registro');
                        $('#showModal').modal('show');

                    }


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
                url: '/usuarios/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_usuarios').DataTable().ajax.reload();
                    }, 400);
                }
            });
        });


        //************* RESET PASSWORD *********************
        var reset_id;
        $(document).on('click', '.reset', function() {
            reset_id = $(this).attr('id');
            $('#resetModal').modal('show');
            $('.modal-title').text('Restablecer Contraseña');
            $('#reset_button').text('Si, Eliminar');
        });

        $('#reset_button').on('click', function() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: route('reset.password'),
                data: { 'reset_id': reset_id },
                beforeSend: function() {
                    $('#reset_button').text('Restableciendo...');
                    toastr['info']('Contraseña restablecida correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#resetModal').modal('hide');
                    }, 400);
                }
            })
        });

        // ****************** BORRRAR FILTROS **********************
        $('#btn-filtro').on('click', function() {
            $('#buscar_columna2').val('').keyup();
            $('#buscar_columna3').val('').keyup();
            $('#buscar_select1').val('').trigger('change');
        });

        
        // *************** ///FIN TOGGLE PARA MODAL EDITAR USUARIO **************

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
