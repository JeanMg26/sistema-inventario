$(document).ready(function() {

    function init() {

        // $.fn.dataTable.ext.errMode = 'throw';
        var table = $('#tabla_bienes').DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            pageLength: 15,
            order: [
                [2, 'asc']
            ],
            dom: 'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('bienes.data'),
            },
            columns: [
                // { data: 'id', name: 'id' },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'codbien', name: 'codbien' },
                { data: 'descripcion', name: 'descripcion' },
                {
                    data: "codlocal",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" rel="tooltip" data-placement="top" title="' + oData['local'] + '">' + oData['codlocal'] + '</span>');
                    }
                },
                {
                    data: "codarea",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['area'] + '">' + oData['codarea'] + '</span>');
                    }
                },
                {
                    data: "codoficina",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['oficina'] + '">' + oData['codoficina'] + '</span>');
                    }
                },
                {
                    data: 'marca',
                    name: 'marca',
                    render: function(data, type, row) {
                        if (row.marca == '' || row.marca == null) {
                            return '-';
                        } else {
                            return row.marca;
                        }
                    }
                },
                {
                    data: 'modelo',
                    name: 'modelo',
                    render: function(data, type, row) {
                        if (row.modelo == '' || row.modelo == null) {
                            return '-';
                        } else {
                            return row.modelo;
                        }
                    }
                },
                {
                    data: 'color',
                    name: 'color',
                    render: function(data, type, row) {
                        if (row.color == '' || row.color == null) {
                            return '-';
                        } else {
                            return row.color;
                        }
                    }
                },
                {
                    data: 'serie',
                    name: 'serie',
                    render: function(data, type, row) {
                        if (row.serie == '' || row.serie == null) {
                            return '-';
                        } else {
                            return row.serie;
                        }
                    }
                },
                { data: 'cod_completo', name: 'cod_completo', visible: false },
                { data: 'opciones', name: 'opciones', orderable: false, searchable: false },

            ],
            language: {
                url: 'js/datatable-es.json',
            },

            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            },

            rowCallback: function(row, data, index) {

                if (data.sit_bien === 'U') {
                    $(row).find('td').css('background-color', '#d3f9d8');
                } else {
                    $(row).find('td').css('background-color', '#ffe3e3');
                }

            },

        });

        $('#buscar_columna1').on('keyup', function() {
            table.columns(1).search(this.value).draw();
        });

        $('#buscar_columna2').on('keyup', function() {
            table.columns(2).search(this.value).draw();
        });

        $('#buscar_columna3').on('keyup', function() {
            table.columns(3).search(this.value).draw();
        });

        $('#buscar_columna4').on('keyup', function() {
            table.columns(4).search(this.value).draw();
        });

        $('#buscar_columna5').on('keyup', function() {
            table.columns(5).search(this.value).draw();
        });

        $('#buscar_columna6').on('keyup', function() {
            table.columns(6).search(this.value).draw();
        });

        $('#buscar_columna7').on('keyup', function() {
            table.columns(7).search(this.value).draw();
        });

        $('#buscar_columna8').on('keyup', function() {
            table.columns(8).search(this.value).draw();
        });

        $('#buscar_columna9').on('keyup', function() {
            table.columns(9).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_bienes thead tr th').css('pointer-events', 'none');

        events();
        alerts();
    }

    function events() {

        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');

            $.ajax({
                url: "bienes/" + show_id,
                type: "GET",
                dataType: "json",
            }).done(function(data) {

                if (data.equipo !== undefined) {

                    $('#lcodbien').text(data.bien.codbien);
                    $('#ldescripcion').text(data.bien.descripcion);
                    $('#lusuario').text(data.bien.usuario);

                    // ******* ESTADO ************
                    var estado = data.bien.estado;
                    switch (estado) {
                        case 'N':
                            festado = 'NUEVO';
                            break;
                        case 'B':
                            festado = 'BUENO';
                            break;
                        case 'R':
                            festado = 'REGULAR';
                            break;
                        case 'M':
                            festado = 'MALO';
                            break;
                        case 'X':
                            festado = 'RAE';
                            break;
                        case 'Y':
                            festado = 'CHATARRA';
                            break;
                        default:
                            festado = 'NO DEFINIDO';
                            break;
                    }
                    $('#lestado').text(festado);

                    // ******* DIMENSION **********
                    var dimension = data.bien.dimension;
                    if (dimension == '' || dimension == null) {
                        $('#ldimension').text('---------------');
                    } else {
                        $('#ldimension').text(dimension);
                    }

                    // ******** FECHA ************
                    var fecha = data.bien.fec_reg;
                    var ffecha = moment(fecha).format('DD-MM-YYYY');
                    $('#lfecha').text(ffecha);

                    // ********* SITUACION DEL BIEN *********
                    var sitbien = data.bien.sit_bien;
                    if (sitbien == 'U') {
                        fsitbien = 'UBICADO';
                    } else {
                        fsitbien = 'NO UBICADO';
                    }
                    $('#lsitbien').text(fsitbien);

                    // ********* CARACTERISTICAS *********
                    var carac = data.bien.dsc_otros;
                    if (carac == '' || carac == null) {
                        $('#lcaracteristicas').text('---------------');
                    } else {
                        $('#lcaracteristicas').text(carac);
                    }

                    // ********* OBSERVACION INTERNA DEL BIEN *********
                    var obs_int = data.bien.obs_interna;
                    if (obs_int == '' || obs_int == null) {
                        $('#lobservaciones').text('---------------');
                    } else {
                        $('#lobservaciones').text(obs_int);
                    }

                    $('#lnom_equipo').text(data.equipo.nombre);
                    // ********* ESTADO DEL FOLIO *********
                    var est_folio = data.coordinacion.estado;
                    if (est_folio == '0') {
                        fest_folio = 'COORDINACIÓN';
                    } else {
                        fest_folio = 'PROCESAMIENTO';
                    }
                    $('#lest_folio').text(fest_folio);

                    $('.modal-title').text('Detalle del Registro');
                    $('#showModal').modal('show');

                } else {

                    $('#lcodbien').text(data.bien.codbien);
                    $('#ldescripcion').text(data.bien.descripcion);
                    $('#lusuario').text(data.bien.usuario);

                    // ******* ESTADO ************
                    var estado = data.bien.estado;
                    switch (estado) {
                        case 'N':
                            festado = 'NUEVO';
                            break;
                        case 'B':
                            festado = 'BUENO';
                            break;
                        case 'R':
                            festado = 'REGULAR';
                            break;
                        case 'M':
                            festado = 'MALO';
                            break;
                        case 'X':
                            festado = 'RAE';
                            break;
                        case 'Y':
                            festado = 'CHATARRA';
                            break;
                        default:
                            festado = 'NO DEFINIDO';
                            break;
                    }
                    $('#lestado').text(festado);

                    // ******* DIMENSION **********
                    var dimension = data.bien.dimension;
                    if (dimension == '' || dimension == null) {
                        $('#ldimension').text('---------------');
                    } else {
                        $('#ldimension').text(dimension);
                    }

                    // ******** FECHA ************
                    var fecha = data.bien.fec_reg;
                    var ffecha = moment(fecha).format('DD-MM-YYYY');
                    $('#lfecha').text(ffecha);

                    // ********* SITUACION DEL BIEN *********
                    var sitbien = data.bien.sit_bien;
                    if (sitbien == 'U') {
                        fsitbien = 'UBICADO';
                    } else {
                        fsitbien = 'NO UBICADO';
                    }
                    $('#lsitbien').text(fsitbien);

                    // ********* CARACTERISTICAS *********
                    var carac = data.bien.dsc_otros;
                    if (carac == '' || carac == null) {
                        $('#lcaracteristicas').text('---------------');
                    } else {
                        $('#lcaracteristicas').text(carac);
                    }

                    // ********* OBSERVACION INTERNA DEL BIEN *********
                    var obs_int = data.bien.obs_interna;
                    if (obs_int == '' || obs_int == null) {
                        $('#lobservaciones').text('---------------');
                    } else {
                        $('#lobservaciones').text(obs_int);
                    }

                    $('#lnom_equipo').text('SIN ASIGNACIÓN');
                    $('#lest_folio').text('SIN ASIGNACIÓN');
                    $('.modal-title').text('Detalle del Registro');
                    $('#showModal').modal('show');
                }

            });

        });

        // RUTA PARA LOS ENVIOS
        $('#form-cruce').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            // Accione para cruzar
            if ($('#action').val() == 'Cruzar') {
                action_url = route('bienes.update');
            }

            $.ajax({
                url: action_url,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        if (data.errors.local_db) {
                            $('#local_db-error').removeClass('d-none');
                            $('#local_db').parent().addClass(' has-error-select2');
                            $('#local_db-error').html(data.errors.local_db[0]);
                        }

                        if (data.errors.area_db) {
                            $('#area_db-error').removeClass('d-none');
                            $('#area_db').parent().addClass(' has-error-select2');
                            $('#area_db-error').html(data.errors.area_db[0]);
                        }

                        if (data.errors.oficina_db) {
                            $('#oficina_db-error').removeClass('d-none');
                            $('#oficina_db').parent().addClass(' has-error-select2');
                            $('#oficina_db-error').html(data.errors.oficina_db[0]);
                        }

                        if (data.errors.local_enc) {
                            $('#local_enc-error').removeClass('d-none');
                            $('#local_enc').parent().addClass(' has-error-select2');
                            $('#local_enc-error').html(data.errors.local_enc[0]);
                        }

                        if (data.errors.area_enc) {
                            $('#area_enc-error').removeClass('d-none');
                            $('#area_enc').parent().addClass(' has-error-select2');
                            $('#area_enc-error').html(data.errors.area_enc[0]);
                        }

                        if (data.errors.oficina_enc) {
                            $('#oficina_enc-error').removeClass('d-none');
                            $('#oficina_enc').parent().addClass(' has-error-select2');
                            $('#oficina_enc-error').html(data.errors.oficina_enc[0]);
                        }
                    }

                    if (data.success) {
                        if ($('#action').val() == 'Cruzar') {
                            toastr.success('Cruce agregado correctamente');
                            // Limpiar errores y campos
                            $('#form-cruce')[0].reset();
                            $('#local_db-error').empty();
                            $('#area_db-error').empty();
                            $('#oficina_db-error').empty();
                            $('#local_enc-error').empty();
                            $('#area_enc-error').empty();
                            $('#oficina_enc-error').empty();
                            $('#local_db-error').addClass('d-none');
                            $('#area_db-error').addClass('d-none');
                            $('#oficina_db-error').addClass('d-none');
                            $('#local_enc-error').addClass('d-none');
                            $('#area_enc-error').addClass('d-none');
                            $('#oficina_enc-error').addClass('d-none');
                            $('#local_db').parent().removeClass(' has-error-select2');
                            $('#area_db').parent().removeClass(' has-error-select2');
                            $('#oficina_db').parent().removeClass(' has-error-select2');
                            $('#local_enc').parent().removeClass(' has-error-select2');
                            $('#area_enc').parent().removeClass(' has-error-select2');
                            $('#oficina_enc').parent().removeClass(' has-error-select2');
                            $('#local_db').val('').trigger('change');
                            $('#area_db').val('').trigger('change');
                            $('#oficina_db').val('').trigger('change');
                            $('#local_enc').val('').trigger('change');
                            $('#area_enc').val('').trigger('change');
                            $('#oficina_enc').val('').trigger('change');
                            $('#modalCruce').modal('hide');
                        }
                    }

                    if (data.warning) {
                        toastr.warning('No se guardo cruce, usted no pertenece a ningun equipo.');
                        $('#modalCruce').modal('hide');
                    }

                }
            });
        });


        // ************* CRUCE DE BIENES ***********************
        $(document).on('click', '.location', function() {
            var id = $(this).attr('id');

            $('#local_db-error').empty();
            $('#area_db-error').empty();
            $('#oficina_db-error').empty();
            $('#local_enc-error').empty();
            $('#area_enc-error').empty();
            $('#oficina_enc-error').empty();
            $('#local_db-error').addClass('d-none');
            $('#area_db-error').addClass('d-none');
            $('#oficina_db-error').addClass('d-none');
            $('#local_enc-error').addClass('d-none');
            $('#area_enc-error').addClass('d-none');
            $('#oficina_enc-error').addClass('d-none');
            $('#local_db').parent().removeClass(' has-error-select2');
            $('#area_db').parent().removeClass(' has-error-select2');
            $('#oficina_db').parent().removeClass(' has-error-select2');
            $('#local_enc').parent().removeClass(' has-error-select2');
            $('#area_enc').parent().removeClass(' has-error-select2');
            $('#oficina_enc').parent().removeClass(' has-error-select2');
            $('#local_db').val('').trigger('change');
            $('#area_db').val('').trigger('change');
            $('#oficina_db').val('').trigger('change');
            $('#local_enc').val('').trigger('change');
            $('#area_enc').val('').trigger('change');
            $('#oficina_enc').val('').trigger('change');

            $.ajax({
                url: '/bienes/' + id + '/edit',
                dataType: 'json',
            }).done(function(data) {

                $('#bien').text(data.bien.codbien + ' - ' + data.bien.descripcion);
                $('#action').val('Cruzar');
                $('#bien_id').val(id);
                $('.modal-title').text('Cruce de Bienes');
                $('#modalCruce').modal('show');
            });
        });


        // ***********************************************************************
        // *************************** BIENES - BASE DE DATOS ********************
        // ***********************************************************************

        // ************* SELECT ANINADO PARA LOCAL - AREA **********************
        $('#local_db').on('change', function() {
            var locales_id = $(this).val();
            $.ajax({
                url: route('cruce_areas.data') + '?localID=' + locales_id,
                type: "GET",
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $('#area_db').select2({
                        width: '100%',
                        placeholder: 'CARGANDO AREAS...'
                    });
                },
                success: function(area) {
                    var old = $('#area_db').data('old') != '' ? $('#area_db').data('old') : '';
                    $('#area_db').empty();
                    $('#oficina_db').empty();
                    $('#area_db').select2({
                        width: '100%',
                        placeholder: "SELECCIONAR...",
                        allowClear: true,
                        language: "es",
                    }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
                    $.each(area, function(index, data) {
                        $('#area_db').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.codarea + ' - ' + data.descripcion) + "</option>";
                    });
                }
            });
        });

        // ************* SELECT ANINADO PARA AREA - OFICINA - DB**********************
        $('#area_db').on('change', function() {
            var areas_id = $(this).val();
            $.ajax({
                url: route('cruce_oficinas.data') + '?areaID=' + areas_id,
                type: "GET",
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $('#oficina_db').select2({
                        width: '100%',
                        placeholder: 'CARGANDO OFICINAS...'
                    });
                },
                success: function(oficina) {
                    var old = $('#oficina_db').data('old') != '' ? $('#oficina_db').data('old') : '';
                    $('#oficina_db').empty();
                    $('#oficina_db').select2({
                        width: '100%',
                        placeholder: "SELECCIONAR...",
                        allowClear: true,
                        language: "es",
                    }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
                    $.each(oficina, function(index, data) {
                        $('#oficina_db').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.codoficina + ' - ' + data.descripcion) + "</option>";
                    });
                }
            });
        });

        // ***********************************************************************
        // *************************** BIENES - FISICO ***************************
        // ***********************************************************************

        // ************* SELECT ANINADO PARA LOCAL - AREA **********************
        $('#local_enc').on('change', function() {
            var locales_id = $(this).val();
            $.ajax({
                url: route('cruce_areas.data') + '?localID=' + locales_id,
                type: "GET",
                dataType: "json",
                // cache: false,
                beforeSend: function() {
                    $('#area_enc').select2({
                        width: '100%',
                        placeholder: 'CARGANDO AREAS...'
                    });
                },
                success: function(area) {
                    var old = $('#area_enc').data('old') != '' ? $('#area_enc').data('old') : '';
                    $('#area_enc').empty();
                    $('#oficina_enc').empty();
                    $('#area_enc').select2({
                        width: '100%',
                        placeholder: "SELECCIONAR...",
                        allowClear: true,
                        language: "es",
                    }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
                    $.each(area, function(index, data) {
                        $('#area_enc').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.codarea + ' - ' + data.descripcion) + "</option>";
                    });
                }
            });
        });

        // ************* SELECT ANINADO PARA AREA - OFICINA **********************
        $('#area_enc').on('change', function() {
            var areas_id = $(this).val();
            $.ajax({
                url: route('cruce_oficinas.data') + '?areaID=' + areas_id,
                type: "GET",
                dataType: "json",
                // cache: false,
                beforeSend: function() {
                    $('#oficina_enc').select2({
                        width: '100%',
                        placeholder: 'CARGANDO OFICINAS...'
                    });
                },
                success: function(oficina) {
                    var old = $('#oficina_enc').data('old') != '' ? $('#oficina_enc').data('old') : '';
                    $('#oficina_enc').empty();
                    $('#oficina_enc').select2({
                        width: '100%',
                        placeholder: "SELECCIONAR...",
                        allowClear: true,
                        language: "es",
                    }).append('<option value="" disabled selected hidden>SELECCIONAR...</option>');
                    $.each(oficina, function(index, data) {
                        $('#oficina_enc').append("<option value=' " + data.id + " ' " + (old == data.id ? 'selected' : '') + ">" + data.codoficina + ' - ' + data.descripcion) + "</option>";
                    });
                }
            });
        });


        // ****************** BORRRAR FILTROS **********************
        $('#btn-filtro').on('click', function() {
            $('#buscar_columna1').val('').keyup();
            $('#buscar_columna2').val('').keyup();
            $('#buscar_columna3').val('').keyup();
            $('#buscar_columna4').val('').keyup();
            $('#buscar_columna5').val('').keyup();
            $('#buscar_columna6').val('').keyup();
            $('#buscar_columna7').val('').keyup();
            $('#buscar_columna8').val('').keyup();
            $('#buscar_columna9').val('').keyup();
        });


        // ************* SELECT2 *****************
        $('#local_db').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
        });

        $('#area_db').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
        });

        $('#oficina_db').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
        });

        $('#local_enc').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
        });

        $('#area_enc').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
        });

        $('#oficina_enc').select2({
            width: '100%',
            placeholder: "SELECCIONAR",
            allowClear: true,
            language: "es",
        });
    }

    function alerts() {

        // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************

        $('#local_db').on('change', function() {
            if ($('#local_db-error').text() != '') {
                if ($(this).val() == '') {
                    $('#local_db-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                    // Agregar errores a los select dinamicos
                    $('#area_db-error').removeClass('d-none');
                    $('#area_db').parent().addClass(' has-error-select2');
                    $('#oficina_db-error').removeClass('d-none');
                    $('#oficina_db').parent().addClass(' has-error-select2');
                } else {
                    $('#local_db-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#area_db').on('change', function() {
            if ($('#area_db-error').text() != '') {
                if ($(this).val() == '' || $(this).val() == null) {
                    $('#area_db-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                    // Agregar errores a los select dinamicos
                    $('#oficina_db-error').removeClass('d-none');
                    $('#oficina_db').parent().addClass(' has-error-select2');
                } else {
                    $('#area_db-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#oficina_db').on('change', function() {
            if ($('#oficina_db-error').text() != '') {
                if ($(this).val() == '' || $(this).val() == null) {
                    $('#oficina_db-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#oficina_db-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#local_enc').on('change', function() {
            if ($('#local_enc-error').text() != '') {
                if ($(this).val() == '') {
                    $('#local_enc-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                    // Agregar errores a los select dinamicos
                    $('#area_enc-error').removeClass('d-none');
                    $('#area_enc').parent().addClass(' has-error-select2');
                    $('#oficina_enc-error').removeClass('d-none');
                    $('#oficina_enc').parent().addClass(' has-error-select2');
                } else {
                    $('#local_enc-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#area_enc').on('change', function() {
            if ($('#area_enc-error').text() != '') {
                if ($(this).val() == '' || $(this).val() == null) {
                    $('#area_enc-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                    // Agregar errores a los select dinamicos
                    $('#oficina_enc-error').removeClass('d-none');
                    $('#oficina_enc').parent().addClass(' has-error-select2');
                } else {
                    $('#area_enc-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#oficina_enc').on('change', function() {
            if ($('#oficina_enc-error').text() != '') {
                if ($(this).val() == '' || $(this).val() == null) {
                    $('#oficina_enc-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#oficina_enc-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });
    }

    init();

});
