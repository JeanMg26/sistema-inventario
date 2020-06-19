$(document).ready(function() {


    // *********** CARGAR Y MOSTRAR IMAGEN EN FORMULARIO ***********
    function LeerURL(input) {
        if (input.files && input.files[0]) {

            var image = input.files[0];
            var type = image.type;

            if (type == 'image/jpeg' || type == 'image/jpg' || type == 'image/png') {

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mi_img').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

            } else {
                Swal.fire({
                    title: "Error",
                    text: "Archivo inválido.",
                    type: "error",
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: 'btn btn-success btn-lg px-4',
                    },
                    buttonsStyling: false
                });

                $('#miImagenInput').val('');
                return false;

            }
        }
        return false;
    }

    $('#miImagenInput').change(function() {
        LeerURL(this);
    });
    // *************************** FIN ***************************


    // *********** CARGAR Y MOSTRAR IMAGEN EN FORMULARIO USUARIO MODAL ***********
    function LeerURLModal(input) {
        if (input.files && input.files[0]) {

            var image = input.files[0];
            var type = image.type;

            if (type == 'image/jpeg' || type == 'image/jpg' || type == 'image/png') {

                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mi_img_modal').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

            } else {

                Swal.fire({
                    title: "Error",
                    text: "Archivo inválido.",
                    type: "error",
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: 'btn btn-success btn-lg px-4',
                    },
                    buttonsStyling: false
                });

                $('#miImagenInputModal').val('');
                return false;

            }
        }
        return false;
    }

    $('#miImagenInputModal').change(function() {
        LeerURLModal(this);
    });
    // *************************** FIN ***************************

    // **************** INICIAR EL BOOTSTRAP INPUT FILE ******************
    bsCustomFileInput.init();



    // *********** PERMITIR EL INGRESO DE SOLO NUMEROS ****************
    $(".numerico").bind('keypress', function(event) {
        var key = window.Event ? event.charCode : event.charCode;
        // return (key >= 48 && key <= 57) || (key == 46);
        return (key >= 48 && key <= 57);
    });

    // *************** PERMITIR SOLO LETRAS *******************
    $(".letras").bind('keypress', function(event) {
        key = event.keyCode || event.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = [8, 32, 46];
        tecla_especial = false;
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    });

    // *************** PERMITIR SOLO LETRAS Y NUMEROS *******************
    $(".alfanumerico").bind('keypress', function(event) {
        var regex = new RegExp("^[a-zA-Z0-9 -]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(".alfanumerico2").bind('keypress', function(event) {
        var regex = new RegExp("^[a-zA-Z0-9 -.#]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    //PERMITIR SOLO LETRAS EN SELECT2
    // $(document).on('keypress', '.select2-search__field', function() {
    //     $(this).val($(this).val());
    //     if ((event.which < 65 || event.which > 90) && (event.which < 97 || event.which > 122) && (event.which != 32) && (event.which != 45) && (event.which != 47) && (event.which != 40) && (event.which != 41)) {
    //         event.preventDefault();
    //     }
    // });

    // Bootstrap Select-Picker para todos los selects
    // $('.selectpicker').selectpicker();



    // ******* CORREGIR ERROR DE SIDEBAR - ACTIVE *************
    var url_origin = window.location.origin;
    var url_href = location.href;
    var separador = "/";
    var url_separada = url_href.split(separador);
    var union_url = url_origin + '/' + url_separada[3];

    $('ul#sidebarnav a').filter(function() {
        return this.href == union_url;
    }).parent().addClass('activar').parent().addClass('in').parent().addClass('padre').find('a').first().addClass('activar');
    // ******* FIN *************



});
