-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-08-2024 a las 04:42:34
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarCliente` (IN `p_cedula` INT(20), IN `p_nom_cliente` VARCHAR(50), IN `p_ape_cliente` VARCHAR(50), IN `p_telefono` BIGINT(15), IN `p_direccion` VARCHAR(70))   BEGIN
    UPDATE cliente
    SET nom_cliente = p_nom_cliente,
        ape_cliente = p_ape_cliente,
        telefono = p_telefono,
        direccion = p_direccion
    WHERE cedula = p_cedula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarCompra` (IN `p_id_compra` VARCHAR(20), IN `p_doc_proveedor` BIGINT, IN `p_id_producto` INT, IN `p_precio_total` DOUBLE, IN `p_fecha_compra` DATE, IN `p_cantidad` INT)   BEGIN
    UPDATE compra 
    SET doc_proveedor = p_doc_proveedor, 
        id_producto = p_id_producto, 
        precio_total = p_precio_total, 
        fecha_compra = p_fecha_compra, 
        cantidad = p_cantidad
    WHERE id_compra = p_id_compra;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarEmpleado` (IN `p_documento_emp` INT, IN `p_nom_empleado` VARCHAR(50), IN `p_ape_empleado` VARCHAR(50), IN `p_direccion` VARCHAR(50), IN `p_telefono` BIGINT, IN `p_id_cargos` INT)   BEGIN
    UPDATE empleado 
    SET nom_empleado = p_nom_empleado, 
        ape_empleado = p_ape_empleado, 
        direccion = p_direccion, 
        telefono = p_telefono, 
        id_cargos = p_id_cargos
    WHERE documento_emp = p_documento_emp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarFactura` (IN `p_id_factura` INT, IN `p_id_servicio` INT, IN `p_id_producto` INT, IN `p_precio_total` FLOAT, IN `p_descuento` INT, IN `p_fecha_factura` DATE, IN `p_cantidad` INT)   BEGIN
    UPDATE factura
    SET id_servicio = p_id_servicio,
        id_producto = p_id_producto,
        precio_total = p_precio_total,
        descuento = p_descuento,
        fecha_factura = p_fecha_factura,
        cantidad = p_cantidad
    WHERE id_factura = p_id_factura;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarProducto` (IN `p_id_producto` INT, IN `p_nom_producto` VARCHAR(45), IN `p_codigo` VARCHAR(45), IN `p_descripcion` VARCHAR(45), IN `p_precio_unitario` INT, IN `p_existencias` INT)   BEGIN
    UPDATE producto 
    SET nom_producto = p_nom_producto,
        codigo = p_codigo,
        descripcion = p_descripcion,
        precio_unitario = p_precio_unitario,
        existencias = p_existencias
    WHERE id_producto = p_id_producto;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarProveedor` (IN `p_documento_NIT` BIGINT(16), IN `p_nom_proveedor` VARCHAR(70), IN `p_apellido_sociedad` VARCHAR(70), IN `p_direccion` VARCHAR(100), IN `p_telefono` BIGINT(15), IN `p_id_tipo_proveedor` INT(10))   BEGIN
    UPDATE proveedor 
    SET nom_proveedor = p_nom_proveedor,
        apellido_sociedad = p_apellido_sociedad,
        direccion = p_direccion,
        telefono = p_telefono,
        id_tipo_proveedor = p_id_tipo_proveedor
    WHERE documento_NIT = p_documento_NIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarServicio` (IN `p_id_servicios` INT, IN `p_observaciones` VARCHAR(200), IN `p_mantenimiento` VARCHAR(70), IN `p_cedula_cliente` INT, IN `p_documento_emp` INT)   BEGIN
    UPDATE servicios 
    SET observaciones = p_observaciones, 
        mantenimiento = p_mantenimiento, 
        cedula_cliente = p_cedula_cliente, 
        documento_emp = p_documento_emp
    WHERE id_servicios = p_id_servicios;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarTipoProveedor` (IN `p_id_tipo_proveedor` INT, IN `p_tipo_proveedor` VARCHAR(50), IN `p_descripcion` VARCHAR(70))   BEGIN
    UPDATE tipo_proveedor 
    SET tipo_proveedor = p_tipo_proveedor, descripcion = p_descripcion 
    WHERE id_tipo_proveedor = p_id_tipo_proveedor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Actualizar_Cargo` (IN `carg_id` INT, IN `carg_nombre` VARCHAR(50))   BEGIN
    UPDATE cargos SET tipo_cargo = carg_nombre WHERE id_cargos = carg_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarClientes` ()   BEGIN
    SELECT * FROM cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarCompra` ()   BEGIN
    SELECT * FROM compra;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarEmpleado` (IN `p_documento_emp` INT)   BEGIN
    SELECT * FROM empleado WHERE documento_emp = p_documento_emp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarFactura` (IN `p_id_factura` INT)   BEGIN
    SELECT * FROM factura WHERE id_factura = p_id_factura;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarProductos` ()   BEGIN
    SELECT * FROM producto;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarProveedor` (IN `p_documento_NIT` BIGINT(16))   BEGIN
    SELECT * FROM proveedor WHERE documento_NIT = p_documento_NIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarServicio` (IN `p_id_servicios` INT)   BEGIN
    SELECT * FROM servicios WHERE id_servicios = p_id_servicios;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarTipoProveedor` ()   BEGIN
    SELECT * FROM tipo_proveedor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Consulta_Cargo` (IN `con_Cargo` VARCHAR(50))   BEGIN
    SELECT * FROM cargos WHERE tipo_cargo = con_Cargo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarCliente` (IN `p_cedula` INT(20))   BEGIN
    DELETE FROM cliente WHERE cedula = p_cedula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarCompra` (IN `p_id_compra` VARCHAR(20))   BEGIN
    DELETE FROM compra WHERE id_compra = p_id_compra;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarEmpleado` (IN `p_documento_emp` INT)   BEGIN
    DELETE FROM empleado WHERE documento_emp = p_documento_emp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarFactura` (IN `p_id_factura` INT)   BEGIN
    DELETE FROM factura WHERE id_factura = p_id_factura;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarProducto` (IN `p_id_producto` INT)   BEGIN
    DELETE FROM producto WHERE id_producto = p_id_producto;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarProveedor` (IN `p_documento_NIT` BIGINT(16))   BEGIN
    DELETE FROM proveedor WHERE documento_NIT = p_documento_NIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarServicio` (IN `p_id_servicios` INT)   BEGIN
    DELETE FROM servicios WHERE id_servicios = p_id_servicios;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarTipoProveedor` (IN `p_id_tipo_proveedor` INT)   BEGIN
    DELETE FROM tipo_proveedor WHERE id_tipo_proveedor = p_id_tipo_proveedor;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Cargo` (IN `carg_id` INT)   BEGIN
    DELETE FROM cargos WHERE id_cargos = carg_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar` (IN `In_tipo_cargo` VARCHAR(50))   BEGIN
    INSERT INTO cargos (tipo_cargo) VALUES (In_tipo_cargo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarCliente` (IN `p_cedula` INT(20), IN `p_nom_cliente` VARCHAR(50), IN `p_ape_cliente` VARCHAR(50), IN `p_telefono` BIGINT(15), IN `p_direccion` VARCHAR(70))   BEGIN
    INSERT INTO cliente (cedula, nom_cliente, ape_cliente, telefono, direccion)
    VALUES (p_cedula, p_nom_cliente, p_ape_cliente, p_telefono, p_direccion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarCompra` (IN `p_id_compra` VARCHAR(20), IN `p_doc_proveedor` BIGINT, IN `p_id_producto` INT, IN `p_precio_total` DOUBLE, IN `p_fecha_compra` DATE, IN `p_cantidad` INT)   BEGIN
    DECLARE v_existe_proveedor INT;
    DECLARE v_existe_producto INT;

    -- Verificar si el proveedor existe
    SELECT COUNT(*) INTO v_existe_proveedor
    FROM proveedor
    WHERE documento_NIT = p_doc_proveedor;

    IF v_existe_proveedor = 0 THEN
        -- Aquí puedes manejar la situación si el proveedor no existe
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El proveedor con documento NIT especificado no existe';
    END IF;

    -- Verificar si el producto existe
    SELECT COUNT(*) INTO v_existe_producto
    FROM producto
    WHERE id_producto = p_id_producto;

    IF v_existe_producto = 0 THEN
        -- Aquí puedes manejar la situación si el producto no existe
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El producto con ID especificado no existe';
    END IF;

    -- Insertar la compra si los datos son válidos
    INSERT INTO compra (id_compra, doc_proveedor, id_producto, precio_total, fecha_compra, cantidad) 
    VALUES (p_id_compra, p_doc_proveedor, p_id_producto, p_precio_total, p_fecha_compra, p_cantidad);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarEmpleado` (IN `p_documento_emp` INT, IN `p_nom_empleado` VARCHAR(50), IN `p_ape_empleado` VARCHAR(50), IN `p_direccion` VARCHAR(50), IN `p_telefono` BIGINT, IN `p_id_cargos` INT)   BEGIN
    INSERT INTO empleado (documento_emp, nom_empleado, ape_empleado, direccion, telefono, id_cargos) 
    VALUES (p_documento_emp, p_nom_empleado, p_ape_empleado, p_direccion, p_telefono, p_id_cargos);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarFactura` (IN `p_id_servicio` INT, IN `p_id_producto` INT, IN `p_precio_total` FLOAT, IN `p_descuento` INT, IN `p_fecha_factura` DATE, IN `p_cantidad` INT)   BEGIN
    INSERT INTO factura (id_servicio, id_producto, precio_total, descuento, fecha_factura, cantidad)
    VALUES (p_id_servicio, p_id_producto, p_precio_total, p_descuento, p_fecha_factura, p_cantidad);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarProducto` (IN `p_nom_producto` VARCHAR(45), IN `p_codigo` VARCHAR(45), IN `p_descripcion` VARCHAR(45), IN `p_precio_unitario` INT, IN `p_existencias` INT)   BEGIN
    INSERT INTO producto (nom_producto, codigo, descripcion, precio_unitario, existencias) 
    VALUES (p_nom_producto, p_codigo, p_descripcion, p_precio_unitario, p_existencias);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarProveedor` (IN `p_documento_NIT` BIGINT(16), IN `p_nom_proveedor` VARCHAR(70), IN `p_apellido_sociedad` VARCHAR(70), IN `p_direccion` VARCHAR(100), IN `p_telefono` BIGINT(15), IN `p_id_tipo_proveedor` INT(10))   BEGIN
    INSERT INTO proveedor (documento_NIT, nom_proveedor, apellido_sociedad, direccion, telefono, id_tipo_proveedor) 
    VALUES (p_documento_NIT, p_nom_proveedor, p_apellido_sociedad, p_direccion, p_telefono, p_id_tipo_proveedor);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarServicio` (IN `p_observaciones` VARCHAR(200), IN `p_mantenimiento` VARCHAR(70), IN `p_cedula_cliente` INT, IN `p_documento_emp` INT)   BEGIN
    INSERT INTO servicios (observaciones, mantenimiento, cedula_cliente, documento_emp) 
    VALUES (p_observaciones, p_mantenimiento, p_cedula_cliente, p_documento_emp);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarTipoProveedor` (IN `p_tipo_proveedor` VARCHAR(50), IN `p_descripcion` VARCHAR(70))   BEGIN
    INSERT INTO tipo_proveedor (tipo_proveedor, descripcion) VALUES (p_tipo_proveedor, p_descripcion);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Cargo` (IN `In_tipo_cargo` VARCHAR(50))   BEGIN
    INSERT INTO cargos (tipo_cargo) VALUES (In_tipo_cargo);
END$$

DELIMITER ;

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
(3, 'Auxiliar II'),
(4, 'Mecanico'),
(5, 'Ayudante II');

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
(3356241, 'ORLANDO', 'DIAZ', 36251459, 'CALLE'),
(12556565, 'carlos', 'otro', 346657414, 'kra889898'),
(33426558, 'Maria Elena', 'Ortiz Zea', 3215478524, 'Caller 98 b sur 23  58'),
(33435229, 'OLIMPIA', 'PALACIOS', 3046558748, 'CALLE 100 N° 26 -6'),
(56513213, 'KAREN', 'GUTIERREZ ', 3546354535, 'JFSGJHSGJ'),
(66571558, 'Carlos Julio', 'Tocarruncho Prieto', 3046654771, 'Kra 76 d # 62 i 22 sur'),
(1000120253, 'CARLOS', 'PALACIOS', 304665477, 'CA 76 D # 62 22'),
(1000257485, 'Luis Carlos', 'Castro', 3215428471, 'CALLE 90 A 94 G 11 BACHUE CASA'),
(1000789064, 'Karen Yulieth', 'Mahecha', 3002083822, 'Diagonal 65'),
(1511541512, 'karla', 'jimenes', 33222796730, 'CALLE 56 A 77 G 11 BACHUE CASA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` varchar(20) NOT NULL,
  `doc_proveedor` bigint(15) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `precio_total` double NOT NULL,
  `fecha_compra` date NOT NULL,
  `cantidad` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `doc_proveedor`, `id_producto`, `precio_total`, `fecha_compra`, `cantidad`) VALUES
('', 666514, 1, 26600, '2023-07-18', 6),
('534556', 666514, 2, 5345.54, '2023-06-29', 1),
('F206', 666514, 1, 2000, '2023-06-15', 2),
('LLA005', 666514, 1, 700000, '2024-06-14', 5),
('MD', 56453542, 3, 700000, '2024-06-14', 6);

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
(2222, 'carlos', 'p', '5', 30465656565, 3),
(625362, 'MARIO', 'MAHECHA', 'CALLE 76 D 58', 35121551, 3),
(966544, 'KAREN', 'MENDEZ', 'CALLE 76 D 58', 631425, 1),
(3356244, 'ANDRES', 'LOPEZ', 'KRA 76 D# 62 I 22 SUR', 30466547, 2),
(1000120253, 'ANDRES', 'DIAZ', 'KRA 76 D# 62 I 22 SUR', 30466547, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(10) NOT NULL,
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

INSERT INTO `factura` (`id_factura`, `id_servicio`, `id_producto`, `precio_total`, `descuento`, `fecha_factura`, `cantidad`) VALUES
(1, 2, 2, 60000, 0, '2023-06-15 05:00:00', 2),
(2, 3, 1, 200000, 0, '2023-07-11 05:00:00', 2),
(3, 4, 2, 600000, 0, '2023-07-14 05:00:00', 2),
(4, 1, 1, 700000, 0, '2023-07-12 05:00:00', 2),
(6, 6, 1, 100000, 0, '2023-07-13 05:00:00', 1),
(7, 7, 2, 2000000, 0, '2023-07-07 05:00:00', 1),
(8, 8, 3, 70000, 0, '2023-07-06 05:00:00', 1),
(9, 2, 3, 200000, 0, '2023-07-18 05:00:00', 2),
(10, 7, 1, 700000, 0, '2024-06-13 05:00:00', 2);

--
-- Disparadores `factura`
--
DELIMITER $$
CREATE TRIGGER `actualizar_existencias` AFTER INSERT ON `factura` FOR EACH ROW BEGIN
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
(1, 'ACITE 15 *50', '525D2DS', 'SOLO MOTO PEQUEÑA', 20000, 4),
(2, 'TORNILLOS 14', '55DFD5S', 'PARA MOTORES', 500, 6),
(3, 'FRENOS', 'F6221', 'MOTOS', 20000, 2),
(4, 'Espejos', 'e95', 'ns', 60000, 2),
(5, 'ESPEJOS', 'E545EF', 'PULSAR', 620000, 7),
(6, 'Producto A', 'COD123', 'Descripción del producto A', 100, 50);

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
(336224, 'Sociedad de talleres', 'Sas', 'KRA 26 D 96', 3046654771, 4),
(666514, 'Moto Services', 'Sas', 'KR 45 # 120 - 71', 3218957521, 1),
(33435229, 'Centro De Servicios Juan Motos', ' SAS', 'KR 30 # 63 C - 50', 3358764988, 2),
(56453542, 'Motos Cortes', 'Sas', '73A BIS A sur #16Q 41', 3133303000, 5),
(900560150, 'Taller De Motos Niches', 'Sas', 'CL 38 13 27', 3213267741, 3),
(901405600, 'Bogota Bikers', 'Sas', 'KR 29 # 71 A - 28', 3002084578, 3),
(901429637, 'Almacen Y Taller De Motos Mundo Apache', 'Ltda', 'CL 70 # 26 K - 06', 3005745896, 6),
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
  `observaciones` varchar(200) NOT NULL,
  `mantenimiento` varchar(70) NOT NULL,
  `cedula_cliente` int(10) DEFAULT NULL,
  `documento_emp` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicios`, `observaciones`, `mantenimiento`, `cedula_cliente`, `documento_emp`) VALUES
(1, 'se realiza cambio de aciete', 'bien', 1000120253, 1000120253),
(2, 'se ajusta la moto', 'bien todo ok', 33435229, 966544),
(3, 'Ser verifica la cantidad de acite', 'ok', 3356241, 1000120253),
(4, 'verificacion del motor', 'ok', 1000120253, 1000120253),
(5, 'ajuste de espejos', 'ok', 33435229, 3356244),
(6, 'Lavado del motor', 'ok limpia', 33435229, 966544),
(7, 'ajuste a la moto', 'ok tornillos', 1000120253, 966544),
(8, 'ajuste de frenos', 'limpia frenos', 1000120253, 1000120253);

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

--
-- Disparadores `tipo_proveedor`
--
DELIMITER $$
CREATE TRIGGER `after_tipo_proveedor_delete` AFTER DELETE ON `tipo_proveedor` FOR EACH ROW BEGIN
    INSERT INTO tipo_proveedor_logs (action, id_tipo_proveedor, tipo_proveedor, descripcion)
    VALUES ('DELETE', OLD.id_tipo_proveedor, OLD.tipo_proveedor, OLD.descripcion);
END
$$
DELIMITER ;

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
(1, 'Carlos Hernan', 'Tocarruncho Palacios', 'carlos.tocarruncho2001@gmail.com', 'CarlosTop', '$2y$10$uM.ZKJYxGDyL1Xdj0neYYO9lm4LFKnX2GbSref9aT05XHy85aqeqq', 'Carlos_Hernan_15.jpg', '2024-08-04 22:10:17', '2024-08-13 00:31:41'),
(3, 'Mario Alejandro', 'Gutierrez Mahecha', 'Marios.Alejandro@gmail.com', 'MarioBros', '$2y$10$kYL2OELdfngK2ummQSTjK.g0jEE0j.d4kVTAGxoqV1Sl.3oVvliBm', 'Mario_Alejandro_19.jpg', '2024-08-04 22:30:16', '2024-08-13 00:36:25');

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
  ADD PRIMARY KEY (`id_compra`),
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
  MODIFY `id_cargos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicios` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
