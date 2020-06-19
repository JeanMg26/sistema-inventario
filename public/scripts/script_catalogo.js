$(document).ready(function() {

    function init() {

        var table = $('#tabla_catalogo').DataTable({
            serverSide: true,
            pageLength: 15,
            order: [
                [2, 'asc']
            ],
            processing: true,
            dom: 'r<"H"><"datatable-scroll"t><"row botom-datatable"<"col-12 col-md-6"i><"col-12 col-md-6"p>>',
            ajax: {
                url: route('catalogo.data'),
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-center'
                },
                {
                    data: 'codigo',
                    name: 'catalogos.codigo',
                    class: 'text-center'
                },
                {
                    data: 'descripcion',
                    name: 'catalogos.descripcion',
                    class: 'pl-3'
                },
            ],
            language: {
                url: 'js/datatable-es.json',
            },
        });


        $('#buscar_columna1').on('keyup', function() {
            table.columns(1).search(this.value).draw();
        });

        $('#buscar_columna2').on('keyup', function() {
            table.columns(2).search(this.value).draw();
        });


        // ********* TRUCO PARA NO PERMITIR AL USUARIO ORDENAR PERO INTERNAMENTE SI PODER ORDENAR ********
        $('#tabla_catalogo thead tr th').css('pointer-events', 'none');



    }

    init();


});
