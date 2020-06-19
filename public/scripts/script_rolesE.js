$(document).ready(function() {

    function init() {

        validations();
        alerts();
        events();
    }

    function events() {

        // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************

        $('#form-rol').on('submit', function() {

         $('#est_rol').select2({
                width: '100%',
                placeholder: "SELECCIONAR...",
                allowClear: true,
                minimumResultsForSearch: -1,
                language: "es",
            }).on("change", function(e) {
                $(this).valid();
            });


            $('#error-permiso-query').removeClass('d-none'); // solucion a un bug

            // Regla para ocultar y mostrar errores del card - permisos (client-side)
            $('input[type="checkbox"]').on('change', function() {

                var error = $('#error-permiso-query').find('.invalid-feedback').text();
                var checks = $('[name="permisos[]"]:checked').length;

                if (error != '') {
                    if (checks) {
                        $('#error-permiso-query').addClass('d-none');
                        $('#error-permiso-query').prev().prev().removeClass('has-error-card');
                    } else {
                        $('#error-permiso-query').removeClass('d-none');
                        $('#error-permiso-query').prev().prev().addClass('has-error-card');
                    }
                }
            });

            // Ocultar selectpicker 
            $('.selectpicker').on('change', function() {
                var padre = $(this).parent().parent();
                var padre_directo = $(this).parent();
                var error = padre.find('.invalid-feedback');

                if ($(this).val() == '' && error.text() != '') {
                    error.removeClass('d-none');
                    padre_directo.addClass('has-error-selectpicker');
                } else {
                    error.addClass('d-none');
                    padre_directo.removeClass('has-error-selectpicker');
                }
            });

        });

        // SELECT2
        $('#est_rol').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
        });


        // ********** ACTIVAR BOOTSRAP TOOGLE ***************
        $('.toggle-one').bootstrapToggle({
            on: '<i class="far fa-check"></i>',
            off: '<i class="far fa-times"></i>'
        });
    }

    function validations() {

        const reglas = {
            'nom_rol': {
                required: true,
            },
            'permisos[]': {
                required: true,
            },
            'est_rol': {
                required: true,
            }
        };

        const mensajes = {
            'nom_rol': {
                required: 'Ingresar el nombre del rol.'
            },
            'permisos[]': {
                required: 'Seleccionar como mínimo un permiso.',
            },
            'est_rol': {
                required: 'Seleccionar el estado.',
            }
        };

        Inventario.validacionGeneral('form-rol', reglas, mensajes);
    }


    function alerts() {

        $("#nom_rol").on("keyup", function() {

            if ($(this).val().length) {
                // Remover solo cuando exista errores por parte del servidor
                $('#nom_rol-alerta').addClass('d-none');
                if ($(this).next().next('#nom_rol-alerta').length) {
                    $(this).closest('.form-group').removeClass('has-error');
                }
            } else {
                // Agregar solo cuando exista errores por parte del servidor
                $('#nom_rol-alerta').removeClass('d-none');
                if ($(this).next().next('#nom_rol-alerta').length) {
                    $(this).closest('.form-group').addClass('has-error');
                }
            }
        });


        $('input[type="checkbox"]').on('change', function() {

            var checks = $('[name="permisos[]"]:checked').length;
            var error = $('.card').find('#permisos-alerta').length;

            if (error) {
                if (checks) {
                    $('#permisos-alerta').addClass('d-none');
                    $('.card').removeClass('has-error-card');
                } else {
                    $('#permisos-alerta').removeClass('d-none');
                    $('.card').addClass('has-error-card');
                }
            }
        });

        $('#est_rol').on('change', function() {
            if ($(this).val() == '') {
                if ($(this).parent().find('.alert').length) {
                    $('#est_rol-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                }
            } else {
                if ($(this).parent().find('.alert').length) {
                    $('#est_rol-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

    }

    init();

});
