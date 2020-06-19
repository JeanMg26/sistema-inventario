var Inventario = function() {
    return {
        validacionGeneral: function(id, reglas, mensajes) {
            const formulario = $('#' + id);
            formulario.validate({
                rules: reglas,
                messages: mensajes,
                errorElement: 'span', //default input error message container
                errorClass: 'invalid-feedback', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                highlight: function(element, errorClass, validClass) { // hightlight error inputs

                    if ($(element).attr("name") == "permisos[]") {
                        $(element).closest('.card').addClass('has-error-card');
                    } else if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).parent().addClass('has-error-select2');
                    } else {
                        $(element).closest('.form-control').addClass('is-invalid');
                    }
                },
                unhighlight: function(element, errorClass, validClass) { // revert the change done by hightlight
                    if ($(element).hasClass('select2-hidden-accessible')) {
                        $(element).parent().removeClass('has-error-select2');
                    } else {
                        $(element).closest('.form-control').removeClass('is-invalid');
                    }
                },
                success: function(alerta) {

                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "permisos[]") {
                        error.appendTo('#error-permiso-query');
                        error.css('display', 'block');
                    } else if (element.hasClass('select2-hidden-accessible')) {
                        element.next().after(error);
                        error.css('display', 'block');
                    } else if (element.parent().hasClass('input-group')) {
                        error.insertAfter(element.parent());
                        error.css('display', 'block');
                    } else {
                        error.insertAfter(element);
                    }

                },
                invalidHandler: function(event, validator) { //display error alert on form submit

                },
                submitHandler: function(form) {
                    return true;
                }
            });
        },
    };
}();
