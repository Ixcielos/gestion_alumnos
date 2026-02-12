<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($titulo) ? $titulo . ' - ' : ''; ?>Gestión de Alumnos
    </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/custom.css">

    <!-- Bootstrap Icons (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">
                <i class="bi bi-mortarboard-fill"></i> Gestión de Alumnos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"
                            href="<?php echo BASE_URL; ?>/index.php">
                            <i class="bi bi-house-fill"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'alumnos.php' ? 'active' : ''; ?>"
                            href="<?php echo BASE_URL; ?>/alumnos.php">
                            <i class="bi bi-people-fill"></i> Alumnos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'notas.php' ? 'active' : ''; ?>"
                            href="<?php echo BASE_URL; ?>/notas.php">
                            <i class="bi bi-journal-text"></i> Notas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reportes.php' ? 'active' : ''; ?>"
                            href="<?php echo BASE_URL; ?>/reportes.php">
                            <i class="bi bi-file-earmark-bar-graph"></i> Reportes
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">