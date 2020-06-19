$(document).ready(function() {


    function init() {

        var table = $('#tabla_areas').DataTable({
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
                        title: 'ÁREAS DE LA INSTITUCIÓN',
                        text: '<i class="fal fa-file-excel mr-1"></i>Excel',
                        className: 'btn btn-success btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                    },

                    {
                        extend: 'pdf',
                        title: 'ÁREAS DE LA INSTITUCIÓN',
                        text: '<i class="fal fa-file-pdf mr-1"></i>PDF',
                        className: 'btn btn-danger btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
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
                                doc.content[1].table.widths = ['5%', '10%', '35%', '15%', '35%'];

                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fal fa-print mr-1"></i>Imprimir',
                        title: 'ÁREAS DE LA INSTITUCIÓN',
                        className: 'btn btn-info btn-sm',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        customize: function(win) {
                            $(win.document.body).find('table').css('text-align', 'center');
                            $(win.document.body).find('h1').css('text-align', 'center');
                        }
                    },
                ],


            },
            ajax: {
                url: route('areas.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'local_codlocal',
                    name: 'locales.codlocal',
                },
                {
                    data: 'local_des',
                    name: 'locales.descripcion'
                },
                {
                    data: 'area_codarea',
                    name: 'areas.codarea'
                },
                {
                    data: 'areaD',
                    name: 'areas.descripcion'
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

        $('#buscar_select1').change(function() {
            table.columns(1).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_areas thead tr th').css('pointer-events', 'none');


        // ***************************************************************************
        // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

        table.on('click', '.toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var toggle_id = $(this).find('.toggle-class').attr('id');
            var area_id = $(this).find('.toggle-class').data('id');

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
                            url: route('cambiar.estadoarea'),
                            data: { 'estado': estado, 'area_id': area_id },
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
                            url: route('cambiar.estadoarea'),
                            data: { 'estado': estado, 'area_id': area_id },
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
            $('.modal-title').text('Nueva Área');
            $('.action_button').text('Guardar');
            $('.action_button').prepend('<i class="fas fa-save mr-2">');
            $('.action_button').removeClass('btn-info');
            $('.action_button').addClass('btn-danger');
            $('#action').val('Agregar');

            $('#cod_area-error').empty();
            $('#des_area-error').empty();
            $('#est_area-error').empty();
            $('#local-error').empty();
            $('#cod_area-error').addClass('d-none');
            $('#des_area-error').addClass('d-none');
            $('#est_area-error').addClass('d-none');
            $('#local-error').addClass('d-none');
            $('#cod_area').removeClass('is-invalid');
            $('#des_area').removeClass('is-invalid');
            $('#local').parent().removeClass(' has-error-select2');
            $('#est_area').parent().removeClass(' has-error-select2');
            $('#cod_area').val('');
            $('#des_area').val('');
            $('#local').val('').trigger('change');
            $('#est_area').val("1").trigger("change");

            $('#est_area option:eq(2)').prop('disabled', true);
            $('#modalArea').modal('show');
        });

        // VERIFICAR SI EXISTE ERRORES
        $('#form-area').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';

            // Accione para agregar
            if ($('#action').val() == 'Agregar') {
                action_url = route('areas.store');

            }

            // Accione para editar
            if ($('#action').val() == 'Editar') {
                action_url = route('areas.update');
            }

            $.ajax({
                url: action_url,
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {

                    if (data.errors) {

                        if (data.errors.cod_area) {
                            $('#cod_area-error').removeClass('d-none');
                            $('#cod_area').addClass('is-invalid');
                            $('#cod_area-error').html(data.errors.cod_area[0]);

                        }

                        if (data.errors.des_area) {
                            $('#des_area-error').removeClass('d-none');
                            $('#des_area').addClass('is-invalid');
                            $('#des_area-error').html(data.errors.des_area[0]);
                        }

                        if (data.errors.est_area) {
                            $('#est_area-error').removeClass('d-none');
                            $('#est_area').parent().addClass(' has-error-select2');
                            $('#est_area-error').html(data.errors.est_area[0]);
                        }

                        if (data.errors.local) {
                            $('#local-error').removeClass('d-none');
                            $('#local').parent().addClass(' has-error-select2');
                            $('#local-error').html(data.errors.local[0]);
                        }
                    }

                    if (data.success) {
                        if ($('#action').val() == 'Editar') {
                            toastr['info']('Registro actualizado correctamente');
                            // Limpiar errores y campos
                            $('#form-area')[0].reset();
                            ('#cod_area-error').empty();
                            $('#des_area-error').empty();
                            $('#est_area-error').empty();
                            $('#local-error').empty();
                            $('#cod_area-error').addClass('d-none');
                            $('#des_area-error').addClass('d-none');
                            $('#est_area-error').addClass('d-none');
                            $('#local-error').addClass('d-none');
                            $('#cod_area').removeClass('is-invalid');
                            $('#des_area').removeClass('is-invalid');
                            $('#est_area').parent().removeClass(' has-error-select2');
                            $('#local').val('').trigger('change');
                            $('#est_area').val("1").trigger("change");
                            $('#tabla_areas').DataTable().ajax.reload();
                            $('#modalArea').modal('hide');
                        } else {
                            toastr['success']('Registro agregado correctamente');
                            // Limpiar errores
                            $('#form-area')[0].reset();
                            $('#local').val('').trigger('change');
                            ('#cod_area-error').empty();
                            $('#des_area-error').empty();
                            $('#est_area-error').empty();
                            $('#local-error').empty();
                            $('#cod_area-error').addClass('d-none');
                            $('#des_area-error').addClass('d-none');
                            $('#est_area-error').addClass('d-none');
                            $('#local-error').addClass('d-none');
                            $('#cod_area').removeClass('is-invalid');
                            $('#des_area').removeClass('is-invalid');
                            $('#est_area').parent().removeClass(' has-error-select2');
                            $('#local').val('').trigger('change');
                            $('#est_area').val("1").trigger("change");
                            $('#tabla_areas').DataTable().ajax.reload();
                            $('#local').select2('focus');
                        }
                    }
                }
            })
        });

        // *************  EDITAR MODAL DESDE AJAX *************
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $('#cod_area-error').empty();
            $('#des_area-error').empty();
            $('#est_area-error').empty();
            $('#local-error').empty();
            $('#cod_area-error').addClass('d-none');
            $('#des_area-error').addClass('d-none');
            $('#est_area-error').addClass('d-none');
            $('#local-error').addClass('d-none');
            $('#cod_area').removeClass('is-invalid');
            $('#des_area').removeClass('is-invalid');
            $('#local').parent().removeClass(' has-error-select2');
            $('#est_area').parent().removeClass(' has-error-select2');
            $('#est_area option:eq(2)').prop('disabled', false);

            $.ajax({
                url: '/areas/' + id + '/edit',
                dataType: 'json',
                success: function(data) {
                    $('#cod_area').val(data.area.codarea);
                    $('#des_area').val(data.area.descripcion);
                    $('#local').val(data.area.locales_id).trigger('change');
                    $('#est_area').val(data.area.estado).trigger('change');

                    $('#area_id').val(id);
                    $('.modal-title').text('Actualiza Área');
                    $('.action_button').text('Actualizar');
                    $('.action_button').prepend('<i class="far fa-sync-alt mr-2"></i>');
                    $('.action_button').removeClass('btn-danger');
                    $('.action_button').addClass('btn-info');
                    $('#action').val('Editar');
                    $('#modalArea').modal('show');
                }
            });
        });


        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');

            $.ajax({
                url: "areas/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    $('#lcod_local').text(data.local.codlocal);
                    $('#ldes_local').text(data.local.descripcion);
                    $('#lcod_area').text(data.area.codarea);
                    $('#ldes_area').text(data.area.descripcion);
                    if (data.area.estado == '1') {
                        $('#lest_area').text('ACTIVO');
                    } else {
                        $('#lest_area').text('INACTIVO');
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
                url: '/areas/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_areas').DataTable().ajax.reload();
                    }, 400);
                }

            });
        });


        // ****************** BORRRAR FILTROS **********************
        $('#btn-filtro').on('click', function() {
            $('#buscar_select2').val('').trigger('change');
            $('#buscar_columna3').val('').keyup();
            $('#buscar_columna4').val('').keyup();
        });


        $('#local').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
        });

        $('#est_area').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            minimumResultsForSearch: -1,
            language: "es",
        });

        $('#buscar_select1').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
            dropdownParent: $('#parent')
        });

        // AUTOFOCUS PARA SELECT2 MODAL
        $('#modalArea').on('shown.bs.modal', function() {
            $('#local').select2('focus');
        });

    }


    function alerts() {
        // *************** ELIMINAR ALERTAS AL INGRESAR DATOS ********************

        $('#cod_area').on('keyup', function() {
            if ($('#cod_area-error').text() != '') {
                if ($(this).val().length) {
                    $('#cod_area-error').addClass('d-none');
                    $('#cod_area').removeClass('is-invalid');
                } else {
                    $('#cod_area-error').removeClass('d-none');
                    $('#cod_area').addClass('is-invalid');
                }
            }
        });

        $('#des_area').on('keyup', function() {
            if ($('#des_area-error').text() != '') {
                if ($(this).val().length) {
                    $('#des_area-error').addClass('d-none');
                    $('#des_area').removeClass('is-invalid');
                } else {
                    $('#des_area-error').removeClass('d-none');
                    $('#des_area').addClass('is-invalid');
                }
            }
        });

        $('#local').on('change', function() {
            if ($('#local-error').text() != '') {
                if ($(this).val() == '') {
                    $('#local-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#local-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

        $('#est_area').on('change', function() {
            if ($('#est_area-error').text() != '') {
                if ($(this).val() == '') {
                    $('#est_area-error').removeClass('d-none');
                    $(this).parent().addClass(' has-error-select2');
                } else {
                    $('#est_area-error').addClass('d-none');
                    $(this).parent().removeClass(' has-error-select2');
                }
            }
        });

    }

    init();

});
