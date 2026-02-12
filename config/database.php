<?php
/**
 * Clase Database - Gestión de conexión a base de datos usando PDO
 * Implementa patrón Singleton para evitar múltiples conexiones
 */
class Database
{
    private static $instance = null;
    private $connection;

    // Configuración de la base de datos
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "gestion_alumnos";
    private $charset = "utf8mb4";

    /**
     * Constructor privado para implementar Singleton
     */
    private function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Obtener instancia única de la conexión
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Obtener la conexión PDO
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Prevenir clonación del objeto
     */
    private function __clone()
    {
    }

    /**
     * Prevenir deserialización del objeto
     */
    public function __wakeup()
    {
        throw new Exception("No se puede deserializar un singleton.");
    }
}
