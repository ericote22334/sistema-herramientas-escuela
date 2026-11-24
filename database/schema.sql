-- Base de datos del Sistema de Herramientas (E.E.S.T. Nº 1)
CREATE DATABASE IF NOT EXISTS herramientas_eest1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE herramientas_eest1;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  usuario VARCHAR(40) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('director','encargado') NOT NULL,
  turno ENUM('mañana','tarde','contraturno') NULL,
  horario VARCHAR(60) NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS herramientas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  categoria VARCHAR(50) NOT NULL DEFAULT 'General',
  stock_total INT NOT NULL DEFAULT 0 CHECK (stock_total >= 0),
  stock_disponible INT NOT NULL DEFAULT 0 CHECK (stock_disponible >= 0),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Un registro por retiro. Cuando se devuelve se completa fecha_devolucion (versión 2)
CREATE TABLE IF NOT EXISTS prestamos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  herramienta_id INT NOT NULL,
  cantidad INT NOT NULL DEFAULT 1,
  nombre VARCHAR(60) NOT NULL,
  apellido VARCHAR(60) NOT NULL,
  tipo_persona ENUM('alumno','profesor') NOT NULL,
  curso VARCHAR(20) NULL,
  encargado_retiro_id INT NOT NULL,
  encargado_devolucion_id INT NULL,
  fecha_retiro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_devolucion DATETIME NULL,
  FOREIGN KEY (herramienta_id) REFERENCES herramientas(id),
  FOREIGN KEY (encargado_retiro_id) REFERENCES usuarios(id),
  FOREIGN KEY (encargado_devolucion_id) REFERENCES usuarios(id)
);
