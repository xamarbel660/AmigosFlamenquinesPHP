<?php
require_once("config.php");
$conexion = obtenerConexion();

// Recuperar parámetro
$nombre_cliente = $_GET['txtNombreCliente'];

// No validamos, suponemos que la entrada de datos es correcta

$sql = "SELECT o.*, c.name FROM client_order o, client c 
WHERE o.id_client = c.id_client 
AND c.name LIKE '%$nombre_cliente%';";

$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) { // Mostrar tabla de datos, hay datos

    $mensaje = "<h2 class='text-center'>Pedidos localizados</h2>";
    $mensaje .= "<table class='table'>";
    $mensaje .= "<thead><tr><th>Cliente</th><th>FECHA RESERVA</th><th>COMENTARIO</th><th>ESTADO</th><th>PRECIO TOTAL</th></tr></thead>";
    $mensaje .= "<tbody>";

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $mensaje .= "<tr>";
        $mensaje .= "<td>" . $fila['name'] . "</td>";
        // 1. Creamos un objeto de Fecha con el valor que viene de la base de datos
        $fecha_pedido = new DateTime($fila['client_order_date']);
        // 2. Le damos el formato 'día/mes/Año' que quieres
        $mensaje .= "<td>" . $fecha_pedido->format('d/m/Y') . "</td>";
        // $mensaje .= "<td>" . $fila['client_order_date'] . "</td>";
        $mensaje .= "<td>" . $fila['comment'] . "</td>";
        $mensaje .= "<td>" . (($fila['is_completed'] == 0) ? "En proceso" : "Finalizado") . "</td>";
        $mensaje .= "<td>" . $fila['total_price'] . "</td>";

        // Formulario en la celda para procesar borrado del registro
        // input hidden para enviar idcomponente a borrar
        $mensaje .= "<td><form class='d-inline me-1' action='editar_pedido.php' method='post'>";
        $mensaje .= "<input type='hidden' name='componente' value='" . htmlspecialchars(json_encode($fila), ENT_QUOTES) . "' />";
        $mensaje .= "<button name='Editar' class='btn btn-primary'><i class='bi bi-pencil-square'></i></button></form>";

        $mensaje .= "<form class='d-inline' action='proceso_borrar_pedido.php' method='post'>";
        $mensaje .= "<input type='hidden' name='idpedido' value='" . $fila['id_client_order']  . "' />";
        $mensaje .= "<button name='Borrar' class='btn btn-danger'><i class='bi bi-trash'></i></button></form>";

        $mensaje .= "</tr>";
    }

    $mensaje .= "</tbody></table>";
} else { // No hay datos
    $mensaje = "<h2 class='text-center mt-5'>No hay pedidos con nombre $nombre_cliente</h2>";
}

while ($fila = mysqli_fetch_assoc($resultado)) {
    echo $fila;
}

// Insertamos cabecera
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $mensaje;

?>
</body>

</html>