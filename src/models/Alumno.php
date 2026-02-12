<?php
require_once __DIR__ . '/../../config/database.php';

/**
 * Modelo Alumno - Gestión de operaciones CRUD para alumnos
 */
class Alumno
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtener todos los alumnos
     * @return array
     */
    public function getAll()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM alumno ORDER BY apellido, nombre");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener alumno por ID
     * @param int $id
     * @return array|false
     */
    public function getById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM alumno WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en getById: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear nuevo alumno
     * @param array $data
     * @return bool|int ID del alumno creado o false
     */
    public function create($data)
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO alumno (nombre, apellido, correo) VALUES (?, ?, ?)"
            );
            $stmt->execute([
                $data['nombre'],
                $data['apellido'],
                $data['correo']
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en create: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar alumno
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        try {
            $stmt = $this->db->prepare(
                "UPDATE alumno SET nombre = ?, apellido = ?, correo = ? WHERE id = ?"
            );
            return $stmt->execute([
                $data['nombre'],
                $data['apellido'],
                $data['correo'],
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Error en update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar alumno
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM alumno WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error en delete: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener alumno con sus notas
     * @param int $id
     * @return array|false Array con datos del alumno y sus notas, o false si no existe o hay error
     */
    public function getWithNotas($id)
    {
        try {
            // Obtener datos del alumno
            $alumno = $this->getById($id);
            if (!$alumno) {
                return false;
            }

            // Obtener notas del alumno
            $stmt = $this->db->prepare("SELECT * FROM nota WHERE alumno_id = ? ORDER BY id DESC");
            $stmt->execute([$id]);
            $alumno['notas'] = $stmt->fetchAll();

            return $alumno;
        } catch (PDOException $e) {
            error_log("Error en getWithNotas: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si existe un correo
     * @param string $correo
     * @param int|null $excludeId ID a excluir de la búsqueda (para edición)
     * @return bool
     */
    public function existeCorreo($correo, $excludeId = null)
    {
        try {
            if ($excludeId) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM alumno WHERE correo = ? AND id != ?");
                $stmt->execute([$correo, $excludeId]);
            } else {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM alumno WHERE correo = ?");
                $stmt->execute([$correo]);
            }
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error en existeCorreo: " . $e->getMessage());
            return false;
        }
    }
}
