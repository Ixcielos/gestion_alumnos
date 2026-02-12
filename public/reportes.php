<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../src/controllers/ReporteController.php';

// Obtener acción
$action = $_GET['action'] ?? 'index';

// Instanciar controlador
$controller = new ReporteController();

// Ejecutar acción
switch ($action) {
    case 'excel':
        $controller->generarExcel();
        break;

    case 'pdf':
        $controller->generarPDF();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
