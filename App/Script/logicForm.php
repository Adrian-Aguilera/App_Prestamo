<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Valores recibidos del formulario:</h2>";
    echo "<pre>";
    echo "Website: " . $_POST['website'] . "<br>";
    echo "Nombre Completo: " . $_POST['nombre'] . "<br>";
    echo "Fecha de Nacimiento: " . $_POST['fechaNacimiento'] . "<br>";
    echo "DUI: " . $_POST['Dui'] . "<br>";
    echo "Dirección: " . $_POST['direccion'] . "<br>";
    echo "Departamento: " . $_POST['departamento'] . "<br>";
    echo "Número de Teléfono: " . $_POST['Ntelefono'] . "<br>";
    echo "Correo Electrónico: " . $_POST['correo'] . "<br>";
    echo "Empleador: " . $_POST['Empleador'] . "<br>";
    echo "Nombre del Jefe: " . $_POST['Nombrejefe'] . "<br>";
    echo "Dirección de la Empresa: " . $_POST['DireccionEmpresa'] . "<br>";
    echo "Departamento de la Empresa: " . $_POST['departamentoEmpresa'] . "<br>";
    echo "Cargo en la Empresa: " . $_POST['cargoEmpresa'] . "<br>";
    echo "Años de Antigüedad: " . $_POST['anioEmpresa'] . "<br>";
    echo "Ingresos Mensuales: " . $_POST['ingresos'] . "<br>";
    echo "Monto Total de Deudas: " . $_POST['MontoDeuda'] . "<br>";
    echo "Marca del Auto: " . $_POST['marcaAuto'] . "<br>";
    echo "Modelo del Auto: " . $_POST['Modelo'] . "<br>";
    echo "Valor de Compra del Auto: " . $_POST['valorAuto'] . "<br>";
    echo "Nombre de la Primera Referencia: " . $_POST['nombreReferencia_a'] . "<br>";
    echo "Relación con la Primera Referencia: " . $_POST['relacionaReferencia_a'] . "<br>";
    echo "Teléfono de la Primera Referencia: " . $_POST['telefonoreferencia_a'] . "<br>";
    echo "Nombre de la Segunda Referencia: " . $_POST['nombreReferencia_b'] . "<br>";
    echo "Relación con la Segunda Referencia: " . $_POST['relacionaReferencia_b'] . "<br>";
    echo "Teléfono de la Segunda Referencia: " . $_POST['telefonoreferencia_b'] . "<br>";
    echo "Términos Aceptados: " . (isset($_POST['terms']) ? "Sí" : "No") . "<br>";

    // Para los campos checkbox y radios, que pueden tener múltiples valores o no ser enviados si están vacíos
    echo "Bancos Seleccionados: ";
    if (isset($_POST['bancoJSON'])) {
        foreach ($_POST['bancoJSON'] as $banco) {
            echo $banco . ", ";
        }
    }
    echo "<br>";

    echo "Tipo de Cuentas: ";
    if (isset($_POST['tipoCuenta'])) {
        foreach ($_POST['tipoCuenta'] as $cuenta) {
            echo $cuenta . ", ";
        }
    }
    echo "<br>";

    echo "Tarjeta de Crédito: " . (isset($_POST['tarjetaCredito']) ? $_POST['tarjetaCredito'] : "No especificado") . "<br>";

    echo "</pre>";
}
