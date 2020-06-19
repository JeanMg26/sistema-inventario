$(document).ready(function() {

    function init() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#tabla_oficinas').DataTable({
            // ordering: false,
            serverSide: true,
            pageLength: 15,
            order: [
                [1, 'asc']
            ],
            processing: true,
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
                        extend: 'excelHtml5',
                        title: 'OFICINAS DE LA INSTITUCIÓN',
                        text: '<i class="fal fa-file-excel mr-1"></i>Excel',
                        className: 'btn btn-success btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                    },

                    {
                        extend: 'pdf',
                        title: 'OFICINAS DE LA INSTITUCIÓN',
                        orientation: 'landscape',
                        text: '<i class="fal fa-file-pdf mr-1"></i>PDF',
                        className: 'btn btn-danger btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
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

                            doc.defaultStyle.fontSize = '8';
                            doc.styles.tableHeader = { fillColor: '#e46a76', color: 'white', alignment: 'center' },
                                // doc.defaultStyle.alignment = 'center';
                                doc.content[1].table.widths = ['5%', '7%', '20%', '7%', '24%', '8%', '29%'];

                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fal fa-print mr-1"></i>Imprimir',
                        title: 'OFICINAS DE LA INSTITUCIÓN',
                        className: 'btn btn-info btn-sm',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        customize: function(win) {

                            var last = null;
                            var current = null;
                            var bod = [];

                            var css = '@page { size: landscape; }',
                                head = win.document.head || win.document.getElementsByTagName('head')[0],
                                style = win.document.createElement('style');

                            style.type = 'text/css';
                            style.media = 'print';

                            if (style.styleSheet) {
                                style.styleSheet.cssText = css;
                            } else {
                                style.appendChild(win.document.createTextNode(css));
                            }

                            head.appendChild(style);
                            $(win.document.body).find('table').css('text-align', 'center');
                            $(win.document.body).find('h1').css('text-align', 'center');
                        }
                    },
                ],


            },
            ajax: {
                url: route('oficinas.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'localC',
                    name: 'locales.codlocal',
                    visible: false
                },
                {
                    data: 'localD',
                    name: 'locales.descripcion'
                },
                {
                    data: 'areaC',
                    name: 'areas.codarea'
                },
                {
                    data: 'areaD',
                    name: 'areas.descripcion'
                },
                {
                    data: 'oficinaC',
                    name: 'oficinas.codoficina'
                },
                {
                    data: 'oficinaD',
                    name: 'oficinas.descripcion'
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

        // BUSQUEDA INDIVIDUAL POR COLUMNA
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

        $('#buscar_select2').change(function() {
            table.columns(2).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_oficinas thead tr th').css('pointer-events', 'none');

        // ***************************************************************************
        // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

        table.on('click', '.toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var toggle_id = $(this).find('.toggle-class').attr('id');
            var oficina_id = $(this).find('.toggle-class').data('id');

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
                            url: route('cambiar.estadoficina'),
                            data: { 'estado': estado, 'oficina_id': oficina_id },
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
                            url: route('cambiar.estadoficina'),
                            data: { 'estado': estado, 'oficina_id': oficina_id },
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
        alerts();
    }

    function events() {



        // LLAMANDO A MODAL PARA AGREGAR REGISTRO
        $('#crear_registro').on('click', function() {
            $('.modal-title').text('Nueva Oficina');
            $('.action_button').text('Guardar');
            $('.action_button').prepend('<i class="fas fa-save mr-2">');
            $('.action_button').removeClass('btn-info');
            $('.action_button').addClass('btn-danger');
            $('#action').val('Agregar');

            $('#local-error').empty();
            $('#area-error').empty();
            $('#cod_oficina-error').empty();
            $('#des_oficina-error').empty();
            $('#est_oficina-error').empty();
            $('#local-error').addClass('d-none');
            $('#area-error').addClass('d-none');
            $('#cod_oficina-error').addClass('d-none');
            $('#des_oficina-error').addClass('d-none');
            $('#est_oficina-error').addClass('d-none');
            $('#cod_oficina').removeClass('is-invalid');
            $('#des_oficina').removeClass('is-invalid');
            $('#local').parent().removeClass(' has-error-select2');
            $('#area').parent().removeClass(' has-error-select2');
            $('#est_oficina').parent().removeClass(' has-error-select2');
            $('#cod_oficina').val('');
            $('#des_oficina').val('');
            $('#local').val('').trigger('change');
            $('#area').val('').trigger("change");
            $('#est_oficina').val('1').trigger("change");

            $('#est_oficina option:eq(2)').prop('disabled', true);
            $('#modalOficina').modal('show');
        });

        // RUTA PARA LOS ENVIOS
        $('#form-oficina').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            // Accione para agregar
            if ($('#action').val() == 'Agregar') {
                action_url = route('oficinas.store');

            }

            // Accione para editar
            if ($('#action').val() == 'Editar') {
                action_url = route('oficinas.update');
            }

            $.ajax({
                url: action_url,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        if (data.errors.local) {
                            $('#local-error').removeClass('d-none');
                            $('#local').parent().addClass(' has-error-select2');
                            $('#local-error').html(data.errors.local[0]);

                        }

                        if (data.errors.area) {
                            $('#area-error').removeClass('d-none');
                            $('#area').parent().addClass(' has-error-select2');
                            $('#area-error').html(data.errors.area[0]);
                        }

                        if (data.errors.cod_oficina) {
                            $('#cod_oficina-error').removeClass('d-none');
                            $('#cod_oficina').addClass('is-invalid');
                            $('#cod_oficina-error').html(data.errors.cod_oficina[0]);
                        }

                        if (data.errors.des_oficina) {
                            $('#des_oficina-error').removeClass('d-none');
                            $('#des_oficina').addClass('is-invalid');
                            $('#des_oficina-error').html(data.errors.des_oficina[0]);
                        }
                        if (data.errors.est_oficina) {
                            $('#est_oficina-error').removeClass('d-none');
                            $('#est_oficina').parent().addClass(' has-error-select2');
                            $('#est_oficina-error').html(data.errors.est_oficina[0]);
                        }
                    }

                    if (data.success) {
                        if ($('#action').val() == 'Editar') {
                            toastr['info']('Registro actualizado correctamente');
                            // Validaciones para blanquear formulario
                            $('#form-oficina')[0].reset();
                            $('#local-error').empty();
                            $('#area-error').empty();
                            $('#cod_oficina-error').empty();
                            $('#des_oficina-error').empty();
                            $('#est_oficina-error').empty();
                            $('#local-error').addClass('d-none');
                            $('#area-error').addClass('d-none');
                            $('#cod_oficina-error').addClass('d-none');
                            $('#des_oficina-error').addClass('d-none');
                            $('#est_oficina-error').addClass('d-none');
                            $('#cod_oficina').removeClass('is-invalid');
                            $('#des_oficina').removeClass('is-invalid');
                            $('#local').parent().removeClass(' has-error-select2');
                            $('#area').parent().removeClass(' has-error-select2');
                            $('#est_oficina').parent().removeClass(' has-error-select2');
                            $('#cod_oficina').val('');
                            $('#des_oficina').val('');
                            $('#local').val('').trigger('change');
                            $('#area').val('').trigger("change");
                            $('#est_oficina').val('1').trigger("change");
                            $('#tabla_oficinas').DataTable().ajax.reload();
                            $('#modalOficina').modal('hide');
                        } else {
                            toastr['success']('Registro agregado correctamente');
                            // Validaciones para blanquear formulario
                            $('#form-oficina')[0].reset();
                            $('#local-error').empty();
                            $('#area-error').empty();
                            $('#cod_oficina-error').empty();
                            $('#des_oficina-error').empty();
                            $('#est_oficina-error').empty();
                            $('#local-error').addClass('d-none');
                            $('#area-error').addClass('d-none');
                            $('#cod_oficina-error').addClass('d-none');
                            $('#des_oficina-error').addClass('d-none');
                            $('#est_oficina-error').addClass('d-none');
                            $('#cod_oficina').removeClass('is-invalid');
                            $('#des_oficina').removeClass('is-invalid');
                            $('#local').parent().removeClass(' has-error-select2');
                            $('#area').parent().removeClass(' has-error-select2');
                            $('#est_oficina').parent().removeClass(' has-error-select2');
                            $('#cod_oficina').val('');
                            $('#des_oficina').val('');
                            $('#local').val('').trigger('change');
                            $('#area').val('').trigger("change");
                            $('#est_oficina').val('1').trigger("change");
                            $('#tabla_oficinas').DataTable().ajax.reload();
                            $('#local').select2('focus');
                        }
                    }

                }
            });
        });


        

        // *************  EDITAR MODAL DESDE AJAX *************
        $(document).on('click', '.edit', function() {

            var id = $(this).attr('id');
            $('#local-error').empty();
            $('#area-error').empty();
            $('#cod_oficina-error').empty();
            $('#des_oficina-error').empty();
            $('#est_oficina-error').empty();
            $('#local-error').addClass('d-none');
            $('#area-error').addClass('d-none');
            $('#cod_oficina-error').addClass('d-none');
            $('#des_oficina-error').addClass('d-none');
            $('#est_oficina-error').addClass('d-none');
            $('#cod_oficina').removeClass('is-invalid');
            $('#des_oficina').removeClass('is-invalid');
            $('#local').parent().removeClass(' has-error-select2');
            $('#area').parent().removeClass(' has-error-select2');
            $('#est_oficina').parent().removeClass(' has-error-select2');
            $('#est_oficina option:eq(2)').prop('disabled', false);

            $.ajax({
                url: '/oficinas/' + id + '/edit',
                dataType: 'json',
            }).done(function(data) {
                $('#cod_oficina').val(data.oficina.codoficina);
                $('#des_oficina').val(data.oficina.descripcion);
                $('#local').val(data.oficina.locales_id).trigger('change');
                $('#area').val(data.oficina.areas_id);
                $('#area').data('old', data.oficina.areas_id);
                $('#est_oficina').val(data.oficina.estado).trigger('change');
                $('#oficina_id').val(id);
                $('.modal-title').text('Actualizar Oficina');
                $('.action_button').text('Actualizar');
                $('.action_button').prepend('<i class="far fa-sync-alt mr-2"></i>');
                $('.action_button').removeClass('btn-danger');
                $('.action_button').addClass('btn-info');
                $('#action').val('Editar');
                $('#modalOficina').modal('show');
            });
        });


        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');

            $.ajax({
                url: "oficinas/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#lcod_local').text(data.local.codlocal);
                    $('#ldes_local').text(data.local.descripcion);
                    $('#lcod_area').text(data.area.codarea);
                    $('#ldes_area').text(data.area.descripcion);
                    $('#lcod_oficina').text(data.oficina.codoficina);
                    $('#ldes_oficina').text(data.oficina.descripcion);
                    if (data.oficina.estado == '1') {
                        $('#lest_oficina').text('ACTIVO');
                    } else {
                        $('#lest_oficina').text('INACTIVO');
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
                url: '/oficinas/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_oficinas').DataTable().ajax.reload();
                    }, 400);
                }

            })
        });


        // ************* SELECT ANINADO PARA LOCAL - AREA **********************
        $('#local').on('change', function() {
            var locales_id = $(this).val();
            $.ajax({
                url: route('sareas.data') + '?local_id=' + locales_id,
                type: "GET",
                dataType: "json",
                // cache: false,
                beforeSend: function() {
                    $('#area').select2({
                        placeholder: 'CARGANDO AREAS...',
                        width: '100%',
                        allowClear: true,
                        language: "es",
                    });
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
                }
            });
        });


        // ****************** BORRRAR FILTROS **********************
        $('#btn-filtro').on('click', function() {
            $('#buscar_select2').val('').trigger('change');
            $('#buscar_columna3').val('').keyup();
            $('#buscar_columna4').val('').keyup();
            $('#buscar_columna5').val('').keyup();
            $('#buscar_columna6').val('').keyup();
        });


        // ******** SELECT2 ***********
        $('#local').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });

        $('#area').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });

        $('#est_oficina').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
        });


        $('#buscar_select2').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
            dropdownParent: $('#parent')
        });

        // AUTOFOCUS PARA SELECT2 MODAL
        $('#modalOficina').on('shown.bs.modal', function() {
            $('#local').select2('focus');
        });

    }


    function alerts(){

      // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************
        $('#local').on('change', function() {
            if ($('#local-error').text() != '') {
                if ($(this).val() == '') {
                    $('#local-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                    // Agregar errores a los select dinamicos
                    $('#area-error').removeClass('d-none');
                    $('#area').parent().addClass(' has-error-select2');
                } else {
                    $('#local-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#area').on('change', function() {
            if ($('#area-error').text() != '') {
                if ($(this).val() == '' || $(this).val() == null) {
                    $('#area-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#area-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#cod_oficina').on('keyup', function() {
            if ($('#cod_oficina-error').text() != '') {
                if ($(this).val().length) {
                    $('#cod_oficina-error').addClass('d-none');
                    $('#cod_oficina').removeClass('is-invalid');
                } else {
                    $('#cod_oficina-error').removeClass('d-none');
                    $('#cod_oficina').addClass('is-invalid');
                }
            }
        });

        $('#des_oficina').on('keyup', function() {
            if ($('#des_oficina-error').text() != '') {
                if ($(this).val().length) {
                    $('#des_oficina-error').addClass('d-none');
                    $('#des_oficina').removeClass('is-invalid');
                } else {
                    $('#des_oficina-error').removeClass('d-none');
                    $('#des_oficina').addClass('is-invalid');
                }
            }
        });

        $('#est_oficina').on('change', function() {
            if ($('#est_oficina-error').text() != '') {
                if ($(this).val() == '') {
                    $('#est_oficina-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#est_oficina-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });


    }





    init();

});
