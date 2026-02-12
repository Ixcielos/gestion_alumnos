<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../src/controllers/AlumnoController.php';

// Obtener acción
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Instanciar controlador
$controller = new AlumnoController();

// Ejecutar acción
switch ($action) {
    case 'crear':
        $controller->crear();
        break;

    case 'editar':
        if ($id) {
            $controller->editar($id);
        } else {
            header('Location: alumnos.php');
        }
        break;

    case 'eliminar':
        if ($id) {
            $controller->eliminar($id);
        } else {
            header('Location: alumnos.php');
        }
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
