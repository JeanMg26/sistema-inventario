$(document).ready(function() {

    // ***************** ***************************************************
    // ***************** ACTUALIZAR PERFIL USUARIOS ************************

    // VERIFICAR SI EXISTE ERRORES
    $('#form-perfil_usuario').on('submit', function(event) {
        event.preventDefault();
        var action_url = '';
        var formData = new FormData($('#form-perfil_usuario')[0]);
        var token = $('input[name=_token]').val();

        // Accion para actualizar perfil
        if ($('.action').val() == 'ActualizarPerfil') {
            action_url = route('actualizar_perfil.usuario');
        }

        $.ajax({
            url: action_url,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {

                if (data.errors) {

                    if (data.errors.nom_usu) {
                        $('#nom_usu-error').removeClass('d-none');
                        $('#nom_usu-error').html(data.errors.nom_usu[0]);

                    } else {
                        $('#nom_usu-error').addClass('d-none');
                    }

                    if (data.errors.email_usu) {
                        $('#email_usu-error').removeClass('d-none');
                        $('#email_usu-error').html(data.errors.email_usu[0]);
                    } else {
                        $('#email_usu-error').addClass('d-none');
                    }

                    if (data.errors.rol_usu) {
                        $('#rol_usu-error').removeClass('d-none');
                        $('#rol_usu-error').html(data.errors.rol_usu[0]);
                    } else {
                        $('#rol_usu-error').addClass('d-none');
                    }

                    if (data.errors.oldpass_usu) {
                        $('#oldpass_usu-error').removeClass('d-none');
                        $('#oldpass_usu-error').html(data.errors.oldpass_usu[0]);
                    } else {
                        $('#oldpass_usu-error').addClass('d-none');
                    }

                    if (data.errors.pass_usu) {
                        $('#pass_usu-error').removeClass('d-none');
                        $('#pass_usu-error').html(data.errors.pass_usu[0]);
                    } else {
                        $('#pass_usu-error').addClass('d-none');
                    }

                    if (data.errors.repass_usu) {
                        $('#repass_usu-error').removeClass('d-none');
                        $('#repass_usu-error').html(data.errors.repass_usu[0]);
                    } else {
                        $('#repass_usu-error').addClass('d-none');
                    }

                    if (data.errors.imagen_usuario) {
                        $('#imagen_usuario-error').removeClass('d-none');
                        $('#imagen_usuario-error').html(data.errors.imagen_usuario[0]);
                    } else {
                        $('#imagen_usuario-error').addClass('d-none');
                    }
                }


                if (data.success) {
                    if ($('.action').val() == 'ActualizarPerfil') {
                        toastr.info('Perfil actualizado correctamente');
                        $('#form-perfil_usuario')[0].reset();
                        $('#nom_usu-error').addClass('d-none');
                        $('#email_usu-error').addClass('d-none');
                        $('#rol_usu-error').addClass('d-none');
                        $('#oldpass_usu-error').addClass('d-none');
                        $('#pass_usu-error').addClass('d-none');
                        $('#repass_usu-error').addClass('d-none');
                        $('#imagen_usuario-error').addClass('d-none');
                        $('#modalPerfilUsuario').modal('hide');
                        $('#perfil_usuario').load('/load_perfil');
                    }
                }
            }
        });
    });



    // ************* LLAMANDO AL EDIT MODAL DESDE AJAX *************
    $('.actualizar_perfil').on('click', function() {

        $('.modal-title').text('Actualizar Usuario');
        $('#nom_usu-error').addClass('d-none');
        $('#email_usu-error').addClass('d-none');
        $('#rol_usu-error').addClass('d-none');
        $('#oldpass_usu-error').addClass('d-none');
        $('#pass_usu-error').addClass('d-none');
        $('#repass_usu-error').addClass('d-none');
        $('#imagen_usuario-error').addClass('d-none');

        $('#miImagenInput').val('');
        $('#oldpass_usu').val('');
        $('#pass_usu').val('');
        $('#repass_usu').val('');
        $('#toggle-pass').bootstrapToggle('off');


        var id = $(this).attr('id');

        $.ajax({
            url: '/usuarios/' + id + '/editar_perfil',
            dataType: 'json',
            success: function(data) {
                $('#nom_usu').val(data.usuario.name);
                $('#rol_usuario').val(data.rol.name);
                $('#rol_usu').val(data.rol.id);
                $('#email_usu').val(data.usuario.email);
                $('#est_usu').val(data.usuario.status);
                // MOSTRAR IMAGEN
                if (data.usuario.rutaimagen == '' || data.usuario.rutaimagen == null) {
                    $('#mi_img_modal').attr('src', '/img/user.jpg');
                } else {
                    $('#mi_img_modal').attr('src', '/uploads/' + data.usuario.rutaimagen);
                }

                $('#perfilusuario_id').val(id);
                $('.action').val('ActualizarPerfil');
                $('#modalPerfilUsuario').modal('show');
            }
        });
    });

    // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
    $('#nom_usu').on('keyup', function() {
        $('#nom_usu-error').addClass('d-none');
    });

    $('#oldpass_usu').on('keyup', function() {
        $('#oldpass_usu-error').addClass('d-none');
    });

    $('#pass_usu').on('keyup', function() {
        $('#pass_usu-error').addClass('d-none');
    });

    $('#repass_usu').on('keyup', function() {
        $('#repass_usu-error').addClass('d-none');
    });


    // AUTOFOCUS PARA PERFIL USUARIO MODAL
    $('#modalPerfilUsuario').on('shown.bs.modal', function() {
        $('#nom_usu').focus();
    });

    // *************** TOGGLE PARA MODAL EDITAR USUARIO **************
    $('#toggle-pass').bootstrapToggle({
        on: 'Si',
        off: 'No',
        onstyle: 'success',
        offstyle: 'danger',
        size: 'small'
    });

    $('#toggle-pass').on('change', function() {
        if ($(this).prop('checked')) {
            $('#oldpass_usu').removeAttr('readonly');
            $('#pass_usu').removeAttr('readonly');
            $('#repass_usu').removeAttr('readonly');
            // Agregamos name a cda input para poder validar cuando el toggle esta activado
            $('#oldpass_usu').attr('name', 'oldpass_usu');
            $('#pass_usu').attr('name', 'pass_usu');
            $('#repass_usu').attr('name', 'repass_usu');
        } else {
            $('#oldpass_usu').attr('readonly', true);
            $('#pass_usu').attr('readonly', true);
            $('#repass_usu').attr('readonly', true);
            // Agregamos name a cda input para poder validar cuando el toggle esta activado
            $('#oldpass_usu').attr('name', 'oldpassword');
            $('#pass_usu').attr('name', 'password_usu');
            $('#repass_usu').attr('name', 'repassword_usu');
            // Ocultar las alertas
            $('#oldpass_usu-error').addClass('d-none');
            $('#pass_usu-error').addClass('d-none');
            $('#repass_usu-error').addClass('d-none');
            // Limpiar inputs
            $('#oldpass_usu').val('');
            $('#pass_usu').val('');
            $('#repass_usu').val('');
        }
    });




});
