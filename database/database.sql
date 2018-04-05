-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-04-2018 a las 09:58:47
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `meals_on_wheels`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `restaurant` int(255) DEFAULT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_orders_restautants` (`restaurant`),
  KEY `fk_orders_users` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user`, `created_at`, `restaurant`, `valid`) VALUES
(1, 4, '2018-03-20 09:13:05', 1, 0),
(2, 4, '2018-03-23 09:52:15', 2, 1),
(3, 4, '2018-03-02 00:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `order_id` int(255) DEFAULT NULL,
  `product` int(255) DEFAULT NULL,
  `quantity` int(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_uniques_fields` (`order_id`,`product`),
  KEY `fk_details_products` (`product`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product`, `quantity`) VALUES
(15, 2, 3, 9),
(17, 1, 1, 3),
(24, 1, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `restaurant` int(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_restaurants` (`restaurant`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `restaurant`, `name`, `description`, `price`, `type`) VALUES
(1, 1, 'bocadillo', 'producto', '5.20', 'tapa'),
(3, 2, 'producto2', 'producto', '65.00', 'tapa'),
(4, 1, 'plato de bravas', 'carcasa de bravas', '5.36', 'primer plato'),
(5, 2, 'Aguacate', 'Aguacatedfsf', '2.25', 'postre'),
(24, 1, 'Tortilla de patatas', 'Tortilla de patatas casera a la francesa', '2.25', 'otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user` int(255) DEFAULT NULL,
  `restaurant` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `text` mediumtext,
  `points` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ratings_users` (`user`),
  KEY `fk_ratings_restaurants` (`restaurant`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE IF NOT EXISTS `restaurants` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user` int(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` mediumtext,
  `min_order` decimal(10,2) DEFAULT NULL,
  `delivery_cost` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `num` varchar(50) DEFAULT NULL,
  `post_code` varchar(20) DEFAULT NULL,
  `days` varchar(255) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_restaurants_users` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `restaurants`
--

INSERT INTO `restaurants` (`id`, `user`, `name`, `description`, `min_order`, `delivery_cost`, `image`, `category`, `street`, `num`, `post_code`, `days`, `start_time`, `end_time`) VALUES
(1, 2, 'Restaurante Luna Rosa', 'VEGAN FRIENDLY. Un buffé libre económico y variado que ademas, cuenta con bastantes opciones veganas y vegetarianas, ideal tanto si vas con nenes como para otras reuniones mas intimas o informales, un servicio muy atento y buen ambiente. 100% recomendable.', '5.00', '5.00', NULL, 'oriental', '5', '5', '5', 'a:3:{i:0;s:1:\"m\";i:1;s:1:\"x\";i:2;s:1:\"d\";}', '07:31:00', '05:39:00'),
(2, 2, 'El Rincón de la papa', '¿Los comentarios de HTML dan para un post? ¿Lo merecen siendo tan fáciles de hacer? Yo creo que sí, y si no, me lo cuentas al final en los comentarios.', '2.00', '2.00', '21521549645.jpeg', 'mexicano', '2', '2', '2', 'a:3:{i:0;s:1:\"x\";i:1;s:1:\"j\";i:2;s:1:\"d\";}', '09:00:00', '19:20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nick` varchar(50) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_uniques_fields` (`email`,`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `name`, `surname`, `password`, `nick`, `bio`, `image`) VALUES
(1, 'ROLE_OWNER', 'usuario@usuario.com', 'usuario', 'usuario', 'usuario', 'usuario', NULL, NULL),
(2, 'ROLE_OWNER', 'prueba@prueba.com', 'prueba', 'prueba', '$2y$04$wCyCcX2xREFIbDG7A.37vuY.Nxx4V3ljLmiPB/DMTHcZjOSE1.rNK', 'prueba441', NULL, '21522229983.jpeg'),
(3, 'ROLE_USER', 'hola@1hola.com', NULL, NULL, 'b221d9dbb083a7f33428d7c2a3c3198ae925614d70210e28716ccaa7cd4ddb79', 'hola1', NULL, NULL),
(4, 'ROLE_USER', 'api@api.com', 'Alfonso', NULL, '14c2529eb4498c5d1ffd6915d05bf58a91bdda796af59f41d480d11c099d0479', 'api', NULL, '1522918131.jpeg'),
(12, 'ROLE_OWNER', 'aa@a.com', 'a', 'a', '$2y$04$Myf3WCy7Ymp4UMyyTgetjOSqU26vQmwysnxuWrx6oW1oWCx.3rf7G', 'a', NULL, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_restautants` FOREIGN KEY (`restaurant`) REFERENCES `restaurants` (`id`),
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_details_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_details_products` FOREIGN KEY (`product`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_restaurants` FOREIGN KEY (`restaurant`) REFERENCES `restaurants` (`id`);

--
-- Filtros para la tabla `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_ratings_restaurants` FOREIGN KEY (`restaurant`) REFERENCES `restaurants` (`id`),
  ADD CONSTRAINT `fk_ratings_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `fk_restaurants_users` FOREIGN KEY (`user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
