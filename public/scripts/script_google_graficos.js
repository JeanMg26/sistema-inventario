$(document).ready(function() {

    // $(window).resize(function() {
    //     drawMonthlyChart();

    // });

    function init() {

        google.charts.load("visualization", "1", { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawMonthlyChart);
        google.charts.setOnLoadCallback(drawTeamChart);

        events();

    }

    function events() {

        $('#year_total').change(function() {
            var year_total = $(this).val();
            if (year_total != '') {
                $('#tchart_total').text('DATOS - INVENTARIO ' + year_total);
                load_monthly_data(year_total, 'DATOS DEL INVENTARIO -');
            } else {
                drawMonthlyChart();
                $('#tchart_total').text('');

            }
        });

        $('#year').change(function() {
            var year = $(this).val();
            if (year != '') {
                load_team_data(year, 'DATOS DEL INVENTARIO -');
                $('#echart_total').text('DATOS - INVENTARIO ' + year);
                $('#fecha_desde').val('').datepicker('setDate', null);
                $('#fecha_hasta').val('').datepicker('setDate', null);
            } else {
                drawTeamChart();
                $('#echart_total').text('');
                $('#fecha_desde').val('').datepicker('setDate', null);
                $('#fecha_hasta').val('').datepicker('setDate', null);
            }
        });

        $("#filtrar").on('click', function() {
            var fecha_desde = $('#fecha_desde').val();
            var fecha_hasta = $('#fecha_hasta').val();
            load_fecha_data(fecha_desde, fecha_hasta);
        });

        $('#reiniciar').on('click', function() {
            $('#fecha_desde').val('').datepicker('setDate', null);
            $('#fecha_hasta').val('').datepicker('setDate', null);
            $('#year').val('').trigger('change');
            drawTeamChart();
        });


        $('#year_total').select2({
            width: '100%',
            placeholder: "SELECCIONAR AÑO",
            allowClear: true,
            language: "es",
            dropdownParent: $('#btn-year_total')
        });

        $('#year').select2({
            width: '100%',
            placeholder: "SELECCIONAR AÑO",
            allowClear: true,
            language: "es",
            dropdownParent: $('#btn-year')
        });

        $('#fecha_desde').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            language: "es",
        });

        $('#fecha_hasta').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            language: "es",
        });
    }

    // ***************** CHART - MESES ***********************
    function drawMonthlyChart(chart_data, chart_main_title) {

        let jsonData = chart_data;


        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Mes');
        data.addColumn('number', 'Bienes Encontrados');
        data.addColumn('number', 'Bienes Adicionales');

        $.each(jsonData, (i, jsonData) => {

            let mes = jsonData.mes;
            let suma = parseInt(jsonData.suma);
            let suma2 = parseFloat($.trim(jsonData.suma2));
            data.addRows([
                [mes, suma, suma2]
            ]);
        });

        // Set chart options
        var options = {
            // title: chart_main_title,
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out',
            },
            hAxis: {
                title: "Meses",
                titleTextStyle: {
                    color: '#6c757d'
                },
                textStyle: {
                    fontSize: 12.5,
                    color: '#6c757d',
                },
            },
            vAxis: {
                title: "Bienes",
                titleTextStyle: {
                    color: '#6c757d'
                },
                textStyle: {
                    fontSize: 12.5,
                    color: '#6c757d',
                },
                viewWindow: {
                    min: 0,
                    max: 4000
                },
                ticks: [0, 500, 1000, 1500, 2000, 2500, 3000, 3500, 4000]
            },
            legend: { position: 'top', alignment: 'center' },
            // width: $(window).width(),
            height: $(window).height() * 0.75,
            series: {
                0: { color: '#339AF0' },
                1: { color: '#FFC078' }
            }

        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('tchart'));
        chart.draw(data, options);
    }

    // ***************** CHART - EQUIPOS ***********************
    function drawTeamChart(chart_data, chart_main_title) {

        let jsonData = chart_data;


        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Equipos');
        data.addColumn('number', 'Bienes Encontrados');
        data.addColumn('number', 'Bienes Adicionales');

        $.each(jsonData, (i, jsonData) => {

            let equipo = jsonData.equipo;
            let bienes_enc = parseFloat($.trim(jsonData.bienes_enc));
            let bienes_adic = parseFloat($.trim(jsonData.bienes_adic));
            data.addRows([
                [equipo, bienes_enc, bienes_adic]
            ]);
        });

        // Set chart options
        var options = {
            // title: chart_main_title,
            seriesType: 'bars',
            // bar: { groupWidth: '50%' },
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out',
            },
            hAxis: {
                title: "Equipos",
                titleTextStyle: {
                    color: '#6c757d'
                },
                textStyle: {
                    fontSize: 12.5,
                    color: '#6c757d',
                },
            },
            vAxis: {
                title: "Bienes",
                titleTextStyle: {
                    color: '#6c757d'
                },
                textStyle: {
                    fontSize: 12.5,
                    color: '#6c757d',
                },
                viewWindow: {
                    min: 0,
                    max: 4000
                },
                ticks: [0, 500, 1000, 1500, 2000, 2500, 3000, 3500, 4000]
            },
            legend: { position: 'top', alignment: 'center' },
            // width: $(window).width(),
            height: $(window).height() * 0.75,
            series: {
                0: { color: '#339AF0' },
                1: { color: '#FFC078' }
            }

        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ColumnChart(document.getElementById('echart'));
        chart.draw(data, options);
    }

    // ************ FUNCTION AJAX AÑO - BIENES TOTAL ************
    function load_monthly_data(year_total, title) {
        const temp_title = title + ' ' + year_total;
        $.ajax({
            url: route('graficos.total'),
            method: "POST",
            data: {
                "_token": $('#csrf-token')[0].content,
                year_total: year_total
            },
            dataType: "JSON",
            success: function(data) {
                drawMonthlyChart(data, temp_title);
            }
        });
        console.log(`Year: ${year_total}`);
    }


    // ************ FUNCTION AJAX AÑO - BIENES POR EQUIPOS  ************
    function load_team_data(year, title) {
        const temp_title = title + ' ' + year;
        $.ajax({
            url: route('graficos.equipos'),
            method: "POST",
            data: {
                "_token": $('#csrf-token')[0].content,
                year: year
            },
            dataType: "JSON",
            success: function(data) {
                drawTeamChart(data, temp_title);
            }
        });
        console.log(`Year: ${year}`);
    }

    // ************ FUNCTION AJAX ENTRE FECHAS - EQUIPOS  ************
    function load_fecha_data(fecha_desde, fecha_hasta) {
        // const temp_title = title + ' ' + year;
        $.ajax({
            url: route('graficos.equipos1'),
            method: "POST",
            data: {
                "_token": $('#csrf-token')[0].content,
                fecha_desde: fecha_desde,
                fecha_hasta: fecha_hasta
            },
            dataType: "JSON",
            success: function(data) {
                drawTeamChart(data);
            }
        });
        console.log(`Year: ${year}`);
    }



    init();




});
