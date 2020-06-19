$(document).ready(function() {

    function init() {

        var form = $('#form-ImportarExcel');
        var bar = $('.progress-bar');
        var status = $('#files-success');
        var cargar = $('.action_button');

        form.ajaxForm({
            beforeSend: function() {
                status.empty();
                bar.removeClass('bg-success');
                bar.removeClass('bg-danger');
                bar.addClass('bg-info');
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#process').removeClass('d-none');
                bar.addClass('progress-bar-animated');
                bar.text('Importando...');
                bar.css('width', percentComplete + '%');
                cargar.text('Importando...');
                cargar.prepend('<i class="fas fa-upload mr-2"></i>');
                cargar.attr('disabled', 'disabled');
            },
            success: function(data) {

                if (data.errors) {

                    if (data.errors.files) {
                        bar.text('Error');
                        bar.removeClass('progress-bar-animated');
                        bar.addClass('bg-danger');

                        $('#files-error').removeClass('d-none');
                        $('#files-success').addClass('d-none');
                        $('#abc.custom-file-label').addClass('has-error-card ');
                        $('#files-error').html(data.errors.files[0]);
                        cargar.text('Importar');
                        cargar.prepend('<i class="fas fa-upload mr-2"></i>');
                        cargar.attr('disabled', false);
                    }
                }

                if (data.success) {
                    bar.removeClass('bg-info');
                    bar.removeClass('progress-bar-animated');
                    bar.addClass('bg-success');
                    bar.text('Importado Correctamente.');
                    bar.css('width', '100%');
                    $('#files').val('');
                    $('#abc.custom-file-label').text('Elegir archivo');
                    cargar.text('Importar');
                    cargar.prepend('<i class="fas fa-upload mr-2"></i>');
                    cargar.attr('disabled', false);
                    status.removeClass('d-none');
                    status.text('Se importaron ' + data.registros_totales + ' registros satisfactoriamente.');
                }
            },
            error: function(data) {

                var errors = data.responseJSON;

                errorsHtml = '<div class="alert alert-danger pb-0 color-uns"><ul>';

                $.each(errors.errors, function(key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });

                errorsHtml += '</ul></div>';

                $('#form-errors').html(errorsHtml);

                bar.text('Error');
                bar.removeClass('progress-bar-animated');
                bar.addClass('bg-danger');

                cargar.text('Importar');
                cargar.prepend('<i class="fas fa-upload mr-2"></i>');
                cargar.attr('disabled', false);

                $('#files-error').addClass('d-none');
                $('#files-success').addClass('d-none');
                $('#abc.custom-file-label').addClass('has-error-card ');
            }
        });

        events();
        truncateTableBienes();
        alerts();
    }

    function events() {

        // ************** SCRIPT PARA MOSTRAR ARCHIVO CARGADO EN UN INPUT FILE *************/
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
        });
    }


    function alerts() {

        $('#files').on('change', function() {

            $('#form-errors').empty();
            $('#abc.custom-file-label').removeClass('has-error-card');
            $('#process').addClass('d-none');
            $('#files-success').addClass('d-none');

            if ($('#files-error').text() != '') {
                if (this.value == '') {
                    $('#files-error').removeClass('d-none');
                    $('#process').removeClass('d-none');
                    $('#abc.custom-file-label').addClass('has-error-card');
                } else {
                    $('#files-error').addClass('d-none');
                    $('#files-success').addClass('d-none');
                    $('#process').addClass('d-none');
                    $('#abc.custom-file-label').removeClass('has-error-card');
                }
            }

        });
    }

    function truncateTableBienes() {

        $('#truncate_tabla').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "¿Estas seguro?",
                text: "Se eliminaran todos los registros de la tabla bienes.",
                type: "question",
                showCancelButton: true,
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
                customClass: {
                    confirmButton: 'btn btn-success btn-lg mr-3',
                    cancelButton: 'btn btn-secondary btn-lg'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: "Exito",
                        text: "Los registros fueron eliminados satisfactoriamente.",
                        type: "success",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: 'btn btn-success btn-lg px-4',
                        },
                        buttonsStyling: false
                    });

                    $.ajax({
                        url: route('truncate.bienes'),
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            "_token": $('#csrf-token')[0].content // token
                        },
                        beforeSend: function() {
                            toastr.info('Los registros fueron eliminados satisfactoriamente.');
                        },
                        success: function(data) {
                            console.log('ok');
                        }
                    });
                }
            });

        });
    }


    init();

});
