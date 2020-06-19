$(document).ready(function() {

    // ************* CARGAR DATOS DEL EMPLEADO AL SELECCIONAR EQUIPO *************
    function cargarEmpleados() {

        var equipoID = $('#nom_equipo').val();
        $.ajax({
            url: route('datosempleado.data') + '?equipoid=' + equipoID,
            type: "GET",
            dataType: "json",
            success: function(empleado) {
                $('#empleado1').val('');
                $('#empleado1').addClass('d-none');
                $('#empleado2').val('');
                $('#empleado2').addClass('d-none');
                $('#imagen_emp1').attr('src', '');
                $('#imagen_emp1').addClass('d-none');
                $('#imagen_emp2').attr('src', '');
                $('#imagen_emp2').addClass('d-none');

                $.each(empleado, function(index, data) {

                    if (index == '0') {
                        $('#empleado1').val(data.rol + ' - ' + data.completos);
                        $('#empleado1').removeClass('d-none');
                        // Comprobar si tiene imagen
                        if (data.imagen == '' || data.imagen == null) {
                            $('#imagen_emp1').attr('src', '/img/user.jpg');
                        } else {
                            $('#imagen_emp1').attr('src', '/uploads/' + data.imagen);
                        }
                        $('#imagen_emp1').removeClass('d-none');
                    }
                    if (index == '1') {
                        $('#empleado2').val(data.rol + ' - ' + data.completos);
                        $('#empleado2').removeClass('d-none');
                        // Comprobar si tiene imagen
                        if (data.imagen == '' || data.imagen == null) {
                            $('#imagen_emp2').attr('src', '/img/user.jpg');
                        } else {
                            $('#imagen_emp2').attr('src', '/uploads/' + data.imagen);
                        }
                        $('#imagen_emp2').removeClass('d-none');
                    }
                });
            }
        });
    }
    cargarEmpleados();
    $('#nom_equipo').on('change', cargarEmpleados);
    // ********************* FIN *************************


    // ************* SELECT ANINADO PARA LOCAL - AREA **********************
    function cargarAreas() {
        var locales_id = $('#local').val();
        $.ajax({
            url: route('coordinacion_areas.data') + '?localID=' + locales_id,
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $('#area').select2({ placeholder: 'CARGANDO AREAS...' });
            },
            success: function(area) {
                var old = $('#area').data('old') != '' ? $('#area').data('old') : '';
                $('#area').empty();
                $('#area').select2({
                    width: '100%',
                    placeholder: "SELECCIONAR...",
                    allowClear: true,
                    language: "es",
                }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
                $.each(area, function(index, data) {
                    $('#area').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.codarea + ' - ' + data.descripcion) + "</option>";
                });
                cargarOficinas();
            }
        })
    }
    cargarAreas();
    $('#local').on('change', cargarAreas);
    // ********************************* FIN **********************************


    // ************* SELECT ANINADO PARA AREA - OFICINA **********************
    function cargarOficinas() {
        var areas_id = $('#area').val();
        $.ajax({
            url: route('coordinacion_oficinas.data') + '?areaID=' + areas_id,
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $('#oficina').select2({ placeholder: 'CARGANDO OFICINAS...' });
            },
            success: function(oficina) {
                var old = $('#oficina').data('old') != '' ? $('#oficina').data('old') : '';
                $('#oficina').empty();
                $('#oficina').select2({
                    width: '100%',
                    placeholder: "SELECCIONAR...",
                    allowClear: true,
                    language: "es",
                }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
                $.each(oficina, function(index, data) {
                    $('#oficina').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.codoficina + ' - ' + data.descripcion) + "</option>";
                });
            }
        });
    }
    cargarOficinas();
    $('#area').on('change', cargarOficinas);
    // ********************************* FIN **********************************


    function init() {

        $('#form-coordinacion').on('submit', function() {

            $('#nom_equipo').select2({
                width: '100%',
                placeholder: "SELECCIONAR...",
                allowClear: true,
                language: "es",
            }).on("change", function(e) {
                $(this).valid();
            });

            $('#local').select2({
                width: '100%',
                placeholder: "SELECCIONAR...",
                allowClear: true,
                language: "es",
            }).on("change", function(e) {
                $(this).valid();
            });

            $('#area').select2({
                width: '100%',
                placeholder: "SELECCIONAR...",
                allowClear: true,
                language: "es",
            }).on("change", function(e) {
                $(this).valid();
            });

            $('#oficina').select2({
                width: '100%',
                placeholder: "SELECCIONAR...",
                allowClear: true,
                language: "es",
            }).on("change", function(e) {
                $(this).valid();
            });

            $('.datepicker').datepicker({
                'format': 'dd-mm-yyyy',
                'autoclose': true,
                'todayHighlight': true,
                'language': "es"
            }).on('change', function() {
                $(this).valid();
            });

            // ***************** VALIDATE CLIENT-SIDE - SELECT DINAMICO **************************
            $('#local').on('change', function() {
                if ($(this).val() == '') {
                    if ($('#local-error').text() != '') {
                        // Agregar errores a los select dinamicos
                        $('#area-error').text('Selecciona el área.');
                        $('#area').parent().addClass(' has-error-select2');
                        $('#oficina-error').text('Selecciona la oficina.');
                        $('#oficina').parent().addClass(' has-error-select2');
                    }
                }
            });

            $('#area').on('change', function() {
                if ($(this).val() == '' || $(this).val() == null) {
                    if ($('#area-error').text() != '') {
                        // Agregar errores a los select dinamicos
                        $('#oficina-error').text('Selecciona la oficina.');
                        $('#oficina').parent().addClass(' has-error-select2');
                    }
                }
            });
            // ***********************************************************************************

        });

        mostrarBotonEstado();
        guardarBotonEstado();
        alerts();
        validations();
        events();

    }

    function events() {
        $('#nom_equipo').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });

        $('#local').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });
        $('#area').select2({
            width: '100%',
            // placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });
        $('#oficina').select2({
            width: '100%',
            // placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });
        // ********** DATEPICKER *******************/
        $('.datepicker').datepicker({
            'format': 'dd-mm-yyyy',
            'autoclose': true,
            'todayHighlight': true,
            'language': "es"
        });



        // ********** OCULTAR INPUTS CUANDO SELECT ESTA VACIO *************

        $('#nom_equipo').on('change', function() {
            if ($(this).val().trim() === '') {
                $('#empleado1').addClass('d-none');
                $('#empleado2').addClass('d-none');
                $('#imagen_emp1').addClass('d-none');
                $('#imagen_emp2').addClass('d-none');
            }
        });
    }



    // ************* RECONOCER BOTON ESTADO AL ABRIR VENTANA EDITAR ****************
    function mostrarBotonEstado() {
        var btn_estado = $('#recibir_estado').val();
        if (btn_estado === '1') {
            $('#boton_estado').val('CERRADO');
            $('#boton_estado').text('CERRADO');
            $('#boton_estado').removeClass('btn-ok');
            $('#boton_estado').addClass('btn-danger');
            $('#boton_estado').prepend('<i class="fas fa-lock-alt mr-2"></i>');
            $('#hoja_ent').attr('readonly', true);
            $('#sticker_ent').attr('readonly', true);
            // desactivar datepicker para ese input
            $("#fec_ent").css('pointer-events', 'none');
            $('#hoja_ret').attr('readonly', true);
            $('#sticker_ret').attr('readonly', true);
            $('#adic_ret').attr('readonly', true);
            // desactivar datepicker para ese input
            $("#fec_ret").css('pointer-events', 'none');
            $('#bienes_ubi').attr('readonly', true);
            $('#bienes_noubi').attr('readonly', true);
            $('#bienes_adic').attr('readonly', true);
            $('#observacion').attr('readonly', true);
            // *********** Agregando atributo readonly creado con css para select2 **********
            $('#nom_equipo').attr('readonly', 'readonly');
            $('#local').attr('readonly', 'readonly');
            $('#area').attr('readonly', 'readonly');
            $('#oficina').attr('readonly', 'readonly');


        } else {
            $('#boton_estado').val('ABIERTO');
            $('#boton_estado').text('ABIERTO');
            $('#boton_estado').removeClass('btn-danger');
            $('#boton_estado').addClass('btn-ok');
            $('#boton_estado').prepend('<i class="fas fa-lock-open-alt mr-2"></i>');
            $('#hoja_ent').attr('readonly', false);
            $('#sticker_ent').attr('readonly', false);
            // ********** activar datepicker para ese input **********
            $("#fec_ent").css('pointer-events', '');
            $('#hoja_ret').attr('readonly', false);
            $('#sticker_ret').attr('readonly', false);
            $('#adic_ret').attr('readonly', false);
            // ********* desactivar datepicker para ese input ***********
            $("#fec_ret").css('pointer-events', '');
            $('#bienes_ubi').attr('readonly', false);
            $('#bienes_noubi').attr('readonly', false);
            $('#bienes_adic').attr('readonly', false);
            $('#observacion').attr('readonly', false);
            // ****** Quitando atributo readonly a select *******
            $('#nom_equipo').removeAttr('readonly');
            $('#local').removeAttr('readonly');
            $('#area').removeAttr('readonly');
            $('#oficina').removeAttr('readonly');

        }
    }
    // ************* ENVIAR ESTADO AL CONTROLLADOR ****************
    function guardarBotonEstado() {
        $('#boton_estado').on('click', function() {
            if ($(this).val() == 'ABIERTO') {

                Swal.fire({
                    title: "Deseas cerrar el folio?",
                    text: "El folio será cerrado y pasado a procesamiento.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, Cerrar",
                    cancelButtonText: "No, Cancelar",
                    customClass: {
                        confirmButton: 'btn btn-success btn-lg mr-3',
                        cancelButton: 'btn btn-secondary btn-lg'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.value) {

                        $('#boton_estado').val('CERRADO');
                        $('#boton_estado').text('CERRADO');
                        $('#boton_estado').removeClass('btn-ok');
                        $('#boton_estado').addClass('btn-danger');
                        $('#boton_estado').prepend('<i class="fas fa-lock-alt mr-2"></i>');
                        $('#recibir_estado').val('1');
                        $('#hoja_ent').attr('readonly', true);
                        $('#sticker_ent').attr('readonly', true);
                        // desactivar datepicker para ese input
                        $("#fec_ent").css('pointer-events', 'none');
                        $('#hoja_ret').attr('readonly', true);
                        $('#sticker_ret').attr('readonly', true);
                        $('#adic_ret').attr('readonly', true);
                        // desactivar datepicker para ese input
                        $("#fec_ret").css('pointer-events', 'none');
                        $('#bienes_ubi').attr('readonly', true);
                        $('#bienes_noubi').attr('readonly', true);
                        $('#bienes_adic').attr('readonly', true);
                        $('#observacion').attr('readonly', true);
                        // *********** Agregando atributo readonly creado con css para select2 **********
                        $('#nom_equipo').attr('readonly', 'readonly');
                        $('#local').attr('readonly', 'readonly');
                        $('#area').attr('readonly', 'readonly');
                        $('#oficina').attr('readonly', 'readonly');

                        Swal.fire({
                            title: "Cerrado",
                            text: "El folio fue cerrado exitosamente.",
                            type: "success",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: 'btn btn-success btn-lg px-4',
                            },
                            buttonsStyling: false
                        });
                    }
                }); // ******* CIERRE DE SWALL **********//

            } else {

                Swal.fire({
                    title: "Deseas abrir el folio?",
                    text: "El folio será abierto y pasado a coordinación.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, Abrir",
                    cancelButtonText: "No, Cancelar",
                    customClass: {
                        confirmButton: 'btn btn-success btn-lg mr-3',
                        cancelButton: 'btn btn-secondary btn-lg'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.value) {

                        $('#boton_estado').val('ABIERTO');
                        $('#boton_estado').text('ABIERTO');
                        $('#boton_estado').removeClass('btn-danger');
                        $('#boton_estado').addClass('btn-ok');
                        $('#boton_estado').prepend('<i class="fas fa-lock-open-alt mr-2"></i>');
                        $('#recibir_estado').val('0');
                        $('#hoja_ent').attr('readonly', false);
                        $('#sticker_ent').attr('readonly', false);
                        // *********** activar datepicker para ese input ***********
                        $("#fec_ent").css('pointer-events', '');
                        $('#hoja_ret').attr('readonly', false);
                        $('#sticker_ret').attr('readonly', false);
                        $('#adic_ret').attr('readonly', false);
                        // ********** desactivar datepicker para ese input ************
                        $("#fec_ret").css('pointer-events', '');
                        $('#bienes_ubi').attr('readonly', false);
                        $('#bienes_noubi').attr('readonly', false);
                        $('#bienes_adic').attr('readonly', false);
                        $('#observacion').attr('readonly', false);
                        // ****** Quitando atributo readonly a select *****
                        $('#nom_equipo').removeAttr('readonly');
                        $('#local').removeAttr('readonly');
                        $('#area').removeAttr('readonly');
                        $('#oficina').removeAttr('readonly');

                        Swal.fire({
                            title: "Abierto",
                            text: "El folio fue abierto exitosamente.",
                            type: "success",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: 'btn btn-success btn-lg px-4',
                            },
                            buttonsStyling: false
                        });
                    }
                }); // ******* CIERRE DE SWALL **********//
            }

        }); // ******** CIERRE DE LA BOTON ESTADO *************
    }


    function validations() {

        // Nueva Regla - Mayor o Igual - Fechas
        $.validator.addMethod("mayorOigual", function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) >= new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) || (Number(value) >= Number($(params).val()));
        }, 'La fecha de retorno debe ser mayor o igual a la fecha de entrega.');


        const reglas = {
            'nom_equipo': {
                required: true,
            },
            'local': {
                required: true,
            },
            'area': {
                required: true,
            },
            'oficina': {
                required: true,
            },
            'hoja_ent': {
                required: true,
                number: true,
                maxlength: 3,
            },
            'sticker_ent': {
                required: true,
                number: true,
                maxlength: 3,
            },
            'fec_ent': {
                required: true,
            },
            'hoja_ret': {
                required: true,
                number: true,
                maxlength: 3,
            },
            'sticker_ret': {
                required: true,
                number: true,
                maxlength: 3,
            },
            'adic_ret': {
                number: true,
                maxlength: 3,
            },
            'fec_ret': {
                required: true,
                mayorOigual: "#fec_ent"
            },
            'bienes_ubi': {
                required: true,
                number: true,
                maxlength: 3,
            },
            'bienes_noubi': {
                required: true,
                number: true,
                maxlength: 3,
            },
            'bienes_adic': {
                number: true,
                maxlength: 3,
            },
        };

        const mensajes = {
            'nom_equipo': {
                required: 'Seleccionar el nombre del equipo.',
            },
            'local': {
                required: 'Seleccionar el local',
            },
            'area': {
                required: 'Seleccionar el área.',
            },
            'oficina': {
                required: 'Seleccionar la oficina.',
            },
            'hoja_ent': {
                required: 'Ingresar la cantidad de hojas entregadas.',
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres',
            },
            'sticker_ent': {
                required: 'Ingresar la cantidad de stickers entregados.',
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres.',
            },
            'fec_ent': {
                required: 'Ingresar una fecha válida.',
            },
            'hoja_ret': {
                required: 'Ingresar la cantidad de hojas retornadas.',
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres.',
            },
            'sticker_ret': {
                required: 'Ingresar la stickers retornados.',
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres.',
            },
            'adic_ret': {
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres.',
            },
            'fec_ret': {
                required: 'Ingresar una fecha válida.',
            },
            'bienes_ubi': {
                required: 'Ingresar la cantidad de bienes ubicados.',
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres.',
            },
            'bienes_noubi': {
                required: 'Ingresar la cantidad de bienes no ubicados.',
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres.',
            },
            'bienes_adic': {
                number: 'Ingresar solo números.',
                maxlength: 'Ingresar como máximo 3 caracteres.',
            },

        };

        Inventario.validacionGeneral('form-coordinacion', reglas, mensajes);

    }


    function alerts() {

        // *********** OCULTAR ALERTAS DE ERRORES SERVER-SIDE **************

        $('#nom_equipo').on('change', function() {
            if ($(this).val() == '') {
                if ($(this).parent().find('.alert').length) {
                    $('#nom_equipo-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                }
            } else {
                if ($(this).parent().find('.alert').length) {
                    $('#nom_equipo-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#local').on('change', function() {
            if ($(this).val() == '') {
                if ($(this).parent().find('.alert').length) {
                    $('#local-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                    // Agregar errores a los select dinamicos
                    $('#area-error').removeClass('d-none');
                    $('#area').parent().addClass(' has-error-select2');
                    $('#oficina-error').removeClass('d-none');
                    $('#oficina').parent().addClass(' has-error-select2');
                }
            } else {
                if ($(this).parent().find('.alert').length) {
                    $('#local-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#area').on('change', function() {
            if ($(this).val() == '' || $(this).val() == null) {
                if ($(this).parent().find('.alert').length) {
                    $('#area-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                    // Agregar errores a los select dinamicos
                    $('#oficina-error').removeClass('d-none');
                    $('#oficina').parent().addClass(' has-error-select2');
                }
            } else {
                if ($(this).parent().find('.alert').length) {
                    $('#area-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#oficina').on('change', function() {
            if ($(this).val() == '' || $(this).val() == null) {
                if ($(this).parent().find('.alert').length) {
                    $('#oficina-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                }
            } else {
                if ($(this).parent().find('.alert').length) {
                    $('#oficina-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#hoja_ent').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#hoja_ent-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#hoja_ent-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#sticker_ent').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#sticker_ent-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#sticker_ent-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#fec_ent').on('change', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#fec_ent-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#fec_ent-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#hoja_ret').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#hoja_ret-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#hoja_ret-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#sticker_ret').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#sticker_ret-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#sticker_ret-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#adic_ret').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#adic_ret-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#adic_ret-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#fec_ret').on('change', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#fec_ret-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#fec_ret-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#bienes_ubi').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#bienes_ubi-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#bienes_ubi-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#bienes_noubi').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#bienes_noubi-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#bienes_noubi-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

        $('#bienes_adic').on('keyup', function() {
            if ($(this).val().length) {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#bienes_adic-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error');
                }
            } else {
                if ($(this).parent().parent().find('.alert').length) {
                    $('#bienes_adic-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error');
                }
            }
        });

    }







    init();
});
