<?php
require_once("config.php");

$conexion = obtenerConexion();

$sql = "SELECT idtipo,tipo FROM tipo ORDER BY idtipo ASC;";

$resultado = mysqli_query($conexion, $sql);

$options = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    // $tipos[] = $fila; // Insertar una fila al final
    $options .= " <option value='" . $fila["idtipo"] . "'>" . $fila["tipo"] . "</option>";
}

include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="listado_componentes.php" method="get">
            <fieldset>
                <!-- Form Name -->
					<legend>Listado de tipos por componentes</legend>

					<div class="form-group">
						<label class="col-xs-4 control-label" for="lstTipoDeComponente">Tipo</label>
						<div class="col-xs-4">
							<input type="text" name="inpTipoDeComponente" id="inpTipoDeComponente"></input>
						</div>
					</div>
                <!-- Button -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarBuscarComponentesTipo"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarBuscarComponentesTipo" name="btnAceptarBuscarComponentesTipo" class="btn btn-primary" value="Aceptar" />
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</div>
</body>

</html>