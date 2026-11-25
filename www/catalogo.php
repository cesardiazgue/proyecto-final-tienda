<?php
session_start();
include "conexion.php";
$titulo = "Catálogo";
$pagina = "catalogo";

// Todos los productos, ordenados por nombre
$sql = "SELECT * FROM productos ORDER BY nombre";
$resultado = mysqli_query($conexion, $sql);
$total = mysqli_num_rows($resultado);

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">

        <h1 class="fw-bolder mb-1">Catálogo</h1>
        <p class="text-muted mb-5"><?php echo $total; ?> productos disponibles</p>

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">

            <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                <div class="col mb-5">
                    <div class="card h-100">

                        <!-- Etiqueta si ya no hay piezas -->
                        <?php if ($fila["cantidad_almacen"] == 0) { ?>
                            <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Agotado</div>
                        <?php } ?>

                        <!-- Foto (también es enlace al detalle) -->
                        <a href="producto.php?id=<?php echo $fila["id_producto"]; ?>">
                            <img class="card-img-top p-3" src="img/<?php echo $fila["foto"]; ?>"
                                 style="height: 200px; object-fit: contain;"
                                 alt="<?php echo htmlspecialchars($fila["nombre"]); ?>">
                        </a>

                        <!-- Nombre, precio y existencias -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder"><?php echo htmlspecialchars($fila["nombre"]); ?></h5>
                                $<?php echo number_format($fila["precio"], 2); ?>
                                <div class="small text-muted mt-1"><?php echo $fila["cantidad_almacen"]; ?> en existencia</div>
                            </div>
                        </div>

                        <!-- Botón -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="producto.php?id=<?php echo $fila["id_producto"]; ?>">Ver detalle</a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>