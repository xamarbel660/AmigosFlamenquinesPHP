<?php
require_once("config.php");
$conexion = obtenerConexion();

// Recuperar parámetros
$nombre = trim($_POST['nombreCliente']);
$age = intval(trim($_POST['edadCliente']));
$isVip = intval(trim($_POST['radioVIP']));
$dateCreatedAccount = date('Y-m-d');
$idCategory = intval(trim($_POST['lstCategorias']));



// No validamos, suponemos que la entrada de datos es correcta

// Definir insert
// El campo is_completed se pone a 0 por defecto, porque cuando se crea el pedido, no está completado
$sql = "INSERT INTO client(name, age, is_vip, date_created_account, id_category) 
                VALUES ('$nombre', $age, $isVip, '$dateCreatedAccount', $idCategory);";

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si hay error y almacenar mensaje
if (mysqli_errno($conexion) != 0) {
    $numerror = mysqli_errno($conexion);
    $descrerror = mysqli_error($conexion);
    $mensaje =  "<h2 class='text-center mt-5'>Se ha producido un error numero $numerror que corresponde a: $descrerror </h2>";
} else {
    $mensaje =  "<h2 class='text-center mt-5'>Cliente añadido</h2>"; 
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