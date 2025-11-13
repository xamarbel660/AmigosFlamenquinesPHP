-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 11-11-2025 a las 07:38:22
-- Versión del servidor: 8.0.43
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `amigosFlamenquines`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `board`
--

CREATE TABLE `board` (
  `id_board` int NOT NULL,
  `created` datetime NOT NULL,
  `capacity` int NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `board`
--

INSERT INTO `board` (`id_board`, `created`, `capacity`, `location`) VALUES
(1, '2023-01-01 10:00:00', 4, 'Salón Interior 1'),
(2, '2023-01-01 10:00:00', 4, 'Salón Interior 2'),
(3, '2023-01-01 10:00:00', 2, 'Salón Interior 3 (Ventana)'),
(4, '2023-01-01 10:00:00', 6, 'Salón Interior 4 (Grupo)'),
(5, '2023-01-01 10:00:00', 4, 'Terraza 1'),
(6, '2023-01-01 10:00:00', 4, 'Terraza 2'),
(7, '2023-01-01 10:00:00', 8, 'Terraza Grande (Mesa Alta)'),
(8, '2023-01-01 10:00:00', 2, 'Barra 1'),
(9, '2023-01-01 10:00:00', 2, 'Barra 2'),
(10, '2023-01-01 10:00:00', 6, 'Reservado VIP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `category_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO category (id_category, category_name) 
VALUES 
(1, 'Habitual'),
(2, 'Exempleado'),
(3, 'Empleado'),
(4, 'Afiliado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `id_client` int NOT NULL,
  `date_created_account` date NOT NULL,
  `age` int NOT NULL,
  `is_vip` tinyint(1) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_category` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `client`
--

-- CORRECCIÓN:
INSERT INTO `client` (`id_client`, `date_created_account`, `age`, `is_vip`, `name`, `id_category`) VALUES
(1, '2023-01-15', 28, 1, 'Ana López', 1),
(2, '2022-05-20', 45, 0, 'Carlos García', 2),
(3, '2024-02-10', 19, 0, 'María Fernández', 1),
(4, '2023-11-30', 52, 1, 'Javier Martínez', 3),
(5, '2022-08-19', 34, 0, 'Lucía Sánchez', 4),
(6, '2024-01-05', 65, 0, 'David Pérez', 1),
(7, '2023-07-22', 29, 1, 'Sofía Gómez', 1),
(8, '2022-03-10', 41, 0, 'Pedro Rodríguez', 2),
(9, '2024-03-18', 22, 0, 'Elena Jiménez', 3),
(10, '2023-09-01', 37, 1, 'Miguel Ruiz', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_order`
--

CREATE TABLE `client_order` (
  `id_client_order` int NOT NULL,
  `client_order_date` datetime NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `id_client` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `client_order`
--

INSERT INTO `client_order` (`id_client_order`, `client_order_date`, `total_price`, `is_completed`, `comment`, `id_client`) VALUES
(1, '2025-10-28 14:30:00', 30.50, 1, 'Comida en salón', 1),
(2, '2025-10-28 21:00:00', 45.00, 1, 'Cena terraza', 2),
(3, '2025-10-28 13:00:00', 15.50, 1, 'Para llevar', 3),
(4, '2025-10-27 20:45:00', 88.00, 1, 'Mesa 4, pago dividido', 4),
(5, '2025-10-27 14:00:00', 22.00, 1, 'Cliente habitual', 5),
(6, '2025-10-26 21:30:00', 60.50, 1, 'Cliente VIP, descuento aplicado', 7),
(7, '2025-10-26 15:00:00', 19.50, 1, 'Solo tapas y bebidas', 8),
(8, '2025-10-25 20:00:00', 35.00, 1, 'Pago con tarjeta', 9),
(9, '2025-10-25 14:30:00', 52.00, 1, '', 10),
(10, '2025-10-29 12:30:00', 0.00, 0, 'Pedido en curso, mesa 1', 1),
(15, '2025-11-10 18:07:00', 59.50, 0, 'Pago con platinum', 1),
(16, '2025-11-10 18:07:00', 59.50, 0, 'Pago con platinum', 1),
(17, '2025-11-10 18:17:00', 23.50, 0, 'Platinum', 1),
(18, '2025-11-10 18:17:00', 23.50, 0, 'Platinum', 1),
(19, '2025-11-10 18:18:00', 24.50, 0, 'Pago con modenas del monopoli', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_dish`
--

CREATE TABLE `order_dish` (
  `id_client_order` int NOT NULL,
  `id_plate` int NOT NULL,
  `quantity` int NOT NULL,
  `notes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `order_dish`
--

INSERT INTO `order_dish` (`id_client_order`, `id_plate`, `quantity`, `notes`) VALUES
(1, 1, 1, 'Bien hecho'),
(1, 2, 2, ''),
(2, 3, 1, 'Sin miel, alergia'),
(2, 4, 1, 'Poca sal'),
(2, 10, 2, ''),
(3, 1, 1, 'Para llevar, cortar en trozos'),
(3, 5, 1, 'Extra picante'),
(4, 2, 4, ''),
(4, 6, 3, 'Ración y media'),
(4, 7, 2, 'Al punto'),
(5, 5, 1, ''),
(5, 8, 1, ''),
(6, 1, 2, 'Uno sin pimientos'),
(6, 3, 2, ''),
(6, 7, 1, 'Muy hecho'),
(7, 2, 1, ''),
(7, 5, 1, 'Con alioli extra'),
(8, 6, 2, ''),
(9, 4, 1, ''),
(9, 10, 1, 'Con sirope de chocolate'),
(10, 1, 1, 'En preparación'),
(10, 2, 1, 'En preparación'),
(18, 1, 1, ''),
(18, 10, 2, ''),
(19, 1, 1, ''),
(19, 9, 2, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plate`
--

CREATE TABLE `plate` (
  `id_plate` int NOT NULL,
  `added_date` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `plate`
--

INSERT INTO `plate` (`id_plate`, `added_date`, `price`, `is_available`, `name`) VALUES
(1, '2023-01-01 12:00:00', 12.50, 1, 'Flamenquín Cordobés'),
(2, '2023-01-01 12:00:00', 8.00, 1, 'Salmorejo'),
(3, '2023-01-01 12:00:00', 9.50, 1, 'Berenjenas con Miel'),
(4, '2023-01-01 12:00:00', 15.00, 1, 'Rabo de Toro'),
(5, '2023-01-01 12:00:00', 7.50, 1, 'Patatas Bravas'),
(6, '2023-01-01 12:00:00', 11.00, 1, 'Croquetas Caseras (Jamón)'),
(7, '2023-01-01 12:00:00', 18.00, 1, 'Presa Ibérica'),
(8, '2023-01-01 12:00:00', 14.50, 1, 'Flamenquín de Pollo y Serrano'),
(9, '2023-01-01 12:00:00', 6.00, 0, 'Gazpacho (Solo temporada)'),
(10, '2023-01-01 12:00:00', 5.50, 1, 'Tarta de Queso Casera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int NOT NULL,
  `reservation_date` datetime NOT NULL,
  `number_of_guests` int NOT NULL,
  `is_night_reservation` tinyint(1) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `id_board` int NOT NULL,
  `id_client` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `reservation_date`, `number_of_guests`, `is_night_reservation`, `comment`, `id_board`, `id_client`) VALUES
(1, '2025-11-01 14:00:00', 4, 0, 'Comida', 1, 1),
(2, '2025-11-01 21:00:00', 2, 1, 'Cena aniversario', 3, 2),
(3, '2025-11-02 13:30:00', 6, 0, 'Con carrito de bebé', 4, 3),
(4, '2025-11-02 20:30:00', 4, 1, 'Terraza si es posible', 5, 4),
(5, '2025-11-03 14:15:00', 8, 0, 'Grupo grande', 7, 5),
(6, '2025-11-03 21:00:00', 2, 1, 'Alergia al marisco', 8, 6),
(7, '2025-11-04 15:00:00', 3, 0, 'Comida', 2, 7),
(8, '2025-11-04 22:00:00', 5, 1, 'VIP', 10, 8),
(9, '2025-11-05 13:00:00', 2, 0, 'Barra', 9, 9),
(10, '2025-11-05 21:30:00', 4, 1, 'Cena tranquila', 6, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`id_board`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `FK_Client_Category` (`id_category`);

--
-- Indices de la tabla `client_order`
--
ALTER TABLE `client_order`
  ADD PRIMARY KEY (`id_client_order`),
  ADD KEY `FK_CashOrder_Client` (`id_client`) USING BTREE;

--
-- Indices de la tabla `order_dish`
--
ALTER TABLE `order_dish`
  ADD PRIMARY KEY (`id_client_order`,`id_plate`),
  ADD KEY `FK_OrderDish_Plate` (`id_plate`) USING BTREE;

--
-- Indices de la tabla `plate`
--
ALTER TABLE `plate`
  ADD PRIMARY KEY (`id_plate`);

--
-- Indices de la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `FK_Reser_Board` (`id_board`) USING BTREE,
  ADD KEY `FK_Reser_Client` (`id_client`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `board`
--
ALTER TABLE `board`
  MODIFY `id_board` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `client_order`
--
ALTER TABLE `client_order`
  MODIFY `id_client_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `plate`
--
ALTER TABLE `plate`
  MODIFY `id_plate` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_Client_Category` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `client_order`
--
ALTER TABLE `client_order`
  ADD CONSTRAINT `FK_CashOrder_Client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `order_dish`
--
ALTER TABLE `order_dish`
  ADD CONSTRAINT `FK_OrderDish_CashOrder` FOREIGN KEY (`id_client_order`) REFERENCES `client_order` (`id_client_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_OrderDish_Plate` FOREIGN KEY (`id_plate`) REFERENCES `plate` (`id_plate`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_Reser_Board` FOREIGN KEY (`id_board`) REFERENCES `board` (`id_board`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Reser_Client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

DELIMITER $$
CREATE TRIGGER trg_reservation_before_insert
BEFORE INSERT ON reservation
FOR EACH ROW
BEGIN
    -- Verificamos si ya existe una reserva en la misma mesa dentro de un rango de 2 horas
    IF EXISTS (
        SELECT 1
        FROM reservation r
        WHERE r.id_board = NEW.id_board
          AND ABS(TIMESTAMPDIFF(MINUTE, r.reservation_date, NEW.reservation_date)) < 120
    ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'No se puede reservar la misma mesa con menos de 2 horas de diferencia.';
    END IF;
END$$
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
