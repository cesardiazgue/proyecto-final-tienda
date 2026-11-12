<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Favoritos - <?php echo $titulo; ?></title>
    <!-- Ícono de la pestaña -->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS del template (incluye Bootstrap) -->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand fw-bold" href="index.php">Mis Favoritos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link <?php if ($pagina == "inicio") echo "active"; ?>" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($pagina == "catalogo") echo "active"; ?>" href="catalogo.php">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($pagina == "contacto") echo "active"; ?>" href="contacto.php">Contacto</a></li>

                    <!-- Menú desplegable de la cuenta -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if ($pagina == "perfil" || $pagina == "login" || $pagina == "registro" || $pagina == "admin") echo "active"; ?>"
                           href="#" role="button" data-bs-toggle="dropdown">Mi cuenta</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="perfil.php">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="login.php">Iniciar sesión</a></li>
                            <li><a class="dropdown-item" href="registro.php">Crear cuenta</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="admin.php">Administrador</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Botón del carrito -->
                <a class="btn <?php if ($pagina == "carrito") echo "btn-dark"; else echo "btn-outline-dark"; ?>" href="carrito.php">
                    <i class="bi-cart-fill me-1"></i>
                    Carrito
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido de cada página -->
    <main class="flex-grow-1">