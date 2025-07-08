-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2025 a las 19:42:54
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
-- Base de datos: `pantry_amigo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_administrador`
--

CREATE TABLE `tbl_administrador` (
  `Admin_Id` int(11) NOT NULL,
  `Admin_Username` varchar(40) NOT NULL,
  `Admin_Password` varchar(20) NOT NULL,
  `Admin_Correo` varchar(50) NOT NULL,
  `Admin_Usu_Id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_casos_dinero`
--

CREATE TABLE `tbl_casos_dinero` (
  `Caso_Id` int(11) NOT NULL,
  `Caso_Nombre` varchar(40) NOT NULL,
  `Caso_Descripcion` varchar(255) NOT NULL,
  `Caso_Monto_Meta` decimal(10,2) NOT NULL,
  `Caso_Monto_Recaudado` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Caso_Fecha_Inicio` date NOT NULL,
  `Caso_Fecha_Fin` date NOT NULL,
  `Caso_Estado` enum('Activo','Inactivo') NOT NULL,
  `Caso_Imagen` varchar(255) DEFAULT NULL,
  `Caso_Voluntariado` tinyint(1) DEFAULT 0,
  `Caso_Fund_Id` int(11) NOT NULL,
  `Caso_Cat_Nombre` enum('Salud','Educación','Emergencias','Alimentación','Tecnología','Medio Ambiente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_casos_dinero`
--

INSERT INTO `tbl_casos_dinero` (`Caso_Id`, `Caso_Nombre`, `Caso_Descripcion`, `Caso_Monto_Meta`, `Caso_Monto_Recaudado`, `Caso_Fecha_Inicio`, `Caso_Fecha_Fin`, `Caso_Estado`, `Caso_Imagen`, `Caso_Voluntariado`, `Caso_Fund_Id`, `Caso_Cat_Nombre`) VALUES
(9, 'Daniel animaciones', 'Daniel necesita financiar sus animaciones', 2000000.00, 11500.00, '2025-04-24', '2025-04-25', 'Activo', 'imagenes_casos/Caso8.jpeg', 0, 13, 'Emergencias'),
(10, 'Cambio de genero de daniela', 'daniela dejará su identidad anterior y será mujer', 9000000.00, 90600.00, '2025-04-21', '2025-04-30', 'Activo', 'imagenes_casos/Daniela.jpg', 1, 13, 'Salud'),
(14, 'Útiles escolares', 'Recaudo para comprar los utilies escolares a 50 niños', 1500000.00, 1556500.00, '2025-04-16', '2025-04-30', 'Activo', 'imagenes_casos/Utiles.jpg', 1, 13, 'Educación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categorias`
--

CREATE TABLE `tbl_categorias` (
  `Cat_Nombre` enum('Salud','Educación','Emergencias','Alimentación','Tecnología','Medio Ambiente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_categorias`
--

INSERT INTO `tbl_categorias` (`Cat_Nombre`) VALUES
('Salud'),
('Educación'),
('Emergencias'),
('Alimentación'),
('Tecnología'),
('Medio Ambiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_donacion_dinero`
--

CREATE TABLE `tbl_donacion_dinero` (
  `Don_Id` int(11) NOT NULL,
  `Don_Monto` decimal(10,2) NOT NULL,
  `Don_Comision` decimal(10,2) DEFAULT 0.00,
  `Don_Cedula_Donante` varchar(15) NOT NULL,
  `Don_Nombre_Donante` varchar(20) NOT NULL,
  `Don_Apellido_Donante` varchar(20) NOT NULL,
  `Don_Correo` varchar(40) NOT NULL,
  `Don_Fecha` date NOT NULL,
  `Don_Caso_Id` int(11) NOT NULL,
  `Don_Cat_Nombre` enum('Salud','Educación','Emergencias','Alimentación','Tecnología','Medio Ambiente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_donacion_dinero`
--

INSERT INTO `tbl_donacion_dinero` (`Don_Id`, `Don_Monto`, `Don_Comision`, `Don_Cedula_Donante`, `Don_Nombre_Donante`, `Don_Apellido_Donante`, `Don_Correo`, `Don_Fecha`, `Don_Caso_Id`, `Don_Cat_Nombre`) VALUES
(3, 3000.00, 0.00, '45785969', 'Marisol', 'López', 'Sunlopez@gmail.com', '0000-00-00', 10, 'Salud'),
(4, 7000.00, 0.00, '996839425', 'Diana', 'Vargas', 'Dianita123@gmail.com', '0000-00-00', 14, 'Salud'),
(7, 200000.00, 0.00, '55566678910', 'Monica', 'Martín', 'Monikartin@coreeo.com', '0000-00-00', 14, 'Salud'),
(8, 70000.00, 0.00, '333666999', 'Maria', 'Marcos', 'MariDB333@gmail.com', '0000-00-00', 14, 'Salud'),
(9, 70000.00, 0.00, '333666999', 'Maria', 'Marcos', 'MariDB333@gmail.com', '0000-00-00', 14, 'Salud'),
(23, 8000.00, 0.00, '2222222233333', 'Marisol', 'Bolívar', 'MariDB@gmail.com', '0000-00-00', 10, 'Salud'),
(24, 8000.00, 0.00, '2222222233333', 'Marisol', 'Bolívar', 'MariDB@gmail.com', '0000-00-00', 10, 'Salud'),
(25, 5000.00, 0.00, '45785969', 'Laura', 'peñaloza', 'MariDB@gmail.com', '0000-00-00', 10, 'Salud'),
(26, 5000.00, 0.00, '45785969', 'Laura', 'peñaloza', 'MariDB@gmail.com', '0000-00-00', 10, 'Salud'),
(27, 5000.00, 0.00, '45785969', 'Laura', 'peñaloza', 'MariDB@gmail.com', '0000-00-00', 10, 'Salud'),
(28, 5000.00, 0.00, '45785969', 'Laura', 'peñaloza', 'MariDB@gmail.com', '0000-00-00', 10, 'Salud'),
(29, 5000.00, 0.00, '45785969', 'Laura', 'peñaloza', 'MariDB@gmail.com', '0000-00-00', 10, 'Salud'),
(34, 8000.00, 0.00, '996839425', 'Marisol', 'DB', 'Fundacion13@coreeo.com', '0000-00-00', 14, 'Salud'),
(35, 1000000.00, 0.00, '996839425', 'Marisol', 'Bolívar', 'Fundacion13@coreeo.com', '0000-00-00', 14, 'Salud'),
(37, 1500.00, 0.00, '9996666333', 'Alec', 'Gómez', 'alec@gmail.com', '0000-00-00', 9, 'Salud'),
(38, 23500.00, 0.00, '52482557', 'Monica', 'Vargas', 'Moniv@gmail.com', '0000-00-00', 14, 'Salud'),
(39, 5000.00, 0.00, '9111', 'Luis', 'Prieto', 'Luisprieto@gmail.com', '0000-00-00', 10, 'Salud'),
(40, 5000.00, 0.00, '1234455', 'Diana', 'vargas', 'MariDB@gmail.com', '0000-00-00', 9, 'Salud'),
(41, 5000.00, 0.00, '1234455', 'Diana', 'vargas', 'MariDB@gmail.com', '0000-00-00', 9, 'Salud');

--
-- Disparadores `tbl_donacion_dinero`
--
DELIMITER $$
CREATE TRIGGER `actualizar_monto_recaudado` AFTER INSERT ON `tbl_donacion_dinero` FOR EACH ROW BEGIN
  UPDATE tbl_casos_dinero
  SET Caso_Monto_Recaudado = Caso_Monto_Recaudado + NEW.Don_Monto
  WHERE Caso_Id = NEW.Don_Caso_Id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_fundaciones`
--

CREATE TABLE `tbl_fundaciones` (
  `Fund_Id` int(11) NOT NULL,
  `Fund_Correo` varchar(50) NOT NULL,
  `Fund_Username` varchar(40) NOT NULL,
  `Fund_Direccion` varchar(20) NOT NULL,
  `Fund_Casos_Activos` int(10) NOT NULL,
  `Fund_Telefono` int(10) NOT NULL,
  `Fund_Usu_Id` int(10) NOT NULL,
  `Fund_Imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_fundaciones`
--

INSERT INTO `tbl_fundaciones` (`Fund_Id`, `Fund_Correo`, `Fund_Username`, `Fund_Direccion`, `Fund_Casos_Activos`, `Fund_Telefono`, `Fund_Usu_Id`, `Fund_Imagen`) VALUES
(13, 'fund13@correo.com', 'Fundacion 13', 'cr. 8 cll. 222', 2, 31384567, 2, 'img_684b104ee5c177.95954465_tipos-de-donaciones.jpg'),
(14, 'tapitasxpatitas@outlook.com', 'Tapitas por Patitas', 'Cra 12 #34‑56', 1, 314555667, 9, ''),
(15, 'Borreguito@gmail.com', 'Boreguito', 'CRA 90-10bww', 2, 10231232, 11, 'img_684b0e0301d169.45187413_tipos-de-donaciones.jpg'),
(16, 'Totolindo@gmail.com', 'Totoooo1', 'calle 90', 2, 123456789, 22, 'img_684b102b9890d8.70525362_WhatsApp Image 2025-02-04 at 12.12.19 PM.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_horarios_voluntarios`
--

CREATE TABLE `tbl_horarios_voluntarios` (
  `Hora_Id` int(10) NOT NULL,
  `Hora_Citacion` datetime NOT NULL,
  `Hora_Localizacion` varchar(40) NOT NULL,
  `Hora_Vol_Cedula` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_horarios_voluntarios`
--

INSERT INTO `tbl_horarios_voluntarios` (`Hora_Id`, `Hora_Citacion`, `Hora_Localizacion`, `Hora_Vol_Cedula`) VALUES
(1, '2025-04-30 23:27:00', 'el monte de suba', 1234567890),
(2, '2025-04-30 10:20:00', 'SENa paloquemado', 9111),
(3, '2026-04-24 06:00:00', 'Casa de Borreguito', 2005),
(4, '2026-12-31 04:00:00', 'Sena', 2005);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `Usu_Id` int(11) NOT NULL,
  `Usu_Username` varchar(20) NOT NULL,
  `Usu_Password` varchar(20) NOT NULL,
  `Usu_Tipo` varchar(30) NOT NULL,
  `Usu_Correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`Usu_Id`, `Usu_Username`, `Usu_Password`, `Usu_Tipo`, `Usu_Correo`) VALUES
(2, 'Fundacion', '131313', 'Usuario', 'Fundacion13@correo.com'),
(7, 'admin123', '123123', 'Administrador', 'Admin123@coreeo.com'),
(9, 'Tapitas por Patitas', 'Perritos1', 'Usuario', 'tapitasxpatitas@outlook.com'),
(11, 'Borreguito', '202020', 'Usuario', 'Borreguito@gmail.com'),
(22, 'Prueba', '20100', 'Usuario', 'df028231@gmail.commm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_voluntarios`
--

CREATE TABLE `tbl_voluntarios` (
  `Vol_Cedula` int(10) NOT NULL,
  `Vol_Nombre` varchar(40) NOT NULL,
  `Vol_Apellido` varchar(40) NOT NULL,
  `Vol_Correo` varchar(40) NOT NULL,
  `Vol_Celular` int(10) NOT NULL,
  `Vol_Caso_Id` int(11) NOT NULL,
  `Vol_Caso_Tipo` enum('Dinero','Recursos') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_voluntarios`
--

INSERT INTO `tbl_voluntarios` (`Vol_Cedula`, `Vol_Nombre`, `Vol_Apellido`, `Vol_Correo`, `Vol_Celular`, `Vol_Caso_Id`, `Vol_Caso_Tipo`) VALUES
(2005, 'funen ', 'a alejandro', 'funenajorge@gmail.com', 666777, 10, 'Dinero'),
(9111, 'Luis', 'Prieto', 'hprieto@gmail.com', 125694, 14, 'Dinero'),
(52482557, 'Selena', 'Gomez', 'selG@gmail.com', 30284698, 10, 'Dinero'),
(1011320651, 'Maria', 'Cardozo', 'maricardozo@gmail.com', 30284698, 8, 'Dinero'),
(1019988292, 'Marisol', 'Vargas', 'marisol123@gmail.com', 2147483647, 14, 'Dinero'),
(1234567890, 'YO', 'Yotas', 'yo@gmail.com', 3322596, 14, 'Dinero');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_administrador`
--
ALTER TABLE `tbl_administrador`
  ADD PRIMARY KEY (`Admin_Id`),
  ADD UNIQUE KEY `Admin_Correo` (`Admin_Correo`),
  ADD KEY `Admin_Usu_Id` (`Admin_Usu_Id`);

--
-- Indices de la tabla `tbl_casos_dinero`
--
ALTER TABLE `tbl_casos_dinero`
  ADD PRIMARY KEY (`Caso_Id`),
  ADD KEY `Caso_Fund_Id` (`Caso_Fund_Id`),
  ADD KEY `Caso_Cat_Nombre` (`Caso_Cat_Nombre`);

--
-- Indices de la tabla `tbl_categorias`
--
ALTER TABLE `tbl_categorias`
  ADD PRIMARY KEY (`Cat_Nombre`);

--
-- Indices de la tabla `tbl_donacion_dinero`
--
ALTER TABLE `tbl_donacion_dinero`
  ADD PRIMARY KEY (`Don_Id`),
  ADD KEY `Don_Caso_Id` (`Don_Caso_Id`),
  ADD KEY `Don_Cat_Nombre` (`Don_Cat_Nombre`);

--
-- Indices de la tabla `tbl_fundaciones`
--
ALTER TABLE `tbl_fundaciones`
  ADD PRIMARY KEY (`Fund_Id`),
  ADD UNIQUE KEY `Fund_Correo` (`Fund_Correo`),
  ADD UNIQUE KEY `Fund_Usu_Id` (`Fund_Usu_Id`);

--
-- Indices de la tabla `tbl_horarios_voluntarios`
--
ALTER TABLE `tbl_horarios_voluntarios`
  ADD PRIMARY KEY (`Hora_Id`),
  ADD KEY `Hora_Vol_Cedula` (`Hora_Vol_Cedula`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`Usu_Id`),
  ADD UNIQUE KEY `Usu_Correo` (`Usu_Correo`);

--
-- Indices de la tabla `tbl_voluntarios`
--
ALTER TABLE `tbl_voluntarios`
  ADD PRIMARY KEY (`Vol_Cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_administrador`
--
ALTER TABLE `tbl_administrador`
  MODIFY `Admin_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_casos_dinero`
--
ALTER TABLE `tbl_casos_dinero`
  MODIFY `Caso_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_donacion_dinero`
--
ALTER TABLE `tbl_donacion_dinero`
  MODIFY `Don_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tbl_fundaciones`
--
ALTER TABLE `tbl_fundaciones`
  MODIFY `Fund_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tbl_horarios_voluntarios`
--
ALTER TABLE `tbl_horarios_voluntarios`
  MODIFY `Hora_Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `Usu_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_administrador`
--
ALTER TABLE `tbl_administrador`
  ADD CONSTRAINT `tbl_administrador_ibfk_1` FOREIGN KEY (`Admin_Usu_Id`) REFERENCES `tbl_usuario` (`Usu_Id`);

--
-- Filtros para la tabla `tbl_casos_dinero`
--
ALTER TABLE `tbl_casos_dinero`
  ADD CONSTRAINT `tbl_casos_dinero_ibfk_1` FOREIGN KEY (`Caso_Fund_Id`) REFERENCES `tbl_fundaciones` (`Fund_Id`),
  ADD CONSTRAINT `tbl_casos_dinero_ibfk_2` FOREIGN KEY (`Caso_Cat_Nombre`) REFERENCES `tbl_categorias` (`Cat_Nombre`);

--
-- Filtros para la tabla `tbl_donacion_dinero`
--
ALTER TABLE `tbl_donacion_dinero`
  ADD CONSTRAINT `tbl_donacion_dinero_ibfk_1` FOREIGN KEY (`Don_Caso_Id`) REFERENCES `tbl_casos_dinero` (`Caso_Id`),
  ADD CONSTRAINT `tbl_donacion_dinero_ibfk_2` FOREIGN KEY (`Don_Cat_Nombre`) REFERENCES `tbl_categorias` (`Cat_Nombre`);

--
-- Filtros para la tabla `tbl_fundaciones`
--
ALTER TABLE `tbl_fundaciones`
  ADD CONSTRAINT `tbl_fundaciones_ibfk_1` FOREIGN KEY (`Fund_Usu_Id`) REFERENCES `tbl_usuario` (`Usu_Id`);

--
-- Filtros para la tabla `tbl_horarios_voluntarios`
--
ALTER TABLE `tbl_horarios_voluntarios`
  ADD CONSTRAINT `tbl_horarios_voluntarios_ibfk_1` FOREIGN KEY (`Hora_Vol_Cedula`) REFERENCES `tbl_voluntarios` (`Vol_Cedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
