$(document).ready(function() {

    function init() {

        var table = $('#tabla_coordinaciones').DataTable({
            // ordering: false,
            serverSide: true,
            pageLength: 15,
            processing: true,
           order: [[1, 'asc'], [2, 'asc']],
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
                        filename: 'COORDINACIÓN DE INVENTARIO',
                        title: '',
                        text: '<i class="fal fa-file-excel mr-1"></i>Excel',
                        className: 'btn btn-success btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
                        },
                        customize: function(xlsx) {
                            console.log(xlsx);
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            var downrows = 1;
                            var clRow = $('row', sheet);
                            //update Row
                            clRow.each(function() {
                                var attr = $(this).attr('r');
                                var ind = parseInt(attr);
                                ind = ind + downrows;
                                $(this).attr("r", ind);
                            });

                            // Update  row > c
                            $('row c ', sheet).each(function() {
                                var attr = $(this).attr('r');
                                var pre = attr.substring(0, 1);
                                var ind = parseInt(attr.substring(1, attr.length));
                                ind = ind + downrows;
                                $(this).attr("r", pre + ind);
                            });

                            function Addrow(index, data) {
                                msg = '<row r="' + index + '">'
                                for (i = 0; i < data.length; i++) {
                                    var key = data[i].k;
                                    var value = data[i].v;
                                    msg += '<c t="inlineStr" r="' + key + index + '" s="2">';
                                    msg += '<is>';
                                    msg += '<t>' + value + '</t>';
                                    msg += '</is>';
                                    msg += '</c>';
                                }
                                msg += '</row>';
                                return msg;
                            }

                            //insert
                            // var r_blanco = Addrow(1, [{ k: 'D', v: '' }]);
                            var r1 = Addrow(1, [
                                { k: 'F', v: 'ENTREGA' },
                                { k: 'I', v: 'RETORNO' },
                                { k: 'm', v: 'TOTALES' },
                            ]);

                            sheet.childNodes[0].childNodes[1].innerHTML = r1 + sheet.childNodes[0].childNodes[1].innerHTML;

                            // ************* COMBINAR FILAS ****************
                            var inicio = $('mergeCells', sheet);
                            var entrega = $('mergeCells', sheet);
                            var retorno = $('mergeCells', sheet);
                            var total = $('mergeCells', sheet);
                            var final = $('mergeCells', sheet);

                            inicio[0].appendChild(_createNode(sheet, 'mergeCell', {
                                attr: {
                                    ref: 'A1:E1',
                                }
                            }));

                            entrega[0].appendChild(_createNode(sheet, 'mergeCell', {
                                attr: {
                                    ref: 'F1:H1',
                                }
                            }));

                            retorno[0].appendChild(_createNode(sheet, 'mergeCell', {
                                attr: {
                                    ref: 'I1:L1',
                                }
                            }));

                            total[0].appendChild(_createNode(sheet, 'mergeCell', {
                                attr: {
                                    ref: 'M1:O1',
                                }
                            }));

                            final[0].appendChild(_createNode(sheet, 'mergeCell', {
                                attr: {
                                    ref: 'P1:R1',
                                }
                            }));

                            inicio.attr('count', inicio.attr('count') + 1);
                            entrega.attr('count', entrega.attr('count') + 1);
                            retorno.attr('count', retorno.attr('count') + 1);
                            total.attr('count', total.attr('count') + 1);
                            final.attr('count', final.attr('count') + 1);

                            // ********* FUNCION PARA COMBINAR CELDAS ***************
                            function _createNode(doc, nodeName, opts) {
                                var tempNode = doc.createElement(nodeName);

                                if (opts) {
                                    if (opts.attr) {
                                        $(tempNode).attr(opts.attr);
                                    }

                                    if (opts.children) {
                                        $.each(opts.children, function(key, value) {
                                            tempNode.appendChild(value);
                                        });
                                    }

                                    if (opts.text !== null && opts.text !== undefined) {
                                        tempNode.appendChild(doc.createTextNode(opts.text));
                                    }
                                }
                                return tempNode;
                            }
                        },

                    },

                    {
                        extend: 'pdf',
                        filename: 'COORDINACIÓN DE INVENTARIO',
                        title: '',
                        orientation: 'landscape',
                        text: '<i class="fal fa-file-pdf mr-1"></i>PDF',
                        className: 'btn btn-danger btn-sm mr-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
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
                            doc.content[0].layout = objLayout;

                            doc.defaultStyle.fontSize = '7';
                            doc.styles.tableHeader = { fillColor: '#e46a76', color: 'white', alignment: 'center' };

                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fal fa-print mr-1"></i>Imprimir',
                        filename: 'COORDINACIÓN DE INVENTARIO',
                        title: '',
                        className: 'btn btn-info btn-sm',
                        titleAttr: 'Imprimir',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
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
                url: route('coordinaciones.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'equipo',
                    name: 'equipos.nombre'
                },
                {
                    data: "codlocal",
                    name: "locales.codlocal",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" rel="tooltip" data-placement="top" title="' + oData['local'] + '">' + oData['codlocal'] + '</span>');
                    }
                },
                {
                    data: "codarea",
                    name: "areas.codarea",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['area'] + '">' + oData['codarea'] + '</span>');
                    }
                },
                {
                    data: "codoficina",
                    name: "oficinas.codoficina",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html('<span data-toggle="tooltip" data-placement="top" title="' + oData['oficina'] + '">' + oData['codoficina'] + '</span>');
                    }
                },

                {
                    data: 'hoja_ent',
                    name: 'coordinaciones.hoja_ent',
                    visible: false
                },
                {
                    data: 'sticker_ent',
                    name: 'coordinaciones.sticker_ent',
                    visible: false
                },
                {
                    data: 'fec_ent',
                    name: 'coordinaciones.fec_ent',
                    visible: false
                },

                {
                    data: 'hoja_ret',
                    name: 'coordinaciones.hoja_ret',
                    visible: false
                },
                {
                    data: 'sticker_ret',
                    name: 'coordinaciones.sticker_ret',
                    visible: false
                },
                {
                    data: 'adic_ret',
                    name: 'coordinaciones.adic_ret',
                    visible: false
                },
                {
                    data: 'fec_ret',
                    name: 'coordinaciones.fec_ret',
                    visible: false
                },



                {
                    data: 'ubicados',
                    name: 'coordinaciones.bienes_ubi'
                },
                {
                    data: 'noubicados',
                    name: 'coordinaciones.bienes_noubi'
                },
                {
                    data: 'adicionales',
                    name: 'coordinaciones.bienes_adic',
                },
                {
                    data: 'fechaC',
                    name: 'coordinaciones.created_at',
                    visible: false
                },
                {
                    data: 'est_coordinacion',
                    name: 'coordinaciones.estado',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (row.est_coordinacion == '1') {
                            return '<label class="badge badge-success">PROCESAMIENTO</label>';
                        } else {
                            return '<label class="badge badge-danger">COORDINACIÓN</label>';
                        }
                    }
                },
                {
                    data: 'observacion',
                    name: 'coordinaciones.observacion',
                    visible: false
                },
                {
                    data: 'acciones',
                    name: 'acciones',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [{
                    targets: [15],
                    render: function(data) {
                        return moment(data).format('YYYY');
                    }
                },
                {
                    targets: [7, 11],
                    render: function(data, type, row) {
                        if (row.fec_ret == '' || row.fec_ret == null) {
                            return '';
                        } else {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    }
                }
            ],
            language: {
                url: 'js/datatable-es.json',
            },
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            },
            rowCallback: function(row, data, index) {

                if (data['est_coordinacion'] === '1') {
                    $(row).find('td').css('background-color', '#d3f9d8');
                } else {
                    $(row).find('td').css('background-color', '#ffe8cc');
                }

            },
        });



        // BUSQUEDA INDIVIDUAL POR COLUMNA
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

        $('#buscar_select1').change(function() {
            table.columns(1).search(this.value).draw();
        });

        $('#year').change(function() {
            table.columns(15).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_coordinaciones thead tr th').css('pointer-events', 'none');


        events();
    }

    function events() {
        // ************* LLAMANDO AL SHOW MODAL DESDE AJAX *************
        $(document).on('click', '.view', function() {
            var show_id = $(this).attr('id');
            $.ajax({
                url: "coordinaciones/" + show_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // INICIALIZA EN BLANCO ESTOS CAMPOS 
                    $('#div-nom1').addClass('d-none');
                    $('#lnom_empleado1').text('');
                    $('#div-nom2').addClass('d-none');
                    $('#lnom_empleado2').text('');
                    $('#lnom1').text('');
                    $('#lnom1').addClass('d-none');
                    $('#lnom2').text('');
                    $('#lnom2').addClass('d-none');
                    $('#lnom_equipo').text(data.equipo.nombre);
                    // NOMBRE DE CADA EMPLEADO
                    $.each(data.empleado, function(index, data) {
                        if (index == '0') {
                            $('#lnom1').removeClass('d-none');
                            $('#div-nom1').removeClass('d-none');
                            $('#lnom_empleado1').text(data.completos);
                            $('#lnom1').text(data.rol);
                        }
                        if (index == '1') {
                            $('#lnom2').removeClass('d-none');
                            $('#div-nom2').removeClass('d-none');
                            $('#lnom_empleado2').text(data.completos);
                            $('#lnom2').text(data.rol);
                        }
                    });
                    $('#llocal').text(data.local.codlocal + ' - ' + data.local.descripcion);
                    $('#larea').text(data.area.codarea + ' - ' + data.area.descripcion);
                    $('#loficina').text(data.oficina.codoficina + ' - ' + data.oficina.descripcion);
                    if (data.coordinacion.estado == '1') {
                        $('#lestado').text('PROCESAMIENTO');
                    } else {
                        $('#lestado').text('COORDINACIÓN');
                    }
                    // ******** ENTREGA DE FOLIOS ************
                    $('#lhoja_ent').text(data.coordinacion.hoja_ent);
                    $('#lsticker_ent').text(data.coordinacion.sticker_ent);
                    // FECHA
                    var fec_ent = data.coordinacion.fec_ent;
                    var ffec_ent = moment(fec_ent).format('DD-MM-YYYY');
                    $('#lfec_ent').text(ffec_ent);
                    // ******** RETORNO DE FOLIOS ************
                    $('#lhoja_ret').text(data.coordinacion.hoja_ret);
                    $('#lsticker_ret').text(data.coordinacion.sticker_ret);
                    $('#ladic_ret').text(data.coordinacion.adic_ret);
                    // FECHA
                    var fec_ret = data.coordinacion.fec_ret;
                    var ffec_ret = moment(fec_ret).format('DD-MM-YYYY');
                    $('#lfec_ret').text(ffec_ret);
                    // ******** CONTROL TOTAL ************
                    $('#lbienes_ubi').text(data.coordinacion.bienes_ubi);
                    $('#lbienes_noubi').text(data.coordinacion.bienes_noubi);
                    $('#lbienes_adic').text(data.coordinacion.bienes_adic);
                    // OBSERVACIONES
                    if (data.coordinacion.observacion == '' | data.coordinacion.observacion == null) {
                        $('#lobservacion').text('-------------------------');
                    } else {
                        $('#lobservacion').text(data.coordinacion.observacion);
                    }
                    $('.modal-title').text('Detalle del Registro');
                    $('#showModal').modal('show');
                }
            })
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
                url: '/coordinaciones/destroy/' + delete_id,
                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                    toastr['error']('Registro eliminado correctamente');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('#tabla_coordinaciones').DataTable().ajax.reload();
                    }, 400);
                }
            })
        });

        // ****************** BORRRAR FILTROS **********************
        $('#btn-filtro').on('click', function() {
            $('#buscar_columna1').val('').keyup();
            $('#buscar_columna2').val('').keyup();
            $('#buscar_columna3').val('').keyup();
            $('#buscar_columna4').val('').keyup();
            $('#buscar_select1').val('').trigger('change');
            $('#buscar_select2').val('').trigger('change');
        });

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
