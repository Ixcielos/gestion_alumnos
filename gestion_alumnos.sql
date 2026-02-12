-- Crear base de datos
CREATE DATABASE IF NOT EXISTS gestion_alumnos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_alumnos;

-- Tabla Alumno
CREATE TABLE IF NOT EXISTS alumno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_apellido (apellido),
    INDEX idx_correo (correo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Nota
CREATE TABLE IF NOT EXISTS nota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    valor DECIMAL(4,2) NOT NULL CHECK (valor >= 0 AND valor <= 10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (alumno_id) REFERENCES alumno(id) ON DELETE CASCADE,
    INDEX idx_alumno_id (alumno_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar alumnos de prueba
INSERT INTO alumno (nombre, apellido, correo) VALUES
('Juan', 'Pérez', 'juan.perez@example.com'),
('María', 'Gómez', 'maria.gomez@example.com'),
('Carlos', 'Ramírez', 'carlos.ramirez@example.com'),
('Ana', 'López', 'ana.lopez@example.com'),
('Pedro', 'Martínez', 'pedro.martinez@example.com');

-- Insertar notas de prueba
INSERT INTO nota (alumno_id, valor) VALUES
(1, 8.50),
(1, 7.00),
(1, 9.25),
(2, 5.75),
(2, 6.25),
(2, 6.00),
(3, 4.00),
(3, 3.50),
(3, 4.75),
(4, 9.50),
(4, 10.00),
(4, 9.75),
(5, 7.50),
(5, 8.00),
(5, 7.25);

