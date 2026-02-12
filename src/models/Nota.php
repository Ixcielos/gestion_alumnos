<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/constants.php';

/**
 * Modelo Nota - Gestión de operaciones CRUD para notas
 */
class Nota
{
    public $db; // Changed to public for view access

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Obtener todas las notas con información del alumno
     * @return array
     */
    public function getAll()
    {
        try {
            $stmt = $this->db->query(
                "SELECT n.*, a.nombre, a.apellido 
                 FROM nota n 
                 INNER JOIN alumno a ON n.alumno_id = a.id 
                 ORDER BY a.apellido, a.nombre, n.id DESC"
            );
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener nota por ID
     * @param int $id
     * @return array|false
     */
    public function getById($id)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT n.*, a.nombre, a.apellido 
                 FROM nota n 
                 INNER JOIN alumno a ON n.alumno_id = a.id 
                 WHERE n.id = ?"
            );
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en getById: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener notas de un alumno específico
     * @param int $alumno_id
     * @return array
     */
    public function getByAlumno($alumno_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM nota WHERE alumno_id = ? ORDER BY id DESC");
            $stmt->execute([$alumno_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en getByAlumno: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Crear nueva nota
     * @param array $data
     * @return bool|int ID de la nota creada o false
     */
    public function create($data)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO nota (alumno_id, valor) VALUES (?, ?)");
            $stmt->execute([
                $data['alumno_id'],
                $data['valor']
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en create: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar nota
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        try {
            $stmt = $this->db->prepare("UPDATE nota SET valor = ? WHERE id = ?");
            return $stmt->execute([
                $data['valor'],
                $id
            ]);
        } catch (PDOException $e) {
            error_log("Error en update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar nota
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM nota WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error en delete: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Calcular promedio de notas de un alumno
     * @param int $alumno_id
     * @return float|null
     */
    public function getPromedioByAlumno($alumno_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT AVG(valor) as promedio FROM nota WHERE alumno_id = ?");
            $stmt->execute([$alumno_id]);
            $result = $stmt->fetch();
            return $result['promedio'] !== null ? round($result['promedio'], 2) : null;
        } catch (PDOException $e) {
            error_log("Error en getPromedioByAlumno: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener resultado cualitativo según el promedio
     * @param float $promedio
     * @return string
     */
    public function getResultadoCualitativo($promedio)
    {
        if ($promedio === null) {
            return 'Sin notas';
        }

        if ($promedio <= RANGO_SUSPENSO) {
            return 'Suspenso';
        } elseif ($promedio <= RANGO_BIEN) {
            return 'Bien';
        } elseif ($promedio <= RANGO_NOTABLE) {
            return 'Notable';
        } else {
            return 'Sobresaliente';
        }
    }

    /**
     * Obtener clase CSS para el badge según el resultado
     * @param string $resultado
     * @return string
     */
    public function getBadgeClass($resultado)
    {
        switch ($resultado) {
            case 'Sobresaliente':
                return 'bg-success';
            case 'Notable':
                return 'bg-primary';
            case 'Bien':
                return 'bg-info';
            case 'Suspenso':
                return 'bg-danger';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Obtener todos los alumnos con sus promedios
     * @return array
     */
    public function getAllAlumnosConPromedio()
    {
        try {
            $stmt = $this->db->query(
                "SELECT a.id, a.nombre, a.apellido, a.correo, 
                        AVG(n.valor) as promedio,
                        COUNT(n.id) as total_notas
                 FROM alumno a
                 LEFT JOIN nota n ON a.id = n.alumno_id
                 GROUP BY a.id, a.nombre, a.apellido, a.correo
                 ORDER BY a.apellido, a.nombre"
            );

            $alumnos = $stmt->fetchAll();

            // Agregar resultado cualitativo a cada alumno
            foreach ($alumnos as &$alumno) {
                $alumno['promedio'] = $alumno['promedio'] !== null ? round($alumno['promedio'], 2) : null;
                $alumno['resultado'] = $this->getResultadoCualitativo($alumno['promedio']);
                $alumno['badge_class'] = $this->getBadgeClass($alumno['resultado']);
            }

            return $alumnos;
        } catch (PDOException $e) {
            error_log("Error en getAllAlumnosConPromedio: " . $e->getMessage());
            return [];
        }
    }
}
