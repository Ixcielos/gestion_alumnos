<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../models/Alumno.php';

/**
 * Controlador de Alumnos
 */
class AlumnoController
{
    private $model;
    private $mensaje = '';
    private $tipoMensaje = '';

    public function __construct()
    {
        $this->model = new Alumno();
    }

    /**
     * Mostrar listado de alumnos
     */
    public function index()
    {
        $alumnos = $this->model->getAll();
        require_once __DIR__ . '/../views/alumnos/index.php';
    }

    /**
     * Mostrar formulario y procesar creación de alumno
     */
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos
            $errores = $this->validarDatos($_POST);

            if (empty($errores)) {
                // Verificar si el correo ya existe
                if ($this->model->existeCorreo($_POST['correo'])) {
                    $this->mensaje = 'El correo electrónico ya está registrado.';
                    $this->tipoMensaje = 'danger';
                } else {
                    // Crear alumno
                    $resultado = $this->model->create($_POST);

                    if ($resultado) {
                        $_SESSION['mensaje'] = MSG_ALUMNO_CREADO;
                        $_SESSION['tipo_mensaje'] = 'success';
                        header('Location: alumnos.php');
                        exit;
                    } else {
                        $this->mensaje = MSG_ERROR_GENERICO;
                        $this->tipoMensaje = 'danger';
                    }
                }
            } else {
                $this->mensaje = implode('<br>', $errores);
                $this->tipoMensaje = 'danger';
            }
        }

        require_once __DIR__ . '/../views/alumnos/crear.php';
    }

    /**
     * Mostrar formulario y procesar edición de alumno
     */
    public function editar($id)
    {
        $alumno = $this->model->getById($id);

        if (!$alumno) {
            $_SESSION['mensaje'] = 'Alumno no encontrado.';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: alumnos.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos
            $errores = $this->validarDatos($_POST);

            if (empty($errores)) {
                // Verificar si el correo ya existe (excluyendo el alumno actual)
                if ($this->model->existeCorreo($_POST['correo'], $id)) {
                    $this->mensaje = 'El correo electrónico ya está registrado.';
                    $this->tipoMensaje = 'danger';
                } else {
                    // Actualizar alumno
                    $resultado = $this->model->update($id, $_POST);

                    if ($resultado) {
                        $_SESSION['mensaje'] = MSG_ALUMNO_ACTUALIZADO;
                        $_SESSION['tipo_mensaje'] = 'success';
                        header('Location: alumnos.php');
                        exit;
                    } else {
                        $this->mensaje = MSG_ERROR_GENERICO;
                        $this->tipoMensaje = 'danger';
                    }
                }
            } else {
                $this->mensaje = implode('<br>', $errores);
                $this->tipoMensaje = 'danger';
            }
        }

        require_once __DIR__ . '/../views/alumnos/editar.php';
    }

    /**
     * Eliminar alumno
     */
    public function eliminar($id)
    {
        $resultado = $this->model->delete($id);

        if ($resultado) {
            $_SESSION['mensaje'] = MSG_ALUMNO_ELIMINADO;
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = MSG_ERROR_GENERICO;
            $_SESSION['tipo_mensaje'] = 'danger';
        }

        header('Location: alumnos.php');
        exit;
    }

    /**
     * Validar datos del formulario
     */
    private function validarDatos($data)
    {
        $errores = [];

        if (empty($data['nombre'])) {
            $errores[] = 'El nombre es obligatorio.';
        } elseif (strlen($data['nombre']) > 50) {
            $errores[] = 'El nombre no puede exceder 50 caracteres.';
        }

        if (empty($data['apellido'])) {
            $errores[] = 'El apellido es obligatorio.';
        } elseif (strlen($data['apellido']) > 50) {
            $errores[] = 'El apellido no puede exceder 50 caracteres.';
        }

        if (empty($data['correo'])) {
            $errores[] = 'El correo electrónico es obligatorio.';
        } elseif (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no es válido.';
        } elseif (strlen($data['correo']) > 100) {
            $errores[] = 'El correo no puede exceder 100 caracteres.';
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
