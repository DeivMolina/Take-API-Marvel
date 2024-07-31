-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2024 a las 12:36:46
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `covaltomarvel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `characters`
--

CREATE TABLE `characters` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail_url` text NOT NULL,
  `resourceURI` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `characters`
--

INSERT INTO `characters` (`id`, `name`, `description`, `thumbnail_url`, `resourceURI`, `modified`) VALUES
(1009144, 'A.I.M', 'AIM es una organización terrorista que afectara a los Vengadores.', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1009144', '2024-07-31 10:21:25'),
(1009146, 'Abomination (Emil Blonsky)', 'Formerly known as Emil Blonsky, a spy of Soviet Yugoslavian origin working for the KGB, the Abomination gained his powers after receiving a dose of gamma radiation similar to that which transformed Bruce Banner into the incredible Hulk.', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1009146', '2012-03-20 12:32:12'),
(1009148, 'Absorbing Man', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1009148', '2013-10-24 14:32:08'),
(1009149, 'Abyss', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1009149', '2014-04-29 14:10:43'),
(1009150, 'Agent Zero', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1009150', '1969-12-31 19:00:00'),
(1010354, 'Adam Warlock', 'Adam Warlock is an artificially created human who was born in a cocoon at a scientific complex called The Beehive.', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1010354', '2013-08-07 13:49:06'),
(1010699, 'Aaron Stack', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1010699', '1969-12-31 19:00:00'),
(1010903, 'Abyss (Age of Apocalypse)', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1010903', '1969-12-31 19:00:00'),
(1011136, 'Air-Walker (Gabriel Lan)', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1011136', '1969-12-31 19:00:00'),
(1011175, 'Aginar', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1011175', '1969-12-31 19:00:00'),
(1011198, 'Agents of Atlas', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1011198', '2016-02-03 10:25:22'),
(1011266, 'Adam Destine', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1011266', '1969-12-31 19:00:00'),
(1011297, 'Agent Brand', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1011297', '2013-10-24 13:09:30'),
(1011334, '3-D Man', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1011334', '2014-04-29 14:18:17'),
(1012717, 'Agatha Harkness', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1012717', '2021-08-06 11:30:56'),
(1016823, 'Abomination (Ultimate)', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1016823', '2012-07-10 19:11:52'),
(1017100, 'A-Bomb (HAS)', 'Rick Jones has been Hulk\'s best bud since day one, but now he\'s more than a friend...he\'s a teammate! Transformed by a Gamma energy explosion, A-Bomb\'s thick, armored skin is just as strong and powerful as it is blue. And when he curls into action, he uses it like a giant bowling ball of destruction! ', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1017100', '2013-09-18 15:54:04'),
(1017851, 'Aero (Aero)', '', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', 'http://gateway.marvel.com/v1/public/characters/1017851', '2021-08-27 17:52:34'),
(3841452, 'Mr Boom', 'Especialista en bombas', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', NULL, '2024-07-31 09:50:46'),
(4955106, 'Iron Man', 'Hombre de Hierro', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', NULL, '2024-07-31 09:44:27'),
(5482568, 'Hulk', 'Tiene fuerza descomunal', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', NULL, '2024-07-31 09:31:15'),
(8769541, 'B Bomb', 'Rick Jones has been Hulks best bud since day one, but now hes more than a friend.', 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', NULL, '2024-07-31 09:33:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
