drop database if exists reservas;
create database reservas;
use reservas;
CREATE TABLE usuarios (
    idRayuela varchar(20) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    ps BLOB NOT NULL, -- Encriptar contraseñas,
    activo boolean default true,
    numReservas int not null default 0
);

insert into usuarios(idRayuela,nombre,ps, activo) values 
	('jperez1', 'Juan Perez', SHA2('jperez1', 512),1),  
    ('mgarcia2', 'Maria Garcia', SHA2('mgarcia2', 512),1), 
    ('clopez3', 'Carlos Lopez', SHA2('clopez3', 512),1),  
    ('afernandez4', 'Ana Fernandez', SHA2('afernandez4', 512),0), 
    ('lmartinez5', 'Luis Martinez', SHA2('lmartinez5', 512),0); 
    
CREATE TABLE recursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('aula', 'dispositivo') NOT NULL, -- Clasificación por tipo
    descripcion TEXT
);
INSERT INTO recursos (nombre, tipo, descripcion)
VALUES 
    ('Aula Audiovisuales', 'aula', 'Aula equipada con proyectores y sonido'),
    ('Aula de Informática', 'aula', 'Laboratorio con ordenadores para prácticas'),
    ('Salón de Actos', 'aula', 'Espacio para eventos y presentaciones'),
    ('Aula del Futuro', 'aula', 'Innovación tecnológica educativa'),
    ('Aula ATECA', 'aula', 'Aula Técnica para desarrollo de proyectos'),
    ('Impresora 3D Resina', 'dispositivo', 'Alta precisión para maquetas y prototipos'),
    ('Impresora 3D Filamento', 'dispositivo', 'Impresión con filamento plástico'),
    ('Kit de Robot', 'dispositivo', 'Robots para proyectos de programación'),
    ('Panel Digital Móvil', 'dispositivo', 'Pantalla táctil interactiva portátil');
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(20) NOT NULL,
    recurso INT NOT NULL,
    fecha DATE NOT NULL,
    hora int NOT NULL, -- 1 primera, 2 segunda, etc ...
    anulada boolean NOT NULL default false,
    FOREIGN KEY (usuario) REFERENCES usuarios(idRayuela) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (recurso) REFERENCES recursos(id) ON UPDATE CASCADE  ON DELETE RESTRICT,
    CONSTRAINT ck_horas_validas CHECK (hora >=1 AND hora<=6) -- Validación
);

DELIMITER $$

CREATE FUNCTION disponibilidad(pRecurso INT, pfecha DATE, pHora INT)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE disponibilidad TINYINT;

    -- Verificar si hay conflictos en la fecha y recurso especificados
    -- COUNT(*) = 0, compara el resultado de COUNT(*) con 0. True->1 false ->0
    SELECT 
        COUNT(*) = 0 INTO disponibilidad
    FROM 
        reservas
    WHERE 
        recurso = pRecurso AND fecha = pFecha and hora = pHora and anulada=false;

    RETURN disponibilidad; -- 1 si está disponible, 0 si no lo está
END$$

DELIMITER ;



   