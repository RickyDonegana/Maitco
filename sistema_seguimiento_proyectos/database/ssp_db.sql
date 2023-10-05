-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS ssp_db;

-- Usar la base de datos
USE ssp_db;

-- Tabla de Roles
CREATE TABLE IF NOT EXISTS roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL
);

-- Insertar roles iniciales
INSERT INTO roles (nombre_rol) VALUES
    ('Cliente'),
    ('Desarrollador de sitios');

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol_usuario ENUM('Cliente', 'Desarrollador de sitios') NOT NULL,
    correo_electronico VARCHAR(255) NOT NULL UNIQUE,
    registro_completo TINYINT(1) NOT NULL DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Proyectos
CREATE TABLE IF NOT EXISTS proyectos (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_proyecto VARCHAR(255) NOT NULL,
    descripcion TEXT,
    cliente VARCHAR(100),
    desarrollador VARCHAR(100),
    fecha_inicio DATE NOT NULL,
    fecha_entrega_estimada DATE NOT NULL,
    estado VARCHAR(50) NOT NULL
);

-- Tabla de Etapas del Proyecto
CREATE TABLE IF NOT EXISTS etapas_proyecto (
    id_etapa INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT NOT NULL,
    nombre_etapa VARCHAR(255) NOT NULL,
    color VARCHAR(20) NOT NULL,
    FOREIGN KEY (id_proyecto) REFERENCES proyectos (id_proyecto)
);

-- Tabla de Cambios en el Proyecto
CREATE TABLE IF NOT EXISTS cambios_proyecto (
    id_cambio INT AUTO_INCREMENT PRIMARY KEY,
    id_etapa INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_cambio DATETIME NOT NULL,
    descripcion_cambio TEXT NOT NULL,
    FOREIGN KEY (id_etapa) REFERENCES etapas_proyecto (id_etapa),
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
);
