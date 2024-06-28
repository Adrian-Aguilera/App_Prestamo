/*  Wizard */
jQuery(function($) {
    "use strict";
    // Chose below which method to send the email, available:
    // Simple phpmail text/plain > send_email_1.php 
    // PHPMailer text/html > phpmailer/send_email_1_phpmailer.php (default)
    // PHPMailer text/html SMTP > phpmailer/send_email_1_phpmailer_smtp.php
    // PHPMailer with html template > phpmailer/send_email_1_phpmailer_template.php
    // PHPMailer with html template SMTP > phpmailer/send_email_1_phpmailer_template_smtp.php
    //$('form#wrapped').attr('action', 'phpmailer/send_email_1_phpmailer.php');
    $('form#wrapped').attr('action', 'http://creditocarro.pxtn82hres-zng4pm5q74dp.p.temp-site.link');
    $("#wizard_container").wizard({
        stepsWrapper: "#wrapped",
        submit: ".submit",
        unidirectional: false,
        beforeSelect: function(event, state) {
            if ($('input#website').val().length != 0) {
                return false;
            }
            if (!state.isMovingForward) {
                return true;
            }
            var currentStep = $(this).wizard('state').step;
            var inputs = currentStep.find(':input');
            var valid = true; // asume que todo es válido inicialmente
    
            if (currentStep.find('#dui').length > 0) {
                var duiValue = $('#dui').val();
                var regexDUI = /^\d{9}$/;
                if (!regexDUI.test(duiValue)) {
                    $('#dui').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#dui').removeClass('is-invalid');
                }
            }

            //validiacion para el telefono
            if (currentStep.find('#telefono').length > 0) {
                var duiValue = $('#telefono').val();
                var regexTelefono = /^\d{8}$/;
                if (!regexTelefono.test(duiValue)) {
                    $('#telefono').addClass('is-invalid');
                    valid = false;

                    
                } else {
                    $('#telefono').removeClass('is-invalid');
                }
            }
            //vallidacion para años de antiguedad
            if (currentStep.find('#antiguedad').length > 0) {
                var antiguedadValue = $('#antiguedad').val();
                var regexAntiguedad = /^\d+$/;
                if (!regexAntiguedad.test(antiguedadValue)) {
                    $('#antiguedad').addClass('is-invalid');
                    valid = false;
                    
                } else {
                    $('#antiguedad').removeClass('is-invalid');
                }
            }

            //vallidacion para años de Ingreso
            if (currentStep.find('#Ingreso').length > 0) {
                var IngresoiValue = $('#Ingreso').val();
                var regexIngreso = /^\d+$/;
                if (!regexIngreso.test(IngresoiValue)) {
                    $('#Ingreso').addClass('is-invalid');
                    valid = false;

                    
                } else {
                    $('#Ingreso').removeClass('is-invalid');
                }
            }
            //para valor de compra
            if (currentStep.find('#valor_compra').length > 0) {
                var ValorValue = $('#valor_compra').val();
                var regexValor = /^\d+$/;
                if (!regexValor.test(ValorValue)) {
                    $('#valor_compra').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#valor_compra').removeClass('is-invalid');
                }
            }
            //para marca
            if (currentStep.find('#marca').length > 0) {
                var ValorValue = $('#marca').val();
                var regexValor = /^[a-zA-Z]+$/;
                if (!regexValor.test(ValorValue)) {
                    $('#marca').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#marca').removeClass('is-invalid');
                }
            }

            //referencia telefono
            if (currentStep.find('#R_telefono').length > 0) {
                var rTelefonoValue = $('#R_telefono').val();
                var regexrTelefono = /^\d{8}$/;
                if (!regexrTelefono.test(rTelefonoValue)) {
                    $('#R_telefono').addClass('is-invalid');
                    valid = false;

                    
                } else {
                    $('#R_telefono').removeClass('is-invalid');
                }
            }
            //segunda referencia telefono
            if (currentStep.find('#SR_telefono').length > 0) {
                var srTelefonoValue = $('#SR_telefono').val();
                var regexsrTelefono = /^\d{8}$/;
                if (!regexsrTelefono.test(srTelefonoValue)) {
                    $('#SR_telefono').addClass('is-invalid');
                    valid = false;

                    
                } else {
                    $('#SR_telefono').removeClass('is-invalid');
                }
            }
            //deuda
            if (currentStep.find('#deuda').length > 0) {
                var DeudaValue = $('#deuda').val();
                var regexDeuda = /^\d+$/;
                if (!regexDeuda.test(DeudaValue)) {
                    $('#deuda').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#deuda').removeClass('is-invalid');
                }
            }
            return valid && (!inputs.length || !!inputs.valid());
        }
    }).validate({
        errorPlacement: function(error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });
    
    $('form#wrapped').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                alert('Formulario enviado correctamente.');
                // Redirigir a una nueva página HTML después de enviar el formulario
                window.location.href = 'pagina_exito.html'; // Reemplaza 'pagina_exito.html' con la URL de la página a la que quieres redirigir
            },
            error: function(xhr, status, error) {
                console.log('Error al enviar el formulario:', error);
                alert('Error al enviar el formulario.');
            }
        });
    });

    //  progress bar
    $("#progressbar").progressbar({ stepsComplete: 1 });
    $("#wizard_container").wizard({
        afterSelect: function(event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("" + state.stepsComplete + " of " + state.stepsPossible + " completed");
        }
    });
});

$("#wizard_container").wizard({
    transitions: {
        branchtype: function($step, action) {
            var branch = $step.find(":checked").val();
            if (!branch) {
                $("form").valid();
            }
            return branch;
        }
    }
});

/* File upload validate size and file type - For details: https://github.com/snyderp/jquery.validate.file*/
$("form#wrapped")
    .validate({
        rules: {
            fileupload: {
                fileType: {
                    types: [
                        "pdf", 
                        "application/msword", 
                        "application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
                        "image/jpeg",
                        "image/jpg"
                    ]
                },
                maxFileSize: {
                    "unit": "MB",
                    "size": 5
                },
                minFileSize: {
                    "unit": "KB",
                    "size": "2"
                }
            }
        }
    });

// Input name and email value
function getVals(formControl, controlType) {
    switch (controlType) {

        case 'name_field':
            // Get the value for input
            var value = $(formControl).val();
            $("#name_field").text(value);
            break;

        case 'email_field':
            // Get the value for input
            var value = $(formControl).val();
            $("#email_field").text(value);
            break;
    }
}