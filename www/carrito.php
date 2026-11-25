<?php
session_start();
include "conexion.php";
$titulo = "Carrito";
$pagina = "carrito";

// Solo usuarios con sesión iniciada
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

// Mensaje según la acción que se acaba de hacer
$mensaje = "";
$tipo = "";
if (isset($_GET["msg"])) {
    if ($_GET["msg"] == "agregado") {
        $mensaje = "Producto agregado al carrito.";
        $tipo = "success";
    } else if ($_GET["msg"] == "actualizado") {
        $mensaje = "Cantidad actualizada.";
        $tipo = "success";
    } else if ($_GET["msg"] == "eliminado") {
        $mensaje = "Producto eliminado del carrito.";
        $tipo = "secondary";
    } else if ($_GET["msg"] == "compra") {
        $mensaje = "¡Compra realizada con éxito! Gracias por comprar en Mis Favoritos.";
        $tipo = "success";
    } else if ($_GET["msg"] == "agotado") {
        $mensaje = "Ese producto está agotado.";
        $tipo = "danger";
    } else if ($_GET["msg"] == "sin_existencia") {
        $mensaje = "No hay piezas suficientes en almacén de algún producto. Revisa las cantidades.";
        $tipo = "danger";
    }
}

// Productos del carrito unidos con su información
$sql = "SELECT carrito.id_carrito, carrito.cantidad,
               productos.nombre, productos.foto, productos.precio, productos.cantidad_almacen
        FROM carrito
        INNER JOIN productos ON carrito.id_producto = productos.id_producto
        WHERE carrito.id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $sql);

$total = 0;

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">

        <h1 class="fw-bolder mb-4">Carrito de compras</h1>

        <?php if ($mensaje != "") { ?>
            <div class="alert alert-<?php echo $tipo; ?>"><?php echo $mensaje; ?></div>
        <?php } ?>

        <?php if (mysqli_num_rows($resultado) == 0) { ?>

            <!-- Carrito vacío -->
            <div class="text-center py-5">
                <i class="bi-cart display-1 text-muted"></i>
                <p class="lead mt-3">Tu carrito está vacío.</p>
                <a href="catalogo.php" class="btn btn-dark">Ir al catálogo</a>
            </div>

        <?php } else { ?>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = mysqli_fetch_assoc($resultado)) {
                            $subtotal = $fila["precio"] * $fila["cantidad"];
                            $total = $total + $subtotal;
                        ?>
                            <tr>
                                <!-- Foto y nombre -->
                                <td>
                                    <img src="img/<?php echo $fila["foto"]; ?>" width="60" height="60"
                                         style="object-fit: contain;" class="me-2" alt="">
                                    <?php echo htmlspecialchars($fila["nombre"]); ?>
                                </td>

                                <td>$<?php echo number_format($fila["precio"], 2); ?></td>

                                <!-- Modificar cantidad -->
                                <td>
                                    <form method="post" action="actualizar_carrito.php" class="d-flex">
                                        <input type="hidden" name="id_carrito" value="<?php echo $fila["id_carrito"]; ?>">
                                        <input type="number" name="cantidad" class="form-control form-control-sm text-center me-2"
                                               style="width: 4.5rem" value="<?php echo $fila["cantidad"]; ?>"
                                               min="1" max="<?php echo $fila["cantidad_almacen"]; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-dark" title="Actualizar">
                                            <i class="bi-arrow-repeat"></i>
                                        </button>
                                    </form>
                                </td>

                                <td class="fw-bold">$<?php echo number_format($subtotal, 2); ?></td>

                                <!-- Borrar -->
                                <td>
                                    <form method="post" action="eliminar_carrito.php">
                                        <input type="hidden" name="id_carrito" value="<?php echo $fila["id_carrito"]; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Total y botones -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4">
                <a href="catalogo.php" class="btn btn-link text-dark px-0 mb-3 mb-md-0">
                    <i class="bi-arrow-left me-1"></i>Seguir comprando
                </a>
                <div class="text-md-end">
                    <div class="fs-4 mb-2">Total: <strong>$<?php echo number_format($total, 2); ?></strong></div>
                    <form method="post" action="finalizar_compra.php">
                        <button type="submit" class="btn btn-dark btn-lg">Finalizar compra</button>
                    </form>
                </div>
            </div>

        <?php } ?>

    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>