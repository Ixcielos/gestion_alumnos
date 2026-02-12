<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../src/controllers/NotaController.php';

// Obtener acción
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Instanciar controlador
$controller = new NotaController();

// Ejecutar acción
switch ($action) {
    case 'crear':
        $controller->crear();
        break;

    case 'editar':
        if ($id) {
            $controller->editar($id);
        } else {
            header('Location: notas.php');
        }
        break;

    case 'eliminar':
        if ($id) {
            $controller->eliminar($id);
        } else {
            header('Location: notas.php');
        }
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
