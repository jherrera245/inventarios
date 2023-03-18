-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-11-2022 a las 16:58:23
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_inventario`
--
CREATE DATABASE IF NOT EXISTS `db_inventario` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `db_inventario`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `status`) VALUES
(1, 'Construcción', 'Estructura y Tabiqueria ,Cubiertas,Evacuacion,Utiles de Construcción,Aislamiento e Impermeabilizacion,Techos,Pavimentos,Puertas,Ventanas,Escalerias,Revestimientos,Cerramientos Seguridad.', 1),
(2, 'Madera', 'Estructura Y tabiqueria,Cubiertas,Evacuacion,Utiles de Construccion,Aislamiento e Impermeabilizacion,Techos,Pavimentos,Puertas,Ventanas,Escaleras,Revestimentos,Cerramientos Seguridad,Madera Acabados,Tableros y Tablas,Revestimiento de suelo,Revestimiento d', 1),
(3, 'Electricidad', 'Confort y domotica,Pilas,Material de Instalacion,Mecanismos,Pequeños materiales Electrico,Multimedia,Iluminacion,Bombillas y tubos,Energias Renovables', 1),
(4, 'Herramientas ', 'Maquinaria, Máquina Construcción, Maquinaria para metal,Maquinaria para madera,Herramienta Manual,Herramientas Electrica', 1),
(5, 'Jardin', 'Cierre y Ocultación,Maquinaria Jardin,Tierras y Fitosanitarios,Herramientas Jardin,Decoracion Jardin,Madera Jardin,Mueble Jardin,Mueble Jardin ,Auxilliar Jardin,Piscinas,Plata viva y Semilla,Riesgos,Casetas y Cobertizos,Mascotas', 1),
(6, 'Pintura', 'Adhesivos,Colas y Pegamentos,Aislamiento E Impremeabilizacion,Utiles de Pintura,Centro de color Tintometrico,Limpieza,Pintura Plastica,Esmaltes,Especiales,Tratamiento para la Madera,Tratamiento para Metal', 1),
(7, 'Ferretería', 'Cerrajeria,Herraje puertas y Ventanas,Herraje Mueble,Cajas de Seguridad,Fijacion,Cables Cadenas y Cordeleria,Buzones,Ruebas,Accesorios de Automocion,Patas,Perfileria,Tendido y Planchado,Perchas,Colgadores y Ganchos,Señalizacion,Burletes y Tapajuntas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conceptos`
--

DROP TABLE IF EXISTS `conceptos`;
CREATE TABLE IF NOT EXISTS `conceptos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concepto` varchar(75) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `conceptos`
--

INSERT INTO `conceptos` (`id`, `concepto`, `status`) VALUES
(1, 'Bueno', 1),
(2, 'Malo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingresos`
--

DROP TABLE IF EXISTS `detalle_ingresos`;
CREATE TABLE IF NOT EXISTS `detalle_ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ingreso` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_id_ingreso_idx` (`id_ingreso`),
  KEY `fk_id_producto_idx` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `detalle_ingresos`
--

INSERT INTO `detalle_ingresos` (`id`, `id_ingreso`, `id_producto`, `cantidad`, `precio_compra`, `status`) VALUES
(1, 1, 1, 10, '20.00', 1),
(2, 1, 2, 50, '20.00', 1);

--
-- Disparadores `detalle_ingresos`
--
DROP TRIGGER IF EXISTS `trigger_update_stock_ingreso`;
DELIMITER $$
CREATE TRIGGER `trigger_update_stock_ingreso` AFTER INSERT ON `detalle_ingresos` FOR EACH ROW BEGIN
	UPDATE productos SET stock = stock + NEW.cantidad
	WHERE productos.id = NEW.id_producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_prestamos`
--

DROP TABLE IF EXISTS `detalle_prestamos`;
CREATE TABLE IF NOT EXISTS `detalle_prestamos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prestamo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_prestamo` int(11) NOT NULL,
  `cantidad_devuelto` int(11) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_id_prestamo_idx` (`id_prestamo`),
  KEY `fk_id_producto_prestamo_idx` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `detalle_prestamos`
--

INSERT INTO `detalle_prestamos` (`id`, `id_prestamo`, `id_producto`, `cantidad_prestamo`, `cantidad_devuelto`, `status`) VALUES
(1, 1, 1, 10, 10, 1),
(2, 1, 2, 50, 50, 1),
(3, 2, 15, 2, 2, 1),
(4, 2, 16, 5, 5, 1),
(5, 2, 19, 6, 0, 1),
(6, 3, 2, 50, 0, 1),
(7, 3, 3, 3, 0, 1),
(8, 3, 5, 2, 0, 1),
(9, 3, 31, 50, 0, 1),
(10, 3, 35, 5, 5, 1),
(11, 4, 6, 100, 0, 1),
(12, 4, 21, 3, 3, 1),
(13, 4, 30, 10, 10, 1),
(14, 4, 32, 56, 0, 1),
(15, 4, 36, 1, 1, 1),
(16, 5, 2, 10, 0, 1),
(17, 5, 6, 40, 0, 1),
(18, 5, 16, 3, 3, 1),
(19, 6, 1, 3, 0, 1),
(20, 7, 1, 3, 0, 1),
(21, 7, 2, 2, 0, 1),
(22, 7, 4, 2, 0, 1),
(23, 8, 55, 2, 0, 1),
(24, 8, 54, 2, 0, 1),
(25, 8, 52, 5, 0, 1);

--
-- Disparadores `detalle_prestamos`
--
DROP TRIGGER IF EXISTS `trigger_devolver_stock_prestamo`;
DELIMITER $$
CREATE TRIGGER `trigger_devolver_stock_prestamo` AFTER UPDATE ON `detalle_prestamos` FOR EACH ROW BEGIN
	IF NEW.cantidad_prestamo >= NEW.cantidad_devuelto THEN
		UPDATE productos SET stock = stock + NEW.cantidad_devuelto
		WHERE productos.id = NEW.id_producto;
	END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger_remover_stock_prestamo`;
DELIMITER $$
CREATE TRIGGER `trigger_remover_stock_prestamo` AFTER INSERT ON `detalle_prestamos` FOR EACH ROW BEGIN
	UPDATE productos SET stock = stock - NEW.cantidad_prestamo
	WHERE productos.id = NEW.id_producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE IF NOT EXISTS `ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_id_proveedor_idx` (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `id_proveedor`, `fecha`, `status`) VALUES
(1, 1, '2022-11-14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `practicantes`
--

DROP TABLE IF EXISTS `practicantes`;
CREATE TABLE IF NOT EXISTS `practicantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(75) COLLATE utf8_bin NOT NULL,
  `apellidos` varchar(75) COLLATE utf8_bin NOT NULL,
  `dui` varchar(11) COLLATE utf8_bin NOT NULL,
  `carnet` varchar(10) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(9) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dui_UNIQUE` (`dui`),
  UNIQUE KEY `id_usuario_UNIQUE` (`id_usuario`),
  UNIQUE KEY `carnet_UNIQUE` (`carnet`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `practicantes`
--

INSERT INTO `practicantes` (`id`, `id_usuario`, `nombres`, `apellidos`, `dui`, `carnet`, `telefono`, `status`) VALUES
(1, 2, 'Maria Estefani', 'Rodriguez', '29202025-3', 'U201908445', '2323-3434', 1),
(2, 3, 'Carlos Antonio', 'Contreras', '55656566-7', 'U20170345', '6523-3434', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

DROP TABLE IF EXISTS `prestamos`;
CREATE TABLE IF NOT EXISTS `prestamos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_practicante` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_id_practicante_prestamo_idx` (`id_practicante`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `id_practicante`, `fecha`, `status`) VALUES
(1, 1, '2022-11-14', 1),
(2, 1, '2022-11-14', 1),
(3, 1, '2022-11-14', 1),
(4, 2, '2022-11-14', 1),
(5, 2, '2022-11-17', 1),
(6, 1, '2022-11-17', 1),
(7, 1, '2022-11-17', 1),
(8, 1, '2022-11-17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `nombre` varchar(75) COLLATE utf8_bin NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `codigo` varchar(50) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `consumible` tinyint(4) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_id_categoria_idx` (`id_categoria`),
  KEY `fk_id_concepto_idx` (`id_concepto`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `id_concepto`, `nombre`, `stock`, `codigo`, `descripcion`, `consumible`, `status`) VALUES
(1, 1, 1, 'Cemento', 19, '08 01 01 01', 'Estructura y Tabaquería', 1, 1),
(2, 1, 1, 'Aridos', 8, '08 01 01 02', 'Estructura y Tabaquería', 1, 1),
(3, 1, 1, 'Prefabricados hormigon', 2, '08 01 01 03', 'Estructura y Tabaquería', 1, 1),
(4, 1, 1, 'Hierro 1/2', 3, '08 01 01 04', 'Estructura y Tabaquería', 1, 1),
(5, 1, 1, 'Hierro 1 Pugada', 3, '08 01 01 04 01', 'Estructura y Tabaquería', 1, 1),
(6, 1, 1, 'Bolque 12', 360, '08 01 01 05 01', 'Estructura y Tabaquería', 1, 1),
(7, 1, 1, 'Bloque 14', 800, '08 01 01 05 02', 'Estructura y Tabaquería', 1, 1),
(8, 1, 1, 'Tejas', 2000, '08 01 02 01', 'Cubiertas', 1, 1),
(9, 1, 1, 'Placas de Cubiertas', 100, '08 01 02 02', 'Cubiertas', 1, 1),
(10, 1, 1, 'Paneles y Tableros', 20, '08 01 02 03', 'Paneles y Tableros', 1, 1),
(11, 1, 1, 'Encofrado', 10, '08 01 03 01', 'Útiles de Construcción', 0, 1),
(12, 1, 1, 'Carretillas', 5, '08 01 03 02', 'Útiles de Construcción', 0, 1),
(13, 1, 1, 'Elevadores', 1, '08 01 03 02', 'Útiles de Construcción', 0, 1),
(14, 1, 1, 'Puntales', 20, '08 01 03 04', 'Útiles de Construcción', 0, 1),
(15, 1, 1, 'Andamios', 5, '08 01 03 05', 'Útiles de Construcción', 0, 1),
(16, 1, 1, 'Escaleras', 6, '08 01 03 06', 'Útiles de Construcción', 0, 1),
(17, 1, 1, 'Sacos', 50, '08 01 03 07', 'Útiles de Construcción', 0, 1),
(18, 2, 2, 'Listones en Bruto 3 metros', 20, '08 02 01 01', 'Madera Acabados', 1, 1),
(19, 2, 1, 'Listones Cepillados 6 metros', 44, '08 02 01 02', 'Madera Acabados', 1, 1),
(20, 2, 1, 'Molduras de Pared', 4, '08 02 01 03', 'Acabados', 0, 1),
(21, 2, 1, 'Rodapies', 4, '08 02 01 05', 'Acabados', 0, 1),
(22, 3, 2, 'Programadores', 1, '08 03 01 01', 'Confort Y Domótica', 0, 1),
(23, 3, 1, 'Pilas No Recargables', 10, '08 03 02 01', 'Pilas', 1, 1),
(24, 3, 1, 'Pilas Recargables', 20, '08 03 02 02', 'Pilas', 0, 1),
(25, 3, 1, 'Rollo de Cable 12 ', 50, '08 03 03 01', 'Materiales de Instalación', 1, 1),
(26, 1, 1, 'Apiradora', 1, '08 04 01 01', 'Aspiradora', 0, 1),
(27, 4, 2, 'Compresores', 1, '08 04 02 02', 'MAQUINARIA CONSTRUCCIÓN', 0, 1),
(28, 4, 1, 'Vibradores', 100, '08 04 02 03', 'MAQUINARIA CONSTRUCCIÓN', 0, 1),
(29, 1, 2, 'Compactadoras', 10, '08 04 02 04', 'MAQUINARIA CONSTRUCCIÓN', 0, 1),
(30, 4, 1, 'Miniexcavadoras', 10, '08 04 02 05', 'MAQUINARIA CONSTRUCCIÓN', 0, 1),
(31, 1, 1, 'Chafl anadoras', 50, '08 04 02 06', 'MAQUINARIA CONSTRUCCIÓN', 1, 1),
(32, 1, 1, 'Cizallas', 44, '08 04 03 08', 'MAQUINARIA PARA METAL', 1, 1),
(33, 3, 2, 'Alicate', 10, '08 04 03 09', 'MAQUINARIA PARA METAL', 0, 1),
(34, 1, 1, 'Plegadoras', 100, '08 04 03 10', 'MAQUINARIA PARA METAL', 1, 1),
(35, 4, 2, 'Taladros columna', 10, '08 04 03 11', 'MAQUINARIA PARA MADERA', 0, 1),
(36, 2, 1, 'sierra circular', 5, '08 04 03 12', 'MAQUINARIA PARA MADERA', 0, 1),
(37, 2, 2, 'Tronzadoras', 10, '08 04 03 13', 'MAQUINARIA PARA METAL', 0, 1),
(38, 7, 2, 'Roscadoras', 10, '08 04 03 14', 'MAQUINARIA PARA METAL', 0, 1),
(39, 2, 2, 'Torno', 10, '08 04 03 15', 'MAQUINARIA PARA METAL', 0, 1),
(40, 2, 2, 'Cepilladora', 10, '08 05 03 01', 'MAQUINARIA PARA MADERA', 0, 1),
(41, 1, 1, 'Alicate', 1, '08 05 03 02', 'Alicate', 0, 1),
(42, 2, 2, 'Tenaza', 1, '08 05 03 03', 'MAQUINARIA CONSTRUCCIÓN', 0, 1),
(43, 3, 1, 'Rollo de Cable 10', 10, '08 03 03 04', 'Material de Instalación', 1, 1),
(44, 3, 1, 'Regletas de Conexión', 10, '08 03 03 05', 'Materiales de Conexión', 0, 1),
(45, 3, 1, 'Extensiones', 10, '08 03 03 06', 'Materia Eléctrico', 0, 1),
(46, 2, 1, 'Serrucho', 2, '08 04 03 07', 'MAQUINARIA CONSTRUCCIÓN', 0, 1),
(47, 4, 2, 'Desarmadores Phillips', 10, '08 05 03 08', 'HERRAMIENTA', 0, 1),
(48, 7, 1, 'Desarmadores Plano', 100, '08 05 03 09', 'HERRAMIENTA', 0, 1),
(49, 4, 2, 'Cuchara de Albañileria', 10, '08 05 03 10', 'MAQUINARIA PARA CONSTRUCCCION', 0, 1),
(50, 1, 1, 'Cinta Metrica', 100, '08 05 03 11', 'MAQUINARIA PARA CONSTRUCCION', 0, 1),
(51, 2, 1, 'Taladros', 10, '08 06 03 01', 'MAQUINARIA PARA CONTRUCCION O INSTALACIONES ELECTRICA', 0, 1),
(52, 7, 2, 'Martillos', 5, '08 06 03 02', 'MAQUINARIA PARA DE CONSTRUCCION', 0, 1),
(53, 7, 2, 'Lijas', 10, '08 06 03 03', 'MAQUINARIA PARA METAL', 1, 1),
(54, 2, 1, 'Mezcladores', 8, '08 06 03 04', 'MAQUINARIA PARA CONSTRUCCION', 0, 1),
(55, 2, 1, 'Soldadores', 8, '08 06 03 05', 'MAQUINARIA PARA METAL', 0, 1),
(56, 7, 2, 'Brocas de Concreto', 10, '08 06 03 06', 'MAQUINARIA PARA METAL', 0, 1),
(57, 1, 2, 'Brocas de Metal', 10, '08 06 03 07', 'MAQUINARIA PARA METAL', 0, 1),
(58, 7, 2, 'Brocas de Maderas', 10, '08 06 03 08', 'MAQUINARIA PARA MADERA', 0, 1),
(59, 1, 2, 'Armarios', 10, '08 06 03 09', 'MAQUINARIA PARA CONSTRUCCION', 0, 1),
(60, 3, 2, 'Cinturores', 10, '08 06 03 10', 'MAQUINARIAPARA CONTRUCCION O ELECTRICCIDAD', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(75) COLLATE utf8_bin NOT NULL,
  `apellidos` varchar(75) COLLATE utf8_bin NOT NULL,
  `documento` varchar(20) COLLATE utf8_bin NOT NULL,
  `direccion` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `telefono` varchar(9) COLLATE utf8_bin NOT NULL,
  `correo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombres`, `apellidos`, `documento`, `direccion`, `telefono`, `correo`, `status`) VALUES
(1, 'Carlos Antonio', 'Rios', '12121223-3', 'Santa Rosa de Lima', '2323-3434', 'anotnio@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`, `status`) VALUES
(1, 'Admin', 1),
(2, 'Practicante', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

DROP TABLE IF EXISTS `roles_usuarios`;
CREATE TABLE IF NOT EXISTS `roles_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_id_usuario_idx` (`id_usuario`),
  KEY `fk_id_rol_idx` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `roles_usuarios`
--

INSERT INTO `roles_usuarios` (`id`, `id_usuario`, `id_rol`, `status`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password`, `status`) VALUES
(1, 'Josue Herrera', '245jh17@gmail.com', 'c88840353a25f4321eea6b05b0cb6499', 1),
(2, 'Maria', 'maria@gmail.com', 'c88840353a25f4321eea6b05b0cb6499', 1),
(3, 'Carlos', 'carlos@gmail.com', 'c88840353a25f4321eea6b05b0cb6499', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD CONSTRAINT `fk_id_ingreso` FOREIGN KEY (`id_ingreso`) REFERENCES `ingresos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_producto_ingreso` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_prestamos`
--
ALTER TABLE `detalle_prestamos`
  ADD CONSTRAINT `fk_id_prestamo` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_producto_prestamo` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `fk_id_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `practicantes`
--
ALTER TABLE `practicantes`
  ADD CONSTRAINT `fk_id_usuario_practicante` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_id_practicante_prestamo` FOREIGN KEY (`id_practicante`) REFERENCES `practicantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_id_categoria_producto` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_concepto_producto` FOREIGN KEY (`id_concepto`) REFERENCES `conceptos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD CONSTRAINT `fk_id_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
