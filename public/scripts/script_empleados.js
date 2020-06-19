$(document).ready(function() {


    function init() {

        var table = $('#tabla_empleados').DataTable({
            // ordering: false,
            serverSide: true,
            pageLength: 15,
            processing: true,
            order: [
                [6, 'asc']
            ],
            dom: 'rB<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            buttons: {
                dom: {
                    container: {
                        tag: 'div',
                        className: 'flexcontent d-flex justify-content-center justify-content-md-start',
                    },
                    buttonLiner: {
                        tag: null
                    }
                },
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'PERSONAL DE INVENTARIO',
                        text: '<i class="fal fa-file-excel mr-1"></i>Excel',
                        className: 'btn btn-success btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        },
                    },

                    {
                        extend: 'pdf',
                        title: 'PERSONAL DE INVENTARIO',
                        orientation: 'landscape',
                        text: '<i class="fal fa-file-pdf mr-1"></i>PDF',
                        className: 'btn btn-danger btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        },
                        customize: function(doc) {
                            // Agregar border a tablas
                            var objLayout = {};
                            objLayout['hLineWidth'] = function(i) { return .8; };
                            objLayout['vLineWidth'] = function(i) { return .5; };
                            objLayout['hLineColor'] = function(i) { return '#aaa'; };
                            objLayout['vLineColor'] = function(i) { return '#aaa'; };
                            objLayout['paddingLeft'] = function(i) { return 4; };
                            objLayout['paddingRight'] = function(i) { return 4; };
                            doc.content[1].layout = objLayout;

                            doc.defaultStyle.fontSize = '7';
                            doc.styles.tableHeader = { fillColor: '#e46a76', color: 'white', alignment: 'center' },
                                // doc.defaultStyle.alignment = 'center';
                                doc.content[1].table.widths = ['2%', '8%', '7%', '14%', '9%', '7%', '7%', '17%', '15%', '7%', '6%'];

                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fal fa-print mr-1"></i>Imprimir',
                        title: 'OFICINAS DE LA INSTITUCIÓN',
                        className: 'btn btn-info btn-sm',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', '8px');

                            $(win.document.body).find('table').css('text-align', 'center');
                            $(win.document.body).find('h1').css('text-align', 'center');
                        }
                    },
                ],


            },
            ajax: {
                url: route('empleados.data'),
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
                    data: 'tipodoc',
                    name: 'tipodoc',
                    visible: false
                },
                {
                    data: 'nrodoc',
                    name: 'nrodoc',
                    visible: false
                },
                {
                    data: 'completos',
                    name: 'completos'
                },

                {
                    data: 'rol_name',
                    name: 'roles.name',
                    render: function(data, type, row) {
                        return '<label class="badge badge-success">' + row.rol_name + '</label>';
                    }
                },
                {
                    data: 'nom_equi',
                    name: 'equipos.nombre'
                },
                {
                    data: 'celular',
                    name: 'celular'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'profesion',
                    name: 'profesiones.nombre',
                    visible: false
                },
                {
                    data: 'genero',
                    name: 'genero',
                    render: function(data, type, row) {
                        if (row.genero == 'M') {
                            return 'MASCULINO';
                        } else {
                            return 'FEMENINO';
                        }
                    },
                    visible: false
                },
                {
                    data: 'estado',
                    name: 'estado',
                    render: function(data, type, row) {
                        if (row.estado == '1') {
                            return 'ACTIVO';
                        } else {
                            return 'INACTIVO';
                        }
                    },
                    visible: false
                },
                {
                    data: 'create_at',
                    name: 'empleados.created_at',
                    visible: false,
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
            columnDefs: [{
                targets: [12],
                render: function(data) {
                    return moment(data).format('YYYY');
                }
            }],
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

        $('#year').change(function() {
            table.columns(12).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_empleados thead tr th').css('pointer-events', 'none');

        // ***************************************************************************
        // ********************* ACTUALIZAR ESTADO CON SWEETALERT ********************

        table.on('click', '.toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var toggle_id = $(this).find('.toggle-class').attr('id');
            var empleado_id = $(this).find('.toggle-class').data('id');

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
                            url: route('cambiar.estadoempleado'),
                            data: { 'estado': estado, 'empleado_id': empleado_id },
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
                            url: route('cambiar.estadoempleado'),
                            data: { 'estado': estado, 'empleado_id': empleado_id },
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
                url: '/empleados/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_empleados').DataTable().ajax.reload();
                    }, 400);
                }
            })
        });

        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');

            $.ajax({
                url: "empleados/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#lcomp_emp').text(data.empleado.completos);
                    $('#lemail_emp').text(data.empleado.email);
                    if (data.empleado.genero == 'M') {
                        $('#lgen_emp').text('MASCULINO');
                    } else {
                        $('#lgen_emp').text('FEMENINO');
                    }
                    var fec_nac = data.empleado.fec_nac;
                    var ffec_nac = moment(fec_nac).format('DD-MM-YYYY');
                    $('#lfec_nac').text(ffec_nac);

                    $('#ltipodoc_emp').text(data.empleado.tipodoc);
                    $('#lnrodoc_emp').text(data.empleado.nrodoc);
                    $('#lcargo_emp').text(data.usuarioRol.name);
                    $('#lequipo_emp').text(data.equipo.nombre);
                    $('#lprof_emp').text(data.profesion.nombre);
                    $('#lnom_usu').text(data.nom_usuario);
                    $('#lpass_usu').text(data.clave);
                    // MOSTRAR NUMERO DE CELULAR
                    if (data.empleado.celular == '' || data.empleado.celular == null) {
                        $('#lcelu_emp').text('--------------');
                    } else {
                        $('#lcelu_emp').text(data.empleado.celular);
                    }
                    // MOSTRAR ESTADO
                    if (data.empleado.estado == '1') {
                        $('#lest_emp').text('ACTIVO');
                    } else {
                        $('#lest_emp').text('INACTIVO');
                    }
                    // MOSTRAR IMAGEN
                    if (data.empleado.rutaimagen == '') {
                        $('#limagen_emp').attr('src', '/img/user.jpg');
                    } else {
                        $('#limagen_emp').attr('src', '/uploads/' + data.empleado.rutaimagen);
                    }

                    $('.modal-title').text('Detalle del Registro');
                    $('#showModal').modal('show');
                }
            });
        });

        //************* ACTUALIZAR ESTADO *********************
        // $(document).on('change', '.toggle-class', function() {
        //     var estado = $(this).prop('checked') == true ? 1 : 0;
        //     var empleado_id = $(this).data('id');

        //     $.ajax({
        //         type: "GET",
        //         dataType: "json",
        //         url: route('cambiar.estadoempleado'),
        //         data: { 'estado': estado, 'empleado_id': empleado_id },
        //         beforeSend: function() {
        //             toastr['info']('Estado actualizado correctamente');
        //         },
        //         success: function(data) {
        //             console.log(data.success);
        //         }
        //     });
        // });


        // ****************** BORRRAR FILTROS EN DATATABLES **********************
        $('#btn-filtro').on('click', function() {
            $('#buscar_columna4').val('').keyup();
            $('#buscar_columna5').val('').keyup();
            $('#buscar_columna6').val('').keyup();
            $('#buscar_columna7').val('').keyup();
            $('#buscar_columna8').val('').keyup();
            $('#buscar_select1').val('').trigger('change');
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
