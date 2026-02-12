<?php
/**
 * Constantes del sistema
 */

// Rutas del proyecto
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');
define('SRC_PATH', BASE_PATH . '/src');
define('CONFIG_PATH', BASE_PATH . '/config');

// URLs base
define('BASE_URL', '/php/gestion_alumnos/public');

// Validación de notas
define('NOTA_MIN', 0);
define('NOTA_MAX', 10);

// Rangos de calificación cualitativa
define('RANGO_SUSPENSO', 4.99);
define('RANGO_BIEN', 6.99);
define('RANGO_NOTABLE', 8.99);
define('RANGO_SOBRESALIENTE', 10);

// Mensajes del sistema
define('MSG_ALUMNO_CREADO', 'Alumno registrado exitosamente.');
define('MSG_ALUMNO_ACTUALIZADO', 'Alumno actualizado exitosamente.');
define('MSG_ALUMNO_ELIMINADO', 'Alumno eliminado exitosamente.');
define('MSG_NOTA_CREADA', 'Nota registrada exitosamente.');
define('MSG_NOTA_ACTUALIZADA', 'Nota actualizada exitosamente.');
define('MSG_NOTA_ELIMINADA', 'Nota eliminada exitosamente.');
define('MSG_ERROR_GENERICO', 'Ha ocurrido un error. Por favor, intente nuevamente.');
define('MSG_NOTA_INVALIDA', 'La nota debe estar entre 0 y 10.');

// Configuración de paginación
define('REGISTROS_POR_PAGINA', 10);
