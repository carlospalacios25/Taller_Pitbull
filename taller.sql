-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2024 a las 04:24:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taller`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id_cargos` int(11) NOT NULL,
  `tipo_cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id_cargos`, `tipo_cargo`) VALUES
(1, 'Mecanico I'),
(2, 'Contador'),
(3, 'Auxiliar Mecanico I'),
(4, 'Mecanico II'),
(5, 'Auxiliar Administrativo I'),
(6, 'Revisor Fiscal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cedula` int(20) NOT NULL,
  `nom_cliente` varchar(50) NOT NULL,
  `ape_cliente` varchar(50) NOT NULL,
  `telefono` bigint(15) NOT NULL,
  `direccion` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cedula`, `nom_cliente`, `ape_cliente`, `telefono`, `direccion`) VALUES
(3356241, 'Orlando', 'Diaz Guerrero', 3215547862, 'CRA 3 # 160 D - 24 INT CRA 3 # 160 D - 24 INT 1'),
(12556565, 'Carlos Julio', 'Gomez Perez', 3466574147, 'CRA 1 C # 160 D - 29'),
(33426558, 'Maria Elena', 'Ortiz Zea', 3215478524, 'Calle 98 b sur 23  58'),
(33435229, 'Claudio', 'Prieto Ostos', 3046558748, 'CALLE 100 N° 26 -6'),
(56513213, 'Karen', 'Gutierrez', 3546354535, 'KR 10 # 165A-24 INT 10'),
(66571558, 'Julio', 'Mendez Diaz', 3046654771, 'Kra 76 d # 62 i 22 sur'),
(1000120253, 'Diego Alejandro', 'Hernandez', 3046654745, 'CA 76 D # 62 22'),
(1000257485, 'Luis Carlos', 'Castro', 3215428471, 'CALLE 90 A 94 G 11 BACHUE CASA'),
(1000789064, 'Karen Yulieth', 'Mahecha Gutierrez', 3002083822, 'Diagonal 65 - 87 sur 95'),
(1002457852, 'Johana', 'Alarcon Aguirre', 321004751, 'KR3 # 160C-24 IN 1'),
(1511541512, 'karla', 'jimenes', 3322279673, 'CALLE 56 A 77 G 11 BACHUE CASA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra_cons` int(5) NOT NULL,
  `id_compra` varchar(20) NOT NULL,
  `doc_proveedor` bigint(15) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `fecha_compra` date NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio_unitario` double NOT NULL,
  `impuesto_iva` double(10,2) NOT NULL,
  `precio_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra_cons`, `id_compra`, `doc_proveedor`, `id_producto`, `fecha_compra`, `cantidad`, `precio_unitario`, `impuesto_iva`, `precio_total`) VALUES
(1, 'FAC-857145', 666514, 1, '2023-07-18', 6, 26600, 19.00, 31624),
(2, 'FAC-857145', 666514, 2, '2023-06-29', 1, 5345.54, 0.00, 5345.54);

--
-- Disparadores `compra`
--
DELIMITER $$
CREATE TRIGGER `actualizar_existencia_compra` AFTER INSERT ON `compra` FOR EACH ROW BEGIN
    -- Actualiza la columna existencias en la tabla productos
    UPDATE producto
    SET existencias = existencias + NEW.cantidad
    WHERE id_producto = NEW.id_producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `documento_emp` int(10) NOT NULL,
  `nom_empleado` varchar(50) NOT NULL,
  `ape_empleado` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` bigint(15) NOT NULL,
  `id_cargos` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`documento_emp`, `nom_empleado`, `ape_empleado`, `direccion`, `telefono`, `id_cargos`) VALUES
(966544, 'Yulithe', 'Osma', 'CALLE 76 # 87 D 58', 3215441425, 2),
(3356244, 'Andres', 'Lopez Lopez', 'KRA 76 D# 62 I 22 SUR', 3046654778, 4),
(6253624, 'Mario Alejandro', 'Mahecha', 'CALLE 76 D # 87 58', 3215474584, 1),
(1000120253, 'Andres', 'Diaz Cartes', 'KRA 76 D# 62 I 22 SUR', 3046654785, 3),
(1002254475, 'Carlos', 'Galindo Gomez', 'Kra 76 D# 62 I 22 SUR', 3046565656, 6),
(1002457741, 'Juan Sebastian', 'Martinez', 'Calle 85 - 26 #87', 3134525474, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(10) NOT NULL,
  `num_fac_serv` varchar(20) NOT NULL,
  `id_servicio` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `precio_total` float NOT NULL,
  `descuento` int(3) NOT NULL,
  `fecha_factura` timestamp NULL DEFAULT NULL,
  `cantidad` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `num_fac_serv`, `id_servicio`, `id_producto`, `precio_total`, `descuento`, `fecha_factura`, `cantidad`) VALUES
(1, 'PTB-006', 2, 2, 60000, 0, '2023-06-15 05:00:00', 2),
(2, 'PTB-005', 3, 1, 200000, 0, '2023-07-11 05:00:00', 2),
(3, 'PTB-004', 4, 2, 600000, 0, '2023-07-14 05:00:00', 2),
(4, 'PTB-007', 1, 1, 700000, 0, '2023-07-12 05:00:00', 2),
(6, 'PTB-003', 6, 1, 100000, 0, '2023-07-13 05:00:00', 1),
(7, 'PTB-002', 7, 2, 2000000, 0, '2023-07-07 05:00:00', 1),
(8, 'PTB-001', 8, 3, 70000, 0, '2023-07-06 05:00:00', 1),
(9, 'PTB-006', 2, 3, 200000, 0, '2023-07-18 05:00:00', 2),
(10, 'PTB-002', 7, 1, 700000, 0, '2024-06-13 05:00:00', 2),
(11, 'PTB-008', 15, 1, 152000, 0, '2024-11-07 03:20:54', 1),
(12, '', 6, 1, 0, 0, NULL, 2);

--
-- Disparadores `factura`
--
DELIMITER $$
CREATE TRIGGER `actualizar_existencias_factura` AFTER INSERT ON `factura` FOR EACH ROW BEGIN
    -- Actualiza la columna existencias en la tabla productos
    UPDATE producto
    SET existencias = existencias - NEW.cantidad
    WHERE id_producto = NEW.id_producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(10) NOT NULL,
  `nom_producto` varchar(45) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio_unitario` int(10) DEFAULT NULL,
  `existencias` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nom_producto`, `codigo`, `descripcion`, `precio_unitario`, `existencias`) VALUES
(1, 'ACITE 15 *50', '525D2DS', 'SOLO MOTO PEQUEÑA', 20000, 9),
(2, 'TORNILLOS 14', '55DFD5S', 'PARA MOTORES', 500, 0),
(3, 'FRENOS', 'F6221', 'MOTOS', 20000, 1),
(4, 'ESPEJO LUJOS', 'ESP98', 'NS', 60000, 2),
(5, 'ESPEJOS PARA DOMINAR 400', 'E545EF', 'Estilo rápido con modelos de vietos', 150000, 7),
(6, 'ACEITE 25 * 50', 'COD123', 'Descripción del producto A', 100, 50),
(7, 'GUAYA DE CAMBIOS 180', 'GDEGGVV', 'Guaya para cambios moto', 25000, 0),
(8, 'GUAYA DE FRENOS 180', '656584811S', 'Guaya para frenos de pulsar 180 5cm', 25000, 1),
(9, 'FRENOS NKD 125', 'A6565S5S', 'Frenos sencillos', 15000, 1),
(10, 'Mano de obra', 'No aplica', 'Mano de obra personal', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `documento_NIT` bigint(16) NOT NULL,
  `nom_proveedor` varchar(70) NOT NULL,
  `apellido_sociedad` varchar(70) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` bigint(15) NOT NULL,
  `id_tipo_proveedor` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`documento_NIT`, `nom_proveedor`, `apellido_sociedad`, `direccion`, `telefono`, `id_tipo_proveedor`) VALUES
(336224, 'Sociedad de talleres', 'Sas', 'KRA 26 D 96', 3046654771, 7),
(666514, 'Moto Services', 'Sas', 'KR 45 # 120 - 71', 3218957521, 2),
(33435229, 'Centro De Servicios Juan Motos', ' SAS', 'KR 30 # 63 C - 50', 3358764988, 2),
(56453542, 'Motos Cortes', 'Sas', '73A BIS A sur #16Q 41', 3133303000, 5),
(900560150, 'Taller De Motos Niches', 'Sas', 'CL 38 13 27', 3213267741, 3),
(901405600, 'Bogota Bikers', 'Sas', 'KR 29 # 71 A - 28', 3002084578, 3),
(901429637, 'Almacen Y Taller De Motos Mundo Apache', 'Ltda', 'CL 70 # 26 K - 06', 3005745896, 8),
(901555532, 'Distribuciones Bajaj La Plata', 'Sas', 'CARRERA 3E NO. 7 - 35 AVENIDA LIBERTADORES', 6017452508, 2),
(901575412, 'Comercializadora Vinmotors Nkd', 'Ltda', 'AV DEL LIBERTADOR NO 24 - 45 CC AQUARELA PLAZA LC 22', 3043487515, 3),
(1000120253, 'Nene Motos', 'Sas', 'Carrera 74 # 108 - 14', 3985432279, 4),
(1023378029, 'juan', 'RAMIREZ', 'CALLE 90 A 94 G 11 BACHUE CASA', 3215478569, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicios` int(10) NOT NULL,
  `observaciones` varchar(1000) NOT NULL,
  `mantenimiento` varchar(1000) NOT NULL,
  `cedula_cliente` int(10) DEFAULT NULL,
  `documento_emp` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicios`, `observaciones`, `mantenimiento`, `cedula_cliente`, `documento_emp`) VALUES
(1, 'se realiza cambio de aciete', '', 1000120253, 6253624),
(2, 'se ajusta la moto', '', 33435229, 966544),
(3, 'Ser verifica la cantidad de acite', '', 3356241, 1000120253),
(4, 'verificacion del motor', '', 1000120253, 6253624),
(5, 'Ajuste de espejos', '', 33435229, 6253624),
(6, 'Lavado del motor', '', 33435229, 966544),
(7, 'ajuste a la moto', '', 1000120253, 966544),
(8, 'ajuste de frenos', '', 1000120253, NULL),
(9, 'Realizar cambio de Aceite Moto pulsar 160, cambio de frenos delanteros como traseros, ajuste de guaya de cambios', '', 1000120253, 1002457741),
(10, 'Cambiar sellin', '', 33435229, 1002254475),
(11, 'Realizar cambio de aceite de frenos Moto gixer 250', '', 1511541512, NULL),
(12, 'Realizar ajuste de moto, cambio kit de arrastre moto NS200', '', 66571558, NULL),
(13, 'Se encuntra sonido raro en el motos, verificar rodamiento', '', 66571558, NULL),
(14, 'Recargar bateria moto NKD 125', '', 1000257485, NULL),
(15, 'Agregar baul a moto', '', 3356241, NULL),
(16, 'Cambio de llanatas a moto Mt 03', '', 1000120253, NULL),
(17, 'Cambio de frenos, refigerante fitro de aira', '', 1000120253, NULL),
(18, 'Cambio de silla ´de moto, cambio de posapies, cambio de espejos, arreglo ajuste de motor', '', 33435229, NULL),
(19, 'Solicitud de cambio de acite moto NKD 125, cambio de frenos delanteros y traseros, ajustar espejos', '', 1000789064, NULL),
(20, 'Cambio manijar', '', 12556565, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_proveedor`
--

CREATE TABLE `tipo_proveedor` (
  `id_tipo_proveedor` int(10) NOT NULL,
  `tipo_proveedor` varchar(50) NOT NULL,
  `descripcion` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_proveedor`
--

INSERT INTO `tipo_proveedor` (`id_tipo_proveedor`, `tipo_proveedor`, `descripcion`) VALUES
(1, 'Persona natural', 'Son todas las que no tiene un lugar Variante'),
(2, 'Persona juridica', 'son todas la que ganan mas de 1000 mil pesos'),
(3, 'Persona implicita', 'son las que ganan 500 pesos'),
(4, 'Persona Master', 'Esta persona es buena'),
(5, 'Persona Juridica Natural', 'Establecida en la norma 4524 del 2.19'),
(6, 'Persona Dian', 'Esta Persona Se encarga del estado de las cuentas'),
(7, 'Tributaria', 'Manejo de ralaciones con el estado'),
(8, 'Zinc', 'Prueba Unitaria Del zinc'),
(9, 'Arreglado', 'OK arreglado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(70) NOT NULL,
  `usuario_apellido` varchar(70) NOT NULL,
  `usuario_email` varchar(100) NOT NULL,
  `usuario_usuario` varchar(30) NOT NULL,
  `usuario_clave` varchar(200) NOT NULL,
  `usuario_foto` varchar(535) NOT NULL,
  `usuario_creado` timestamp NULL DEFAULT NULL,
  `usuario_actualizado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_creado`, `usuario_actualizado`) VALUES
(1, 'Carlos Hernan', 'Tocarruncho Palacios', 'carlos.tocarruncho2001@gmail.com', 'CarlosTop', '$2y$10$uM.ZKJYxGDyL1Xdj0neYYO9lm4LFKnX2GbSref9aT05XHy85aqeqq', 'Carlos_Hernan_15.jpg', '2024-08-04 22:10:17', '2024-08-13 00:31:41');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_cargos`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra_cons`),
  ADD KEY `doc_proveerdor` (`doc_proveedor`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`documento_emp`),
  ADD KEY `id_cargos` (`id_cargos`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`documento_NIT`),
  ADD KEY `id_tipo_proveedor` (`id_tipo_proveedor`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicios`),
  ADD KEY `cedula` (`cedula_cliente`),
  ADD KEY `documento_emp` (`documento_emp`);

--
-- Indices de la tabla `tipo_proveedor`
--
ALTER TABLE `tipo_proveedor`
  ADD PRIMARY KEY (`id_tipo_proveedor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra_cons` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicios` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tipo_proveedor`
--
ALTER TABLE `tipo_proveedor`
  MODIFY `id_tipo_proveedor` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`doc_proveedor`) REFERENCES `proveedor` (`documento_NIT`),
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`id_cargos`) REFERENCES `cargos` (`id_cargos`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicios`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`id_tipo_proveedor`) REFERENCES `tipo_proveedor` (`id_tipo_proveedor`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`cedula_cliente`) REFERENCES `cliente` (`cedula`),
  ADD CONSTRAINT `servicios_ibfk_2` FOREIGN KEY (`documento_emp`) REFERENCES `empleado` (`documento_emp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
