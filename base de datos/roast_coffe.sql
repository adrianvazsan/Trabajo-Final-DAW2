-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-02-2025 a las 20:47:44
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
-- Base de datos: `roast_coffe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedback`
--

CREATE TABLE `feedback` (
  `name` varchar(100) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `feedback`
--

INSERT INTO `feedback` (`name`, `text`, `rating`, `created_at`, `id`) VALUES
('María López', 'El café es delicioso, pero la entrega demoró más de lo esperado.', 4, '2025-02-16 11:05:00', 2),
('Carlos Gómez', 'Buena experiencia de compra. Volveré a comprar.', 5, '2025-02-16 11:10:00', 3),
('Pedro Sánchez', 'Servicio rápido y eficiente. Todo llegó en perfecto estado.', 5, '2025-02-16 11:20:00', 5),
('Laura Fernández', 'El empaque llegó dañado, pero el producto estaba bien.', 3, '2025-02-16 11:25:00', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_name` varchar(100) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `origin_product` varchar(100) DEFAULT NULL,
  `type_product` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_name`, `amount`, `origin_product`, `type_product`, `created_at`, `updated_at`, `id`) VALUES
('cerveza', 10, 'lanzarote', 'liquido', '2025-02-16 17:10:59', '2025-02-16 17:14:15', 1),
('Chocolate en Polvo', 30, 'Ecuador', 'Polvo', '2025-02-16 09:15:00', '2025-02-16 17:11:41', 2),
('Azúcar Morena', 100, 'Guatemala', 'Endulzante', '2025-02-16 09:20:00', '2025-02-16 17:40:14', 3),
('Leche en Polvo', 60, 'Argentina', 'Lácteo', '2025-02-16 09:25:00', '2025-02-16 17:40:14', 4),
('Miel Orgánica', 25, 'México', 'Endulzante', '2025-02-16 09:30:00', '2025-02-16 17:40:14', 5),
('Cacao en Grano', 45, 'Venezuela', 'Grano', '2025-02-16 09:35:00', '2025-02-16 17:40:14', 6),
('Esencia de Vainilla', 20, 'Madagascar', 'Extracto', '2025-02-16 09:40:00', '2025-02-16 17:40:14', 7),
('Canela en Polvo', 35, 'Sri Lanka', 'Especia', '2025-02-16 09:45:00', '2025-02-16 17:40:14', 8),
('Nuez Moscada', 15, 'India', 'Especia', '2025-02-16 09:50:00', '2025-02-16 17:40:14', 9),
('Café Descafeinado', 55, 'Perú', 'Grano', '2025-02-16 09:55:00', '2025-02-16 17:40:14', 10),
('Té Negro', 65, 'India', 'Hoja', '2025-02-16 10:00:00', '2025-02-16 17:40:14', 11),
('Jarabe de Agave', 40, 'México', 'Endulzante', '2025-02-16 10:05:00', '2025-02-16 17:40:14', 12),
('Chocolate Amargo', 30, 'Bélgica', 'Sólido', '2025-02-16 10:10:00', '2025-02-16 17:40:14', 13),
('Café Molido', 90, 'Etiopía', 'Molido', '2025-02-16 10:15:00', '2025-02-16 17:40:14', 14),
('Té de Manzanilla', 25, 'Egipto', 'Hoja', '2025-02-16 10:20:00', '2025-02-16 17:40:14', 15),
('Azúcar de Coco', 50, 'Filipinas', 'Endulzante', '2025-02-16 10:25:00', '2025-02-16 17:40:14', 16),
('Cacao en Polvo', 35, 'República Dominicana', 'Polvo', '2025-02-16 10:30:00', '2025-02-16 17:40:14', 17),
('Café Especialidad', 20, 'Honduras', 'Grano', '2025-02-16 10:35:00', '2025-02-16 17:40:14', 18),
('agua', 20, 'lanzarote', 'liquido', '2025-02-16 17:14:06', '2025-02-16 17:14:06', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `type` varchar(20) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`type`, `id`) VALUES
('admin', 1),
('normal', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_name` varchar(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `supplier_phone` int(11) NOT NULL,
  `supplier_origin` varchar(40) NOT NULL,
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `number_phone` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_rol` int(11) DEFAULT 2,
  `archivado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`name`, `email`, `number_phone`, `address`, `password`, `id`, `created_at`, `updated_at`, `id_rol`, `archivado`) VALUES
('Admin User', 'admin@example.com', NULL, NULL, '$2y$10$7OaZBz9OAl9LlvIu459NyOOEcXIWdUSQ1iexVx7uhWt3CEcVKlLBW', 6, '2025-02-16 16:30:11', '2025-02-16 18:06:50', 1, 0),
('Normal User', 'user@example.com', NULL, NULL, 'hashed_password', 7, '2025-02-16 16:30:11', '2025-02-16 16:30:11', 2, 0),
('daniel', 'test2@gmail.com', NULL, NULL, '$2y$10$W9bLDyPHnjKjgwNMsJT8.O5m56KUJUrEc8Tb1PUF1OLS9ZGHOVYgu', 14, '2025-02-16 16:15:25', '2025-02-16 17:02:57', 2, 1),
('María Gómez', 'maria@example.com', NULL, NULL, '123456', 16, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Carlos López', 'carlos@example.com', NULL, NULL, '123456', 17, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Ana Torres', 'ana@example.com', NULL, NULL, '123456', 18, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 1, 0),
('Luis Fernández', 'luis@example.com', NULL, NULL, '123456', 19, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Sofía Ramírez', 'sofia@example.com', NULL, NULL, '123456', 20, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Pedro Castillo', 'pedro@example.com', NULL, NULL, '123456', 21, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 1, 0),
('Laura Mendoza', 'laura@example.com', NULL, NULL, '123456', 22, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Diego Herrera', 'diego@example.com', NULL, NULL, '123456', 23, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Elena Vargas', 'elena@example.com', NULL, NULL, '123456', 24, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 1, 0),
(NULL, 'dani@email.com', NULL, NULL, '$2y$10$uHAh02WWpY1phqfpf/crLO5wrETtFdBlH/zNoRWd6xDpr7TVgjqa6', 25, '2025-02-16 17:54:18', '2025-02-16 17:54:18', 2, 0),
('asds', 'dani@email.com', NULL, NULL, '$2y$10$15LmsOR/Ay/zHtnPNCOznu4WwYAtnik6f.kQ.paDGVTSxquuNzEku', 26, '2025-02-16 18:03:55', '2025-02-16 18:06:42', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_roles` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
