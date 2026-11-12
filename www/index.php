<?php
include "conexion.php";
$titulo = "Inicio";
$pagina = "inicio";
include "encabezado.php";

// 8 productos al azar para la portada
$sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 8";
$resultado = mysqli_query($conexion, $sql);
?>

<!-- Banner -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Mis Favoritos</h1>
            <p class="lead fw-normal text-white-50 mb-0">Los productos que más me gustan, en un solo lugar</p>
        </div>
    </div>
</header>

<!-- Productos destacados -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Foto del producto -->
                        <img class="card-img-top p-3" src="img/<?php echo $fila["foto"]; ?>"
                             style="height: 200px; object-fit: contain;"
                             alt="<?php echo htmlspecialchars($fila["nombre"]); ?>">
                        <!-- Nombre y precio -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder"><?php echo htmlspecialchars($fila["nombre"]); ?></h5>
                                $<?php echo number_format($fila["precio"], 2); ?>
                            </div>
                        </div>
                        <!-- Botón -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="catalogo.php">Ver en catálogo</a></div>
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