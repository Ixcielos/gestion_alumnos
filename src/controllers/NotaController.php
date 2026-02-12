<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Alumno.php';

/**
 * Controlador de Notas
 */
class NotaController
{
    private $model;
    private $alumnoModel;
    private $mensaje = '';
    private $tipoMensaje = '';

    public function __construct()
    {
        $this->model = new Nota();
        $this->alumnoModel = new Alumno();
    }

    /**
     * Mostrar listado de notas con promedios
     */
    public function index()
    {
        $alumnos = $this->model->getAllAlumnosConPromedio();
        require_once __DIR__ . '/../views/notas/index.php';
    }

    /**
     * Mostrar formulario y procesar creación de nota
     */
    public function crear()
    {
        $alumnos = $this->alumnoModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos
            $errores = $this->validarDatos($_POST);

            if (empty($errores)) {
                // Crear nota
                $resultado = $this->model->create($_POST);

                if ($resultado) {
                    $_SESSION['mensaje'] = MSG_NOTA_CREADA;
                    $_SESSION['tipo_mensaje'] = 'success';
                    header('Location: notas.php');
                    exit;
                } else {
                    $this->mensaje = MSG_ERROR_GENERICO;
                    $this->tipoMensaje = 'danger';
                }
            } else {
                $this->mensaje = implode('<br>', $errores);
                $this->tipoMensaje = 'danger';
            }
        }

        require_once __DIR__ . '/../views/notas/crear.php';
    }

    /**
     * Mostrar formulario y procesar edición de nota
     */
    public function editar($id)
    {
        $nota = $this->model->getById($id);

        if (!$nota) {
            $_SESSION['mensaje'] = 'Nota no encontrada.';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: notas.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos
            $errores = $this->validarDatos($_POST, false);

            if (empty($errores)) {
                // Actualizar nota
                $resultado = $this->model->update($id, $_POST);

                if ($resultado) {
                    $_SESSION['mensaje'] = MSG_NOTA_ACTUALIZADA;
                    $_SESSION['tipo_mensaje'] = 'success';
                    header('Location: notas.php');
                    exit;
                } else {
                    $this->mensaje = MSG_ERROR_GENERICO;
                    $this->tipoMensaje = 'danger';
                }
            } else {
                $this->mensaje = implode('<br>', $errores);
                $this->tipoMensaje = 'danger';
            }
        }

        require_once __DIR__ . '/../views/notas/editar.php';
    }

    /**
     * Eliminar nota
     */
    public function eliminar($id)
    {
        $resultado = $this->model->delete($id);

        if ($resultado) {
            $_SESSION['mensaje'] = MSG_NOTA_ELIMINADA;
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = MSG_ERROR_GENERICO;
            $_SESSION['tipo_mensaje'] = 'danger';
        }

        header('Location: notas.php');
        exit;
    }

    /**
     * Validar datos del formulario
     */
    private function validarDatos($data, $validarAlumno = true)
    {
        $errores = [];

        if ($validarAlumno) {
            if (empty($data['alumno_id'])) {
                $errores[] = 'Debe seleccionar un alumno.';
            }
        }

        // Validar nota - solo un error a la vez
        if (!isset($data['valor']) || $data['valor'] === '') {
            $errores[] = 'La nota es obligatoria.';
        } elseif (!is_numeric($data['valor'])) {
            $errores[] = 'La nota debe ser un número válido.';
        } elseif ($data['valor'] < NOTA_MIN || $data['valor'] > NOTA_MAX) {
            $errores[] = 'La nota debe estar entre ' . NOTA_MIN . ' y ' . NOTA_MAX . '.';
        }

        return $errores;
    }

    /**
     * Obtener mensaje
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Obtener tipo de mensaje
     */
    public function getTipoMensaje()
    {
        return $this->tipoMensaje;
    }
}
