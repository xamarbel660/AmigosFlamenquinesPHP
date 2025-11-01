<?php
// Parámetros de conexión
define('DB_HOST', 'db');
define('DB_USER', 'root');
define('DB_PASS', 'test');
define('DB_NAME', 'amigosFlamenquines');
define('DB_PORT', '3306');

function obtenerConexion() {
    // Activar excepciones en errores mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Establecer conexión y opciones de mysql
        // Importante, ajustar los siguientes parámetros
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        $conexion->set_charset("utf8");

        return $conexion;
    } catch (mysqli_sql_exception $e) {
        // Error en la base de datos
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}
// funcion para cerrar la conexion
function cerrarConexion($conexion) {
    if ($conexion instanceof mysqli) {
        $conexion->close();
    }
}