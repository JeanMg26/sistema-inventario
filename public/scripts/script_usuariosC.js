$(document).ready(function() {

    function init() {

        $('#form-usuario').on('submit', function() {

            $('#rol').select2({
                width: '100%',
                placeholder: "SELECCIONAR...",
                allowClear: true,
                language: "es",

            }).on("change", function(e) {
                $(this).valid();
            });


            $('#est_usuario').select2({
                width: '100%',
                placeholder: "SELECCIONAR...",
                allowClear: true,
                minimumResultsForSearch: -1,
                language: "es",
            }).on("change", function(e) {
                $(this).valid();
            });

        });

        validations();
        events();
        alerts();
    }


    function events() {

        $('#rol').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });

        $('#est_usuario').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
        });

        // Desactivar option select
        $('#est_usuario option:eq(2)').prop('disabled', true);

    }


    function validations() {

        const reglas = {
            'nom_usu': {
                required: true,
                minlength: 6,
                maxlength: 50,
            },
            'email_usu': {
                required: true,
                email: true,
            },
            'rol_usu': {
                required: true,
            },
            'pass_usu': {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            'repass_usu': {
                required: true,
                equalTo: '#password_usu'
            },
            'est_usu': {
                required: true,
            }
        };

        const mensajes = {
            'nom_usu': {
                required: 'Ingresar el nombre de usuario.',
                minlength: 'Ingresar como mínimo de 6 caracacteres',
                maxlength: 'Ingresar como máximo 50 caracacteres.'
            },
            'rol_usu': {
                required: 'Seleccionar un rol.',
            },
            'email_usu': {
                required: 'Ingresar un correo electronico.',
                email: 'Ingresar un correo electronico valido.',
            },
            'pass_usu': {
                required: 'Ingresar una contraseña.',
                minlength: 'Ingresar como mínimo de 6 caracacteres',
                maxlength: 'Ingresar como máximo 20 caracacteres.'
            },
            'repass_usu': {
                required: 'Confirmar la contraseña.',
                equalTo: 'Las contraseñas no coincicen.'
            },
            'est_usu': {
                required: 'Seleccionar un estado.',
            }
        };

        Inventario.validacionGeneral('form-usuario', reglas, mensajes);

    }


    function alerts() {

        // *********** OCULTAR ALERTAS DE ERRORES SERVER-SIDE **************

        $('#nom_usuario').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().find('.alert').length) {
                    $('#nom_usu-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).next().next('#nom_usu-error').length) {
                    $('#nom_usu-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#email_usuario').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#email_usu-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#email_usu-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }

            }
        });

        $('#password_usu').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#pass_usu-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }

            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#pass_usu-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#repassword_usu').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#repass_usu-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }

            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#repass_usu-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }

            }
        });

        $('#rol').on('change', function() {
            if ($(this).val() == '') {
                if ($(this).parent().find('.alert').length) {
                    $('#rol_usu-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                }

            } else {
                if ($(this).parent().find('.alert').length) {
                    $('#rol_usu-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }

            }
        });

        $('#est_usuario').on('change', function() {
            if ($(this).val() == '') {
                if ($(this).parent().find('.alert').length) {
                    $('#est_usu-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                }

            } else {
                if ($(this).parent().find('.alert').length) {
                    $('#est_usu-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });
    }

    init();



});
