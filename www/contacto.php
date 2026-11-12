<?php
$titulo = "Contacto";
$pagina = "contacto";
include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h1 class="fw-bolder mb-4">Contacto</h1>

        <div class="row g-4">

            <!-- Datos de contacto -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-dark text-white">Información de contacto</div>
                    <div class="card-body">
                        <p><i class="bi-envelope-fill me-2"></i><strong>Correo:</strong> contacto@misfavoritos.com</p>
                        <p><i class="bi-telephone-fill me-2"></i><strong>Teléfono:</strong> 55 1234 5678</p>
                        <p><i class="bi-geo-alt-fill me-2"></i><strong>Dirección:</strong> Ciudad de México, México</p>
                        <p class="mb-0"><i class="bi-clock-fill me-2"></i><strong>Horario:</strong> Lunes a viernes de 9:00 a 18:00 h</p>
                    </div>
                </div>
            </div>

            <!-- Acerca del sitio -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-dark text-white">Acerca del sitio</div>
                    <div class="card-body">
                        <p>Mis Favoritos es una tienda en línea con 30 productos seleccionados: dulces, tecnología, moda y artículos para el hogar.</p>
                        <p>Desarrollada por Cesar Diaz como proyecto final de la materia Programación para Internet, Universidad Anáhuac Norte.</p>
                        <p class="mb-0"><strong>Tecnologías:</strong> HTML, Bootstrap 5, PHP, MySQL y Docker.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include "pie.php"; ?>