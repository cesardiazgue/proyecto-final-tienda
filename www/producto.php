<?php
session_start();
include "conexion.php";
$pagina = "catalogo";

// Si no viene un id en la URL, regresar al catálogo
if (!isset($_GET["id"])) {
    header("Location: catalogo.php");
    exit();
}

// (int) convierte el id en número entero
$id = (int) $_GET["id"];

$sql = "SELECT * FROM productos WHERE id_producto = $id";
$resultado = mysqli_query($conexion, $sql);

// Si el producto no existe, regresar al catálogo
if (mysqli_num_rows($resultado) == 0) {
    header("Location: catalogo.php");
    exit();
}

$producto = mysqli_fetch_assoc($resultado);
$titulo = $producto["nombre"];

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">

        <a href="catalogo.php" class="btn btn-link text-dark px-0 mb-4"><i class="bi-arrow-left me-1"></i>Volver al catálogo</a>

        <div class="row gx-4 gx-lg-5 align-items-center">

            <!-- Foto -->
            <div class="col-md-6 mb-4 mb-md-0">
                <img class="img-fluid w-100 p-4 border rounded" src="img/<?php echo $producto["foto"]; ?>"
                     style="height: 400px; object-fit: contain;"
                     alt="<?php echo htmlspecialchars($producto["nombre"]); ?>">
            </div>

            <!-- Información -->
            <div class="col-md-6">
                <div class="small text-muted mb-1">
                    <?php echo htmlspecialchars($producto["fabricante"]); ?> · <?php echo htmlspecialchars($producto["origen"]); ?>
                </div>
                <h1 class="display-5 fw-bolder"><?php echo htmlspecialchars($producto["nombre"]); ?></h1>
                <div class="fs-4 mb-4">$<?php echo number_format($producto["precio"], 2); ?></div>
                <p class="lead"><?php echo htmlspecialchars($producto["descripcion"]); ?></p>

                <dl class="row mb-4">
                    <dt class="col-5">Fabricante</dt>
                    <dd class="col-7"><?php echo htmlspecialchars($producto["fabricante"]); ?></dd>
                    <dt class="col-5">País de origen</dt>
                    <dd class="col-7"><?php echo htmlspecialchars($producto["origen"]); ?></dd>
                    <dt class="col-5">En existencia</dt>
                    <dd class="col-7"><?php echo $producto["cantidad_almacen"]; ?> piezas</dd>
                </dl>

                <?php if ($producto["cantidad_almacen"] == 0) { ?>

                    <!-- Sin piezas -->
                    <button class="btn btn-secondary" disabled>Agotado</button>

                <?php } else if (!isset($_SESSION["id_usuario"])) { ?>

                    <!-- Sin sesión -->
                    <div class="alert alert-secondary mb-0">
                        <a href="login.php" class="alert-link">Inicia sesión</a> para agregar este producto a tu carrito.
                    </div>

                <?php } else { ?>

                    <!-- Con sesión: formulario para agregar al carrito -->
                    <form method="post" action="agregar_carrito.php" class="d-flex">
                        <input type="hidden" name="id_producto" value="<?php echo $producto["id_producto"]; ?>">
                        <input type="number" class="form-control text-center me-3" style="max-width: 5rem"
                               name="cantidad" value="1" min="1" max="<?php echo $producto["cantidad_almacen"]; ?>">
                        <button type="submit" class="btn btn-outline-dark flex-shrink-0">
                            <i class="bi-cart-fill me-1"></i>Agregar al carrito
                        </button>
                    </form>

                <?php } ?>
            </div>

        </div>
    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>