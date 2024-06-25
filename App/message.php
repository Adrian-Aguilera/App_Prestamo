<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$host = 'localhost';  
$db = 'crediCar';  
$user = 'mytest';  
$pass = 'c82WfoAS8OqGgavy5WqG2qQhxRTMXXHy';  

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

// Función para manejar la subida de archivos y la inserción de datos
function uploadData($files, $postData, $pdo) {
    // Procesar archivos subidos
    $filePaths = [];
    foreach ($files as $key => $file) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $filePaths[$key] = $uploadFile;
        } else {
            return ["status" => "error", "message" => "Failed to upload file: " . $file['name']];
        }
    }

    // Preparar y ejecutar la declaración de inserción
    $stmt = $pdo->prepare("
        INSERT INTO datos_personales (
            nombre, fechaNacimiento, Dui, direccion, departamento, correo,
            urlArchivoLuzAgua, Empleador, Nombrejefe, DireccionEmpresa, 
            departamentoEmpresa, cargoEmpresa, anioEmpresa, ingresos, 
            bancoJSON, tipoCuenta, MontoDeuda, tarjetaCredito, 
            urlArchivoCuentaBanco, marcaAuto, Modelo, valorAuto, 
            urlArchivoFotoAuto, nombreReferencia_a, telefonoreferencia_a, 
            relacionaReferencia_a, nombreReferencia_b, telefonoreferencia_b, 
            relacionaReferencia_b
        ) VALUES (
            :nombre, :fechaNacimiento, :Dui, :direccion, :departamento, :correo,
            :urlArchivoLuzAgua, :Empleador, :Nombrejefe, :DireccionEmpresa, 
            :departamentoEmpresa, :cargoEmpresa, :anioEmpresa, :ingresos, 
            :bancoJSON, :tipoCuenta, :MontoDeuda, :tarjetaCredito, 
            :urlArchivoCuentaBanco, :marcaAuto, :Modelo, :valorAuto, 
            :urlArchivoFotoAuto, :nombreReferencia_a, :telefonoreferencia_a, 
            :relacionaReferencia_a, :nombreReferencia_b, :telefonoreferencia_b, 
            :relacionaReferencia_b
        )
    ");

    try {
        $stmt->execute([
            'nombre' => $postData['nombre'],
            'fechaNacimiento' => $postData['fechaNacimiento'],
            'Dui' => $postData['Dui'],
            'direccion' => $postData['direccion'],
            'departamento' => $postData['departamento'],
            'correo' => $postData['correo'],
            'urlArchivoLuzAgua' => $filePaths['urlArchivoLuzAgua'] ?? null,
            'Empleador' => $postData['Empleador'],
            'Nombrejefe' => $postData['Nombrejefe'],
            'DireccionEmpresa' => $postData['DireccionEmpresa'],
            'departamentoEmpresa' => $postData['departamentoEmpresa'],
            'cargoEmpresa' => $postData['cargoEmpresa'],
            'anioEmpresa' => $postData['anioEmpresa'],
            'ingresos' => $postData['ingresos'],
            'bancoJSON' => $postData['bancoJSON'],
            'tipoCuenta' => $postData['tipoCuenta'],
            'MontoDeuda' => $postData['MontoDeuda'],
            'tarjetaCredito' => $postData['tarjetaCredito'],
            'urlArchivoCuentaBanco' => $filePaths['urlArchivoCuentaBanco'] ?? null,
            'marcaAuto' => $postData['marcaAuto'],
            'Modelo' => $postData['Modelo'],
            'valorAuto' => $postData['valorAuto'],
            'urlArchivoFotoAuto' => $filePaths['urlArchivoFotoAuto'] ?? null,
            'nombreReferencia_a' => $postData['nombreReferencia_a'],
            'telefonoreferencia_a' => $postData['telefonoreferencia_a'],
            'relacionaReferencia_a' => $postData['relacionaReferencia_a'],
            'nombreReferencia_b' => $postData['nombreReferencia_b'],
            'telefonoreferencia_b' => $postData['telefonoreferencia_b'],
            'relacionaReferencia_b' => $postData['relacionaReferencia_b']
        ]);
        return ["status" => "success", "message" => "Data inserted successfully."];
    } catch (Exception $e) {
        return ["status" => "error", "message" => $e->getMessage()];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = uploadData($_FILES, $_POST, $pdo);
    echo json_encode($response);
}