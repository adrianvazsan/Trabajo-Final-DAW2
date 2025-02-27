-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-02-2025 a las 09:47:06
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.3.14

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
-- Estructura de tabla para la tabla `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `pk_id_event` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `description_eng` text,
  `deletion_date` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`pk_id_event`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`pk_id_event`, `title`, `start_date`, `end_date`, `description_eng`, `deletion_date`, `user_id`) VALUES
(1, 'Reunión de equipo', '2025-02-05 10:00:00', NULL, NULL, NULL, 0),
(2, 'Entrega de proyecto', '2025-02-12 15:00:00', NULL, NULL, NULL, 0),
(3, 'Cumpleaños de Juan', '2025-02-18 00:00:00', NULL, NULL, NULL, 0),
(4, 'Revisión mensual', '2025-02-22 09:30:00', NULL, NULL, NULL, 0),
(5, 'Cena de empresa', '2025-02-28 20:00:00', NULL, NULL, NULL, 0),
(6, 'hola', '2025-02-28 00:00:00', '2025-03-01 00:00:00', 'Sin descripción', NULL, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` text COLLATE utf8mb4_general_ci,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_feedback_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `feedback`
--

INSERT INTO `feedback` (`name`, `text`, `rating`, `created_at`, `id`, `user_id`) VALUES
('Admin User', 'Excelente servicio, muy rápido y eficiente.', 5, '2025-02-25 09:15:00', 17, 1),
('Normal User', 'Buen producto, pero podría mejorar el envío.', 4, '2025-02-23 11:45:00', 19, 7),
('daniel', 'La atención al cliente fue espectacular.', 5, '2025-02-22 15:20:00', 20, 14),
('Admin User', 'No encontré lo que buscaba, pero el sitio es intuitivo.', 3, '2025-02-21 08:00:00', 21, 1),
('asds', 'Muy recomendado, compraré de nuevo.', 5, '2025-02-20 17:10:00', 22, 2),
('Normal User', 'La calidad del producto no es la esperada.', 2, '2025-02-19 19:40:00', 23, 7),
('daniel', 'Fácil de usar y muy práctico.', 4, '2025-02-18 07:30:00', 24, 14),
('Admin User', 'El servicio técnico fue de gran ayuda.', 5, '2025-02-17 21:15:00', 25, 1),
('asds', 'El proceso de pago tuvo algunos errores.', 3, '2025-02-16 10:50:00', 26, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `origin_product` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_product` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('agua', 20, 'lanzarote', 'liquido', '2025-02-16 17:14:06', '2025-02-16 17:14:06', 19),
('leche2', 20, 'el campo', 'lacteo', '2025-02-26 10:35:20', '2025-02-26 10:35:20', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `type` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id` int NOT NULL,
  PRIMARY KEY (`id`)
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

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplier_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` int NOT NULL,
  `supplier_phone` int NOT NULL,
  `supplier_origin` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `number_phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_rol` int DEFAULT '2',
  `archivado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_users_roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`name`, `email`, `number_phone`, `address`, `password`, `id`, `created_at`, `updated_at`, `id_rol`, `archivado`) VALUES
('Admin User', 'admin@example.com', '123456789', 'calle de la torre numero 23', '$2y$10$7OaZBz9OAl9LlvIu459NyOOEcXIWdUSQ1iexVx7uhWt3CEcVKlLBW', 1, '2025-02-16 16:30:11', '2025-02-24 09:18:06', 1, 0),
('asds', 'dani@email.com', NULL, NULL, '$2y$10$15LmsOR/Ay/zHtnPNCOznu4WwYAtnik6f.kQ.paDGVTSxquuNzEku', 2, '2025-02-16 18:03:55', '2025-02-24 09:18:15', 2, 1),
('Normal User', 'user@example.com', NULL, NULL, 'hashed_password', 7, '2025-02-16 16:30:11', '2025-02-16 16:30:11', 2, 0),
('daniel', 'test2@gmail.com', NULL, NULL, '$2y$10$W9bLDyPHnjKjgwNMsJT8.O5m56KUJUrEc8Tb1PUF1OLS9ZGHOVYgu', 14, '2025-02-16 16:15:25', '2025-02-16 17:02:57', 2, 1),
('María Gómez', 'maria@example.com', NULL, NULL, '123456', 16, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Carlos López', 'carlos@example.com', NULL, NULL, '123456', 17, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Ana Torres', 'ana@example.com', NULL, NULL, '123456', 18, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 1, 0),
('Luis Fernández', 'luis@example.com', NULL, NULL, '123456', 19, '2025-02-19 17:21:12', '2025-02-19 17:21:12', 2, 0),
('Sofía Ramírez', 'sofia@example.com', NULL, NULL, '123456', 20, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Pedro Castillo', 'pedro@example.com', NULL, NULL, '123456', 21, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 1, 0),
('Laura Mendoza', 'laura@example.com', NULL, NULL, '123456', 22, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Diego Herrera', 'diego@example.com', NULL, NULL, '123456', 23, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 2, 0),
('Elena Vargas', 'elena@example.com', NULL, NULL, '123456', 24, '2025-02-16 17:21:12', '2025-02-16 17:21:12', 1, 0),
(NULL, 'dani@email.com', NULL, NULL, '$2y$10$uHAh02WWpY1phqfpf/crLO5wrETtFdBlH/zNoRWd6xDpr7TVgjqa6', 25, '2025-02-16 17:54:18', '2025-02-16 17:54:18', 2, 0),
('root', 'root@gmail.com', NULL, NULL, '$2y$10$nRJn/jbGUvESrUWgqOHnRuT.9yz/X5N.NHDLy3GX.IrTiFjyqo7zG', 27, '2025-02-26 07:23:21', '2025-02-26 07:23:21', 2, 0),
('root2', 'root2@gmail.com', NULL, NULL, '$2y$10$KlY4hUll/.dYZLXJoORFpuW5qg02SDhK4V.mVzzmFseM0VZ77rb8.', 28, '2025-02-26 08:41:53', '2025-02-26 08:41:53', 2, 0),
('root3', 'root3@gmail.com', NULL, NULL, '$2y$10$g4hKEFWJZfYCM9bCVIITs.XqHl2CRLVmq6PHcAd2..SjqLiQ85qUC', 29, '2025-02-26 08:49:45', '2025-02-26 08:49:45', 2, 0),
('prueba', 'prueba@gmail.com', NULL, NULL, '$2y$10$qtI7QlZzFAfEsNZPs3AUwORHs2JDRx/G8T4PY9TSW3BgLrvideu/m', 30, '2025-02-26 09:00:09', '2025-02-26 09:00:09', 2, 0),
('prueba2', 'prueba2@gmail.com', NULL, NULL, '$2y$10$c6tgXhH/NtJlkv62x4j6S.DzOj74BrMkA1G2cp2tw/S6TLluLA6Ky', 31, '2025-02-26 10:57:01', '2025-02-26 10:57:01', 2, 0),
('prueba5', 'prueba5@gmail.com', NULL, NULL, '$2y$10$F8dfb7tbP.TWAUVY0OFSSe.iM0w9uQvrZBKEv.tZ7DElJlE5rxyti', 32, '2025-02-26 11:31:20', '2025-02-26 11:31:20', 2, 0),
('juanprueba', 'prueba43@gmail.com', NULL, NULL, '$2y$10$P3AG1whitbAoet.soaHROOlV4WzK6zyCSw/Syj7Wp5oxxA8lNAIx.', 33, '2025-02-26 12:14:09', '2025-02-26 12:14:09', 2, 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
