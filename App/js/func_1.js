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
    $('form#wrapped').attr('action', './Script/logicForm.php');
    
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
                var telefonoValue = $('#telefono').val();
                var regexTelefono = /^\d{8}$/;
                if (!regexTelefono.test(telefonoValue)) {
                    $('#telefono').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#telefono').removeClass('is-invalid');
                }
            }
            //validacion para años de antiguedad
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

            //validacion para años de Ingreso
            if (currentStep.find('#Ingreso').length > 0) {
                var ingresoValue = $('#Ingreso').val();
                var regexIngreso = /^\d+$/;
                if (!regexIngreso.test(ingresoValue)) {
                    $('#Ingreso').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#Ingreso').removeClass('is-invalid');
                }
            }
            //para valor de compra
            if (currentStep.find('#valor_compra').length > 0) {
                var valorCompraValue = $('#valor_compra').val();
                var regexValor = /^\d+$/;
                if (!regexValor.test(valorCompraValue)) {
                    $('#valor_compra').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#valor_compra').removeClass('is-invalid');
                }
            }
            //para marca
            if (currentStep.find('#marca').length > 0) {
                var marcaValue = $('#marca').val();
                var regexMarca = /^[a-zA-Z]+$/;
                if (!regexMarca.test(marcaValue)) {
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
                var deudaValue = $('#deuda').val();
                var regexDeuda = /^\d+$/;
                if (!regexDeuda.test(deudaValue)) {
                    $('#deuda').addClass('is-invalid');
                    valid = false;
                } else {
                    $('#deuda').removeClass('is-invalid');
                }
            }

            // Prevenir el comportamiento predeterminado si hay algún error de validación
            if (!valid) {
                event.preventDefault();
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