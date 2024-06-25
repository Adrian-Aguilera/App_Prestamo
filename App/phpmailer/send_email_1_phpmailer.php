<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Potenza - Job Application Form Wizard with Resume upload and Branch feature">
    <meta name="author" content="Ansonika">
    <title>Potenza | Job Application Form Wizard by Ansonika</title>

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="../css/custom.css" rel="stylesheet">

    <script type="text/javascript">
    function delayedRedirect() {
        window.location = "../index.html"
    }
    </script>

</head>

<body onLoad="setTimeout('delayedRedirect()', 8000)" style="background-color:#fff;">
    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'src/Exception.php';
    require 'src/PHPMailer.php';

    $mail = new PHPMailer(true);

    try {
        // Recipients - main edits
        $mail->setFrom('cruz74270@gmail.com', 'Message from prueba');  // Email Address and Name FROM
        $mail->addAddress('adrian.aguileragcm@gmail.com', 'test');  // Email Address and Name TO - Name is optional
        $mail->addReplyTo('noreply@potenza.com', 'Message from POTENZA');  // Email Address and Name NOREPLY
        $mail->isHTML(true);
        $mail->Subject = 'Message from POTENZA';  // Email Subject

        // The email body message
        $message  = "<strong>Formulario de solicitud</strong><br />";
        $message .= "Nombre completo: " . (isset($_POST['name']) ? $_POST['name'] : '') . "<br />";
        $message .= "Fecha de nacimiento: " . (isset($_POST['date-nacimiento']) ? $_POST['date-nacimiento'] : '') . "<br />";
        $message .= "DUI: " . (isset($_POST['dui']) ? $_POST['dui'] : '') . "<br />";
        $message .= "Dirección: " . (isset($_POST['direccion']) ? $_POST['direccion'] : '') . "<br />";
        $message .= "Departamento: " . (isset($_POST['departamento1-option']) ? $_POST['departamento1-option'] : '') . "<br />";
        $message .= "Teléfono: " . (isset($_POST['Ntelefono']) ? $_POST['Ntelefono'] : '') . "<br />";
        $message .= "Correo electrónico: " . (isset($_POST['mail']) ? $_POST['mail'] : '') . "<br />";
        $message .= "Empleador actual: " . (isset($_POST['E_employer']) ? $_POST['E_employer'] : '') . "<br />";
        $message .= "Nombre del jefe: " . (isset($_POST['E_employer_boss']) ? $_POST['E_employer_boss'] : '') . "<br />";
        $message .= "Dirección del empleador: " . (isset($_POST['address']) ? $_POST['address'] : '') . "<br />";
        $message .= "Departamento del empleador: " . (isset($_POST['departamento2-option']) ? $_POST['departamento2-option'] : '') . "<br />";
        $message .= "Cargo: " . (isset($_POST['cargo']) ? $_POST['cargo'] : '') . "<br />";
        $message .= "Años de antigüedad: " . (isset($_POST['antiguedad']) ? $_POST['antiguedad'] : '') . "<br />";
        $message .= "Ingreso bruto mensual: " . (isset($_POST['Ingreso']) ? $_POST['Ingreso'] : '') . "<br />";
        $message .= "Deuda mensual: " . (isset($_POST['deuda']) ? $_POST['deuda'] : '') . "<br />";
        $message .= "Marca del auto: " . (isset($_POST['marca']) ? $_POST['marca'] : '') . "<br />";
        $message .= "Modelo del auto: " . (isset($_POST['modelo']) ? $_POST['modelo'] : '') . "<br />";
        $message .= "Valor de compra del auto: " . (isset($_POST['valor_compra']) ? $_POST['valor_compra'] : '') . "<br />";
        $message .= "Primera referencia personal: " . (isset($_POST['referencia_first']) ? $_POST['referencia_first'] : '') . "<br />";
        $message .= "Relación primera referencia: " . (isset($_POST['relacion1-option']) ? $_POST['relacion1-option'] : '') . "<br />";
        $message .= "Teléfono primera referencia: " . (isset($_POST['R_telefono']) ? $_POST['R_telefono'] : '') . "<br />";
        $message .= "Segunda referencia personal: " . (isset($_POST['referencia_second']) ? $_POST['referencia_second'] : '') . "<br />";
        $message .= "Relación segunda referencia: " . (isset($_POST['minimum_salary_full_time']) ? $_POST['minimum_salary_full_time'] : '') . "<br />";
        $message .= "Teléfono segunda referencia: " . (isset($_POST['SR_telefono']) ? $_POST['SR_telefono'] : '') . "<br />";
        $message .= "Términos aceptados: " . (isset($_POST['terms']) ? $_POST['terms'] : '') . "<br />";

        // Function to handle file upload
        function handleFileUpload($file, $allowed_extensions, $upload_dir) {
            $errors = array();
            $file_name = $file['name'];
            $file_size = $file['size'];
            $file_tmp = $file['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowed_extensions)) {
                $errors[] = "Extension not allowed, please choose a " . implode(', ', $allowed_extensions) . " file.";
            }

            if ($file_size > 5242880) { // 5MB limit
                $errors[] = 'File size must be max 5MB';
            }

            if (empty($errors)) {
                $random_name = uniqid('', true) . '.' . $file_ext;
                $destination = $upload_dir . $random_name;
                if (move_uploaded_file($file_tmp, $destination)) {
                    return $random_name;
                } else {
                    $errors[] = "Failed to upload file";
                }
            }
            return $errors;
        }

        // Set upload directory
        $upload_dir = realpath(dirname(__FILE__)) . '/../upload_files/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Handle resume file upload (PDF/DOC/DOCX)
        if (isset($_FILES['fileupload'])) {
            $resume_result = handleFileUpload($_FILES['fileupload'], array("pdf", "doc", "docx"), $upload_dir);
            if (is_array($resume_result)) {
                $message .= "<br />Resume upload errors: " . implode(', ', $resume_result);
            } else {
                $message .= "<br />Resume: http://www.yourdomain.com/upload_files/" . $resume_result;
            }
        }

        // Handle image file upload (JPG)
        if (isset($_FILES['fileupload_image1'])) {
            $image1_result = handleFileUpload($_FILES['fileupload_image1'], array("jpg"), $upload_dir);
            if (is_array($image1_result)) {
                $message .= "<br />Image 1 upload errors: " . implode(', ', $image1_result);
            } else {
                $message .= "<br />Image 1: http://www.yourdomain.com/upload_files/" . $image1_result;
            }
        }

        if (isset($_FILES['fileupload_image2'])) {
            $image2_result = handleFileUpload($_FILES['fileupload_image2'], array("jpg"), $upload_dir);
            if (is_array($image2_result)) {
                $message .= "<br />Image 2 upload errors: " . implode(', ', $image2_result);
            } else {
                $message .= "<br />Image 2: http://www.yourdomain.com/upload_files/" . $image2_result;
            }
        }

        $mail->Body = $message;
        $mail->send();

        // Confirmation/autoreply email send to who fill the form
        $mail->ClearAddresses();
        $mail->addAddress($_POST['mail']); // Email address entered on form
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation'; // Custom subject
        $mail->Body = $message;

        $mail->Send();

        echo '<div id="success">
            <div class="icon icon--order-success svg">
                 <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                  <g fill="none" stroke="#8EC343" stroke-width="2">
                     <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                     <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                  </g>
                 </svg>
             </div>
            <h4><span>Request successfully sent!</span>Thank you for your time</h4>
            <small>You will be redirect back in 5 seconds.</small>
        </div>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    ?>
    <!-- END SEND MAIL SCRIPT -->

</body>

</html>