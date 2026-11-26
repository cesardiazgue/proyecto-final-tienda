<?php
session_start();
include "conexion.php";
$titulo = "Administrador";
$pagina = "admin";

// Solo administradores
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] != "admin") {
    header("Location: index.php");
    exit();
}

// Mensaje después de guardar un producto
$mensaje = "";
if (isset($_GET["msg"])) {
    if ($_GET["msg"] == "agregado") {
        $mensaje = "Producto agregado correctamente.";
    } else if ($_GET["msg"] == "modificado") {
        $mensaje = "Producto modificado correctamente.";
    }
}

// Inventario: todos los productos
$sql = "SELECT * FROM productos ORDER BY id_producto";
$inventario = mysqli_query($conexion, $sql);

// Historial: cada compra con el nombre del cliente y del producto
$sql = "SELECT historial_compras.id_compra, historial_compras.fecha, historial_compras.cantidad, historial_compras.precio,
               usuarios.nombre AS cliente, usuarios.correo,
               productos.nombre AS producto
        FROM historial_compras
        INNER JOIN usuarios ON historial_compras.id_usuario = usuarios.id_usuario
        INNER JOIN productos ON historial_compras.id_producto = productos.id_producto
        ORDER BY historial_compras.fecha DESC";
$historial = mysqli_query($conexion, $sql);

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">

        <h1 class="fw-bolder mb-4">Panel de administrador</h1>

        <?php if ($mensaje != "") { ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php } ?>

        <!-- ================= INVENTARIO ================= -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 fw-bold mb-0">Inventario <span class="badge bg-secondary"><?php echo mysqli_num_rows($inventario); ?></span></h2>
            <a href="producto_form.php" class="btn btn-dark"><i class="bi-plus-lg me-1"></i>Agregar producto</a>
        </div>

        <div class="table-responsive mb-5">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Fabricante</th>
                        <th>Origen</th>
                        <th>Precio</th>
                        <th>En almacén</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($p = mysqli_fetch_assoc($inventario)) { ?>
                        <tr>
                            <td><?php echo $p["id_producto"]; ?></td>
                            <td><img src="img/<?php echo $p["foto"]; ?>" width="50" height="50" style="object-fit: contain;" alt=""></td>
                            <td><?php echo htmlspecialchars($p["nombre"]); ?></td>
                            <td><?php echo htmlspecialchars($p["fabricante"]); ?></td>
                            <td><?php echo htmlspecialchars($p["origen"]); ?></td>
                            <td>$<?php echo number_format($p["precio"], 2); ?></td>
                            <td>
                                <?php if ($p["cantidad_almacen"] == 0) { ?>
                                    <span class="badge bg-danger">Agotado</span>
                                <?php } else if ($p["cantidad_almacen"] <= 5) { ?>
                                    <span class="badge bg-warning text-dark"><?php echo $p["cantidad_almacen"]; ?></span>
                                <?php } else { ?>
                                    <?php echo $p["cantidad_almacen"]; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="producto_form.php?id=<?php echo $p["id_producto"]; ?>" class="btn btn-sm btn-outline-dark">
                                    <i class="bi-pencil me-1"></i>Editar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- ================= HISTORIAL ================= -->
        <h2 class="h4 fw-bold mb-3">Historial de compras <span class="badge bg-secondary"><?php echo mysqli_num_rows($historial); ?></span></h2>

        <?php if (mysqli_num_rows($historial) == 0) { ?>
            <div class="alert alert-secondary">Todavía no hay compras.</div>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID compra</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($h = mysqli_fetch_assoc($historial)) { ?>
                            <tr>
                                <td><?php echo $h["id_compra"]; ?></td>
                                <td><?php echo date("d/m/Y H:i", strtotime($h["fecha"])); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($h["cliente"]); ?><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($h["correo"]); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($h["producto"]); ?></td>
                                <td><?php echo $h["cantidad"]; ?></td>
                                <td>$<?php echo number_format($h["precio"], 2); ?></td>
                                <td class="fw-bold">$<?php echo number_format($h["precio"] * $h["cantidad"], 2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>