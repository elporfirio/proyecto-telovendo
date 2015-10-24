-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 05-04-2013 a las 01:24:10
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `venta_juegos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_consolas`
--

CREATE TABLE IF NOT EXISTS `cat_consolas` (
  `idcat_consolas` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idcat_consolas`),
  UNIQUE KEY `idcat_consolas_UNIQUE` (`idcat_consolas`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `cat_consolas`
--

INSERT INTO `cat_consolas` (`idcat_consolas`, `nombre`) VALUES
(5, 'Nintendo 3DS'),
(3, 'Nintendo Wii'),
(1, 'Play Station 3'),
(4, 'PS Vita'),
(2, 'XBOX 360');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_generos`
--

CREATE TABLE IF NOT EXISTS `cat_generos` (
  `idcat_generos` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idcat_generos`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `cat_generos`
--

INSERT INTO `cat_generos` (`idcat_generos`, `nombre`) VALUES
(1, 'acción'),
(2, 'aventura'),
(5, 'baile'),
(3, 'carreras'),
(4, 'disparos'),
(7, 'musical'),
(8, 'pelea'),
(9, 'RPG'),
(6, 'terror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
  `idcomentarios` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_juego` int(11) NOT NULL,
  `comentario` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`idcomentarios`),
  UNIQUE KEY `idcomentarios_UNIQUE` (`idcomentarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idcomentarios`, `id_usuario`, `id_juego`, `comentario`, `fecha`) VALUES
(1, 1, 1, 'Comentario comentarin de la comentadera me ', '0000-00-00 00:00:00'),
(2, 11, 0, 'este es un comentario', '2013-04-02 19:44:14'),
(3, 11, 1, 'Nuevo juego', '2013-04-02 19:45:06'),
(4, 11, 1, 'Este es otro comentario', '2013-04-02 20:06:42'),
(5, 11, 2, 'Vamos a insertar un nuevo comentario', '2013-04-02 20:07:07'),
(6, 1, 1, 'Gracias te lo vendo en 1 varo llevelo llevelo', '2013-04-02 20:14:55'),
(7, 19, 2, 'Otro comentarios', '2013-04-03 23:16:03'),
(8, 19, 2, 'Y muchos comentarios mas por que me encanta comentar y comentar y comentar y comentar', '2013-04-03 23:16:20'),
(9, 19, 2, 'Y muchos comentarios mas por que me encanta comentar y comentar y comentar y comentarY muchos comentarios mas por que me encanta comentar y comentar y comentar y comentarY muchos comentarios mas por que me encanta comentar y comentar y comentar y comentarY muchos comentarios mas por que me encanta comentar y comentar y comentar y comentarY muchos comentarios mas por que me encanta comentar y comen', '2013-04-03 23:39:30'),
(10, 19, 9, 'Nuevo comentario\r\n', '2013-04-04 00:04:31'),
(11, 1, 1, 'comentario comentarin comentario comentarin', '2013-04-04 02:07:55'),
(12, 1, 1, '', '2013-04-04 02:11:27'),
(13, 1, 1, '', '2013-04-04 02:11:36'),
(14, 1, 1, '', '2013-04-04 02:15:23'),
(15, 1, 1, 'Gracias por el comentario', '2013-04-04 02:15:41'),
(16, 1, 8, 'Hola k ase comprando juegos o que hace', '2013-04-04 02:20:18'),
(17, 1, 8, 'Mauricio Mauricio Mauricio', '2013-04-04 02:22:42'),
(18, 1, 16, 'Nuevo comentario\r\n', '2013-04-04 23:42:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE IF NOT EXISTS `juegos` (
  `idjuegos` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `idconsola` int(11) NOT NULL,
  `idgenero` int(11) NOT NULL,
  `descripcion` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `portada` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idjuegos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`idjuegos`, `idusuario`, `nombre`, `idconsola`, `idgenero`, `descripcion`, `portada`, `precio`) VALUES
(1, 1, 'Crash Bandicoot 3: Warped', 1, 2, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel lectus ligula. Proin non ipsum lacus, sit amet vehicula justo. Quisque nec dui non eros luctus rutrum. Praesent blandit neque a nulla facilisis eget venenatis ante rhoncus. Ut quam elit, egestas ut rutrum quis, sodales eu nisi. Curabitur vehicula laoreet sagittis. Phasellus viverra metus a nibh imperdiet et dignissim est consectetur', 'f', '0'),
(2, 1, 'Ridge Racer', 3, 6, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel lectus ligula. Proin non ipsum lacus, sit amet vehicula justo. Quisque nec dui non eros luctus rutrum. Praesent blandit neque a nulla facilisis eget venenatis ante rhoncus. Ut quam elit, egestas ut rutrum quis, sodales eu nisi. Curabitur vehicula laoreet sagittis. Phasellus viverra metus a nibh imperdiet et dignissim est consectetur', NULL, '0'),
(3, 1, 'nombre del juego', 0, 0, '', '', '21'),
(4, 1, 'nombre del juego', 0, 0, '', '', '21'),
(5, 1, 'nombre del juego', 0, 0, '', '', '21'),
(6, 1, 'nombre del juego', 0, 0, '', '', '21'),
(7, 11, 'nombre del juego', 0, 0, '', '', '21'),
(8, 3, 'Starcraft 3', 4, 2, 'Muchas descripciones pero pocas cosas', '', '21'),
(9, 19, 'HALO', 2, 4, 'Halo adventure es una historia de', '20130403_0311_halo.jpg', '199'),
(10, 0, '', 0, 0, '', '', '0'),
(11, 1, '', 0, 0, '', '', '0'),
(12, 1, '', 0, 0, '', '', '0'),
(13, 1, '', 0, 0, '', '', '0'),
(14, 1, '', 0, 0, '', '', '0'),
(15, 1, '', 0, 0, '', '', '0'),
(16, 1, 'Max Steel', 4, 2, 'Max Steel es una linea de juguetes creada por Mattel en 1999. Tuvo una serie animada de TV de Ciencia Ficcion, Animación 3D y CGI homónima transmitida desde el 25 de Febrero del 2000 hasta el 15 de Enero del 2002. Wikipedia', '20130404_4157_425147dz.jpg', '145');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id unico de usuarios',
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `contrasena` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idusuarios`),
  UNIQUE KEY `idusuarios_UNIQUE` (`idusuarios`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuarios`, `nombre`, `usuario`, `contrasena`, `email`) VALUES
(1, 'Porfirio Chavez', 'elporfirio', '123456', ''),
(3, 'Rogelio', 'roger', 'contrasena', 'email'),
(11, 'Nacho marvan', 'nacho', 'contrasena', 'soynacho@gmail.com'),
(12, '', '', '', ''),
(16, 'Otro usuario', 'usiarin', 'mi contraseña', 'contrasena'),
(19, 'Cesar Medrano', 'cesarin', 'cesarin', 'cesar@gmail.com'),
(22, 'Cesar Medrano', 'cesarino', '123456', 'cesar@gmail.com'),
(24, 'Cesar Medrano', 'cesarino2', 'qwer', 'cesar@gmail.com'),
(26, 'Cesar Medrano', 'cesarino3', '12314124', 'cesar@gmail.com'),
(27, 'Cesar Medrano', 'cesarino33', 'asdasdsada', 'cesar@gmail.com'),
(28, 'Cesar Medrano', 'cesarino33d', 'adsad', 'cesar@gmail.com'),
(29, 'nombre de', 'isaruoioas', 'w14234', 'qweqwewqe'),
(30, 'nombre de', 'isaruoioasasda', 'adasdada', 'qweqwewqe');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
