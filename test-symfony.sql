-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-10-2020 a las 19:26:03
-- Versión del servidor: 5.7.31-0ubuntu0.18.04.1
-- Versión de PHP: 5.6.40-30+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `test-symfony`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `observation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`id`, `name`, `last_name`, `email`, `observation`, `created_at`, `updated_at`) VALUES
(20, 'Eliana', 'Monteagudo', 'michi@miau.br', 'yo soy tu gatita', '2020-07-25 21:48:59', '2020-07-25 21:48:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groupclients_clients`
--

CREATE TABLE `groupclients_clients` (
  `client_id` int(11) NOT NULL,
  `groupclient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `groupclients_clients`
--

INSERT INTO `groupclients_clients` (`client_id`, `groupclient_id`) VALUES
(20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_client`
--

CREATE TABLE `group_client` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `group_client`
--

INSERT INTO `group_client` (`id`, `description`) VALUES
(1, 'Grupo A'),
(2, 'Grupo B'),
(3, 'Grupo C');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `groupclients_clients`
--
ALTER TABLE `groupclients_clients`
  ADD PRIMARY KEY (`client_id`,`groupclient_id`),
  ADD KEY `IDX_7A571A8619EB6921` (`client_id`),
  ADD KEY `IDX_7A571A863E1B603E` (`groupclient_id`);

--
-- Indices de la tabla `group_client`
--
ALTER TABLE `group_client`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `group_client`
--
ALTER TABLE `group_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `groupclients_clients`
--
ALTER TABLE `groupclients_clients`
  ADD CONSTRAINT `FK_7A571A8619EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_7A571A863E1B603E` FOREIGN KEY (`groupclient_id`) REFERENCES `group_client` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
