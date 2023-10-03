-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS ssp_db;

-- Usar la base de datos
USE ssp_db;

-- Tabla de Roles
CREATE TABLE IF NOT EXISTS roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
);

-- Insertar roles iniciales
INSERT INTO roles (role_name) VALUES
    ('Cliente'),
    ('Desarrollador de sitios');

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_role ENUM('Cliente', 'Desarrollador de sitios') NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    registro_completo TINYINT(1) NOT NULL DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Proyectos
CREATE TABLE IF NOT EXISTS proyectos (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(255) NOT NULL,
    description TEXT,
    client VARCHAR(100),
    developer VARCHAR(100),
    start_date DATE NOT NULL,
    estimated_delivery_date DATE NOT NULL,
    estado VARCHAR(50) NOT NULL
);

-- Tabla de Etapas del Proyecto
CREATE TABLE IF NOT EXISTS etapas_proyecto (
    stage_id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    stage_name VARCHAR(255) NOT NULL,
    color VARCHAR(20) NOT NULL,
    FOREIGN KEY (project_id) REFERENCES proyectos (project_id)
);

-- Tabla de Cambios en el Proyecto
CREATE TABLE IF NOT EXISTS cambios_proyecto (
    change_id INT AUTO_INCREMENT PRIMARY KEY,
    stage_id INT NOT NULL,
    user_id INT NOT NULL,
    change_date DATETIME NOT NULL,
    change_description TEXT NOT NULL,
    FOREIGN KEY (stage_id) REFERENCES etapas_proyecto (stage_id),
    FOREIGN KEY (user_id) REFERENCES usuarios (user_id)
);