$(document).ready(function() {

    function init() {


        var table = $('#tabla_ubicaciones').DataTable({
            serverSide: true,
            pageLength: 15,
            order: [
                [1, 'asc']
            ],
            processing: true,
            dom: 'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('ubicaciones.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'codlocal',
                    name: 'locales.codlocal',
                },
                {
                    data: 'local',
                    name: 'locales.descripcion'
                },
                {
                    data: 'codarea',
                    name: 'areas.codarea'
                },
                {
                    data: 'area',
                    name: 'areas.descripcion'
                },
                {
                    data: 'codoficina',
                    name: 'oficinas.codoficina'
                },
                {
                    data: 'oficina',
                    name: 'oficinas.descripcion'
                },
            ],
            language: {
                url: 'js/datatable-es.json',
            },
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

        $('#buscar_select1').change(function() {
            table.columns(1).search(this.value).draw();
        });

        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_ubicaciones thead tr th').css('pointer-events', 'none');




        events();
    }

    function events() {

        $('#buscar_select1').select2({
            width: '100%',
            placeholder: "SELECCIONAR...",
            allowClear: true,
            language: "es",
            dropdownParent: $('#parent')
        });

    }

    init();

});
