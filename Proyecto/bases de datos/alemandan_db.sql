-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2025 a las 01:37:46
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
-- Base de datos: `alemandan_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `correo`, `telefono`, `cargo`, `fecha_ingreso`, `estado`) VALUES
(1, 'Juan Camilo Lozada', 'juanlozada@gmail.com', '3000000000', 'Caja', '2025-07-06', 'Activo'),
(2, 'Laura Velandia', 'lauvel@gmail.com', '3000000011', 'Caja', '2025-07-06', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `ultima_actualizacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria`, `stock`, `precio`, `ultima_actualizacion`) VALUES
(2, 'Manzana', 'Fruta', -10, 500.00, '2025-07-06'),
(3, 'Lentejas', 'Grano', 16, 1500.00, '2025-07-06'),
(4, 'Agua', 'Bebida', 296, 20.00, '2025-07-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contacto` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `productos` int(11) DEFAULT NULL,
  `ultima_entrega` date DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `productos_suministrados` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `correo`, `telefono`, `productos`, `ultima_entrega`, `estado`, `productos_suministrados`) VALUES
(1, 'Postobon', '60199999', 'postobon@gmail.com', '321000000', NULL, '2025-07-01', 'Activo', 300),
(2, 'CocaCola', '601777', 'cocacola@gmail.com', '321000111', NULL, '2025-06-09', 'Inactivo', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `productos` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `cajero` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `productos`, `total`, `metodo_pago`, `cajero`) VALUES
(1, '2025-07-06 18:14:25', '[{\"id\":2,\"nombre\":\"Manzana\",\"precio\":500,\"cantidad\":1},{\"id\":4,\"nombre\":\"Agua\",\"precio\":20,\"cantidad\":1},{\"id\":3,\"nombre\":\"Lentejas\",\"precio\":1500,\"cantidad\":1}]', 2020.00, 'efectivo', 'Laura Torres'),
(2, '2025-07-06 18:17:52', '[{\"id\":2,\"nombre\":\"Manzana\",\"precio\":500,\"cantidad\":4}]', 2000.00, 'efectivo', 'Laura Torres'),
(3, '2025-07-06 18:23:35', '[{\"id\":2,\"nombre\":\"Manzana\",\"precio\":500,\"cantidad\":10}]', 5000.00, 'efectivo', 'Laura Torres'),
(4, '2025-07-06 18:27:45', '[{\"id\":3,\"nombre\":\"Lentejas\",\"precio\":1500,\"cantidad\":1}]', 1500.00, 'tarjeta', 'Laura Torres'),
(5, '2025-07-06 18:32:01', '[{\"id\":3,\"nombre\":\"Lentejas\",\"precio\":1500,\"cantidad\":11}]', 16500.00, 'transferencia', 'Laura Torres'),
(6, '2025-07-06 18:33:13', '[{\"id\":4,\"nombre\":\"Agua\",\"precio\":20,\"cantidad\":2},{\"id\":3,\"nombre\":\"Lentejas\",\"precio\":1500,\"cantidad\":1}]', 1540.00, 'transferencia', 'Laura Torres'),
(7, '2025-07-06 18:34:23', '[{\"id\":4,\"nombre\":\"Agua\",\"precio\":20,\"cantidad\":1}]', 20.00, 'transferencia', 'Laura Torres');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
