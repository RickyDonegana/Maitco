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
    rol_id INT NOT NULL,
    correo_electronico VARCHAR(255) NOT NULL UNIQUE,
    registro_completo TINYINT(1) NOT NULL DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles (id_rol)
);

-- Tabla de Estados de Proyectos
CREATE TABLE IF NOT EXISTS estados_proyectos (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    nombre_estado VARCHAR(50) NOT NULL
);

-- Insertar estados iniciales de proyectos
INSERT INTO estados_proyectos (nombre_estado) VALUES
    ('Inicio'),
    ('Planificación'),
    ('Ejecución'),
    ('Supervisión'),
    ('Cierre'),
    ('Finalizado');

-- Tabla de Proyectos
CREATE TABLE IF NOT EXISTS proyectos (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_proyecto VARCHAR(255) NOT NULL,
    descripcion TEXT,
    cliente VARCHAR(100),
    desarrollador VARCHAR(100),
    fecha_inicio DATE NOT NULL,
    fecha_entrega_estimada DATE NOT NULL,
    estado INT NOT NULL,
    FOREIGN KEY (estado) REFERENCES estados_proyectos (id_estado)
);

-- Tabla de Estados de Tareas
CREATE TABLE IF NOT EXISTS estados_tarea (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    nombre_estado VARCHAR(50) NOT NULL
);

-- Insertar estados iniciales de tareas
INSERT INTO estados_tarea (nombre_estado) VALUES
    ('Pendiente'),
    ('En Progreso'),
    ('Completada');

-- Tabla de Tareas
CREATE TABLE IF NOT EXISTS tareas (
    id_tarea INT AUTO_INCREMENT PRIMARY KEY,
    id_proyecto INT NOT NULL,
    nombre_tarea VARCHAR(255) NOT NULL,
    descripcion_tarea TEXT,
    estado_id INT NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    asignada_a INT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proyecto) REFERENCES proyectos (id_proyecto),
    FOREIGN KEY (estado_id) REFERENCES estados_tarea (id_estado),
    FOREIGN KEY (asignada_a) REFERENCES usuarios (id_usuario)
);
