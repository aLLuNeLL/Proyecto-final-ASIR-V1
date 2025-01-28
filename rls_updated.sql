-- Crear el esquema y usarlo
CREATE SCHEMA IF NOT EXISTS rls;
USE rls;

-- ----------------------------------------------------------------------
-- Tabla de Orden de Trabajo
CREATE TABLE IF NOT EXISTS `orden_trabajo` (
  `id_orden_trabajo` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  PRIMARY KEY (`id_orden_trabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------------------------------------------------
-- Tabla de Cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NOT NULL,
  `apellido_1` VARCHAR(60) NOT NULL,
  `apellido_2` VARCHAR(60) NOT NULL,
  `nombre_empresa` VARCHAR(60) NOT NULL,
  `direccion` VARCHAR(60) NOT NULL,
  `telefono` BIGINT(15) NOT NULL,
  `correo` VARCHAR(60) NOT NULL UNIQUE,
  `contraseña` VARCHAR(250) NOT NULL,
  `tipo` ENUM('cliente', 'admin') NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar datos iniciales en la tabla `cliente`


-- ----------------------------------------------------------------------
-- Tabla de Presupuesto
CREATE TABLE IF NOT EXISTS `presupuesto` (
  `id_presupuesto` INT(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` INT(11) DEFAULT NULL,
  `id_orden_trabajo` INT(11) DEFAULT NULL,
  `aceptado` TINYINT(1) NOT NULL DEFAULT 0,
  `descripcion` VARCHAR(500) NOT NULL,
  `fecha_peticion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` ENUM('denegado', 'aceptado','------') NOT NULL DEFAULT '------',
  PRIMARY KEY (`id_presupuesto`),
  CONSTRAINT `fk_presupuesto_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente`(`id_cliente`) ON DELETE CASCADE,
  CONSTRAINT `fk_presupuesto_orden_trabajo` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `orden_trabajo`(`id_orden_trabajo`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------------------------------------------------
-- Tabla de Factura
CREATE TABLE IF NOT EXISTS `factura` (
	`id_cliente` INT not null,
	`id_factura` INT(11) NOT NULL AUTO_INCREMENT,
	`id_presupuesto` INT(11) DEFAULT NULL,
	`total` DECIMAL(10,2) not null,
  
  PRIMARY KEY (`id_factura`),
  CONSTRAINT `fk_factura_presupuesto` FOREIGN KEY (`id_presupuesto`) REFERENCES `presupuesto`(`id_presupuesto`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `factura` MODIFY `total` DECIMAL(10, 2) NOT NULL;
-- ----------------------------------------------------------------------
-- Tabla de Servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicio` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(60) NOT NULL,
  `descripcion` VARCHAR(500) NOT NULL,
  `precio` DECIMAL(10, 2) NOT NULL,
  `rango` ENUM('1', '2', '3') NOT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------------------------------------------------
-- Tabla de Servicios-Presupuesto
CREATE TABLE IF NOT EXISTS `servicios_presupuesto` (
  `id_servicio` INT(11) NOT NULL,
  `id_presupuesto` INT(11) NOT NULL,
  `id_linea` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_linea`, `id_presupuesto`), -- Cambiado para que solo `id_linea` sea la clave primaria
  CONSTRAINT `fk_servicios_presupuesto_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios`(`id_servicio`) ON DELETE CASCADE,
  CONSTRAINT `fk_servicios_presupuesto_presupuesto` FOREIGN KEY (`id_presupuesto`) REFERENCES `presupuesto`(`id_presupuesto`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ----------------------------------------------------------------------
-- Tabla de Técnicos
CREATE TABLE IF NOT EXISTS `tecnicos` (
  `id_tecnico` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(20) NOT NULL,
  `apellido_1` VARCHAR(20) NOT NULL,
  `apellido_2` VARCHAR(20) NOT NULL,
  `titulacion` VARCHAR(20) NOT NULL,
  `dni` VARCHAR(9) NOT NULL UNIQUE,
  `fecha_nacimiento` DATE NOT NULL,
  `correo` VARCHAR(60) NOT NULL UNIQUE,
  `numero_tel` BIGINT(15) DEFAULT NULL,
  `rango` ENUM('1', '2', '3') NOT NULL,
  PRIMARY KEY (`id_tecnico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------------------------------------------------
-- Tabla de Técnicos-Trabajo
CREATE TABLE IF NOT EXISTS `tecnicos_trabajo` (
  `id_tecnico` INT(11) NOT NULL,
  `id_orden_trabajo` INT(11) NOT NULL,
  PRIMARY KEY (`id_tecnico`, `id_orden_trabajo`),
  CONSTRAINT `fk_tecnicos_trabajo_orden_trabajo` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `orden_trabajo`(`id_orden_trabajo`) ON DELETE CASCADE,
  CONSTRAINT `fk_tecnicos_trabajo_tecnico` FOREIGN KEY (`id_tecnico`) REFERENCES `tecnicos`(`id_tecnico`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------------------------------------------------


-- Triggers-------------------------------------------------------

DELIMITER $$

CREATE TRIGGER generar_factura_aceptado
AFTER UPDATE ON presupuesto 
FOR EACH ROW
BEGIN 
declare total_fra decimal (10,2);

 -- Solo generar factura si el estado cambia a "aceptado"
    IF NEW.estado = 'aceptado' THEN
        -- Calcular el total de los servicios del presupuesto aceptado
        SELECT SUM(s.precio) into total_fra
        FROM servicios s
        JOIN servicios_presupuesto sp ON s.id_servicio = sp.id_servicio
        WHERE sp.id_presupuesto = NEW.id_presupuesto;
        
        INSERT INTO factura (id_presupuesto,id_cliente, total) VALUES (new.id_presupuesto, new.id_cliente, total_fra);
        
         INSERT INTO `orden_trabajo` (`fecha_inicio`, `fecha_fin`)
        VALUES (CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY));
        
    END IF;
END $$
DELIMITER ;

-- Validar rangos de técnicos y servicios
DELIMITER $$
CREATE TRIGGER `validar_rango_tecnico_servicio`
BEFORE INSERT ON `tecnicos_trabajo`
FOR EACH ROW
BEGIN
    DECLARE tecnico_rango ENUM('1', '2', '3');
    DECLARE servicio_rango ENUM('1', '2', '3');
    
    SELECT t.rango INTO tecnico_rango
    FROM tecnicos t
    WHERE t.id_tecnico = NEW.id_tecnico;

    SELECT s.rango INTO servicio_rango
    FROM servicios s
    JOIN servicios_presupuesto sp ON s.id_servicio = sp.id_servicio
    JOIN presupuesto p ON sp.id_presupuesto = p.id_presupuesto
    WHERE p.id_orden_trabajo = NEW.id_orden_trabajo
    LIMIT 1;

    IF tecnico_rango < servicio_rango THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El técnico no tiene el rango suficiente para este servicio.';
    END IF;
END $$
DELIMITER ;







