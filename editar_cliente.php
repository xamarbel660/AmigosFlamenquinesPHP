<?php
require_once("config.php");
$conexion = obtenerConexion();

$idCliente = trim($_POST['idCliente']);
$nombre = trim($_POST['nombreCliente']);
$age = intval(trim($_POST['edadCliente']));
$isVip = intval(trim($_POST['radioVIP']));


// No validamos, suponemos que la entrada de datos es correcta

$sql = "UPDATE client 
        SET name = '$nombre',
        age = $age,
        is_vip = $isVip
        WHERE id_client = $idCliente
;";
// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si hay error y almacenar mensaje
if (mysqli_errno($conexion) != 0) {
    $numerror = mysqli_errno($conexion);
    $descrerror = mysqli_error($conexion);
    $mensaje =  "<h2 class='text-center mt-5'>Se ha producido un error numero $numerror que corresponde a: $descrerror </h2>";
} else {
    $mensaje =  "<h2 class='text-center mt-5'>Cliente editado</h2>"; 
}
// Redireccionar tras 5 segundos al index.
// Siempre debe ir antes de DOCTYPE
header( "refresh:5;url=index.php" );

// Aquí empieza la página
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $mensaje;

?>

    
</body>

</html>