-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-05-2017 a las 12:38:38
-- Versión del servidor: 5.7.17-0ubuntu0.16.10.1
-- Versión de PHP: 7.0.15-0ubuntu0.16.10.4

--
-- Base de datos: `Apuntes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Anio`
--

CREATE TABLE `Anio` (
  `IdAnio` int(11) NOT NULL,
  `Anio` char(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Anio`
--

INSERT INTO `Anio` (`IdAnio`, `Anio`) VALUES
(0, '2010/2011'),
(1, '2011/2012'),
(2, '2012/2013'),
(3, '2013/2014'),
(4, '2014/2015'),
(5, '2015/2016'),
(6, '2016/2017');
(7, '2017/2018');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Asignatura`
--

CREATE TABLE `Asignatura` (
  `IdAsignatura` int(11) NOT NULL,
  `Codigo` varchar(6) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Estudios` int(11) NOT NULL,
  `Curso` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Asignatura`
--

INSERT INTO `Asignatura` (`IdAsignatura`, `Codigo`, `Nombre`, `Estudios`, `Curso`) VALUES
(1, 'G53', 'Termodinámica', 0, 2),
(2, 'G51', 'Electricidad y magnetismo', 0, 2),
(3, 'G55', 'Física Cuántica y Estructura de la Materia I: Fundamentales', 0, 2),
(4, 'G1722', 'Habilidades, Valores y Competencias Transversales', 0, 2),
(5, 'G62', 'Laboratorio de Física I', 0, 2),
(6, 'G63', 'Laboratorio de Física II', 0, 2),
(7, 'G49', 'Mecánica Clásica y Relatividad', 0, 2),
(8, 'G59', 'Ecuaciones Diferenciales Ordinarias', 0, 2),
(9, 'G60', 'Ecuaciones Derivadas Parciales', 0, 2),
(10, 'G261', 'Inglés', 0, 2),

(11, 'G54', 'Física estadística', 0, 2),
(12, 'G56', 'Física Cuántica II: Átomos, Moléculas y Sólidos', 0, 2),
(13, 'G57', 'Cuántica III', 0, 2),
(14, 'G58', 'Cuántica IV', 0, 2),
(15, 'G64', 'Laboratorio de Física III', 0, 2),
(16, 'G65', 'Laboratorio de Física IV', 0, 2),
(17, 'G61', 'Métodos numéricos', 0, 2),
(18, 'G52', 'Óptica y electromagnetismo', 0, 2),
(19, 'G50', 'Astronomía', 0, 2),
(20, 'G66', 'Historia y panorama de la ciencia', 0, 2),
(21, 'G1778', 'Experimental optics', 0, 2),
(22, 'G1776', 'Astronomy', 0, 2);





-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Comentarios`
--

CREATE TABLE `Comentarios` (
  `IdComentario` int(11) NOT NULL,
  `IdUsuario` int(11) DEFAULT NULL,
  `IdDocumento` int(11) DEFAULT NULL,
  `Puntuacion` float DEFAULT NULL,
  `Comentario` varchar(300) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Pseudonimo` char(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Documentos`
--

CREATE TABLE `Documentos` (
  `IdDocumento` int(11) NOT NULL,
  `Titulo` varchar(50) NOT NULL,
  `Usuario` int(11) NOT NULL,
  `FechaSubida` datetime DEFAULT CURRENT_TIMESTAMP,
  `Tipo` int(11) NOT NULL,
  `Anio` int(11) NOT NULL,
  `Documento` varchar(50) NOT NULL,
  `Hash` varchar(32) NOT NULL,
  `Asignatura` int(11) NOT NULL,
  `Comentario` varchar(500) DEFAULT NULL,
  `Puntuacion` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Estudios`
--

CREATE TABLE `Estudios` (
  `IdEstudios` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Estudios`
--

INSERT INTO `Estudios` (`IdEstudios`, `Nombre`) VALUES
(0, 'Fisica'),
(1, 'Matematicas'),
(2, 'Ingenieria Informatica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Invitacion`
--

CREATE TABLE `Invitacion` (
  `IdCodigo` int(11) NOT NULL,
  `Codigo` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sesion`
--

CREATE TABLE `Sesion` (
  `IdSesion` varchar(32) NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tipo`
--

CREATE TABLE `Tipo` (
  `IdTipo` int(11) NOT NULL,
  `Nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Tipo`
--

INSERT INTO `Tipo` (`IdTipo`, `Nombre`) VALUES
(0, 'Apuntes'),
(1, 'Apuntes Profesor'),
(2, 'Examen');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellido1` varchar(30) NOT NULL,
  `Apellido2` varchar(30) DEFAULT NULL,
  `Password` varchar(32) NOT NULL,
  `Nick` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Estudios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Indices de la tabla `Anio`
--
ALTER TABLE `Anio`
  ADD PRIMARY KEY (`IdAnio`),
  ADD UNIQUE KEY `Anio` (`Anio`);

--
-- Indices de la tabla `Asignatura`
--
ALTER TABLE `Asignatura`
  ADD PRIMARY KEY (`IdAsignatura`),
  ADD UNIQUE KEY `Codigo` (`Codigo`),
  ADD KEY `Estudios` (`Estudios`);

--
-- Indices de la tabla `Comentarios`
--
ALTER TABLE `Comentarios`
  ADD PRIMARY KEY (`IdComentario`),
  ADD UNIQUE KEY `usr_apunt` (`IdUsuario`,`IdDocumento`),
  ADD UNIQUE KEY `apunt_pseu` (`IdDocumento`,`Pseudonimo`);

--
-- Indices de la tabla `Documentos`
--
ALTER TABLE `Documentos`
  ADD PRIMARY KEY (`IdDocumento`),
  ADD UNIQUE KEY `Hash` (`Hash`),
  ADD KEY `Usuario` (`Usuario`),
  ADD KEY `Tipo` (`Tipo`),
  ADD KEY `Anio` (`Anio`),
  ADD KEY `Asignatura` (`Asignatura`);

--
-- Indices de la tabla `Estudios`
--
ALTER TABLE `Estudios`
  ADD PRIMARY KEY (`IdEstudios`);

--
-- Indices de la tabla `Invitacion`
--
ALTER TABLE `Invitacion`
  ADD PRIMARY KEY (`IdCodigo`);

--
-- Indices de la tabla `Sesion`
--
ALTER TABLE `Sesion`
  ADD PRIMARY KEY (`IdSesion`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `Tipo`
--
ALTER TABLE `Tipo`
  ADD PRIMARY KEY (`IdTipo`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD UNIQUE KEY `Nick` (`Nick`),
  ADD KEY `Estudios` (`Estudios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Documentos`
--
ALTER TABLE `Documentos`
  MODIFY `IdDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Asignatura`
--
ALTER TABLE `Asignatura`
  ADD CONSTRAINT `Asignatura_ibfk_1` FOREIGN KEY (`Estudios`) REFERENCES `Estudios` (`IdEstudios`);

--
-- Filtros para la tabla `Comentarios`
--
ALTER TABLE `Comentarios`
  ADD CONSTRAINT `Comentarios_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`),
  ADD CONSTRAINT `Comentarios_ibfk_2` FOREIGN KEY (`IdDocumento`) REFERENCES `Documentos` (`IdDocumento`);

--
-- Filtros para la tabla `Documentos`
--
ALTER TABLE `Documentos`
  ADD CONSTRAINT `Documentos_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `Usuario` (`IdUsuario`),
  ADD CONSTRAINT `Documentos_ibfk_2` FOREIGN KEY (`Tipo`) REFERENCES `Tipo` (`IdTipo`),
  ADD CONSTRAINT `Documentos_ibfk_3` FOREIGN KEY (`Anio`) REFERENCES `Anio` (`IdAnio`),
  ADD CONSTRAINT `Documentos_ibfk_4` FOREIGN KEY (`Asignatura`) REFERENCES `Asignatura` (`IdAsignatura`);

--
-- Filtros para la tabla `Sesion`
--
ALTER TABLE `Sesion`
  ADD CONSTRAINT `Sesion_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuario` (`IdUsuario`);

--
-- Filtros para la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`Estudios`) REFERENCES `Estudios` (`IdEstudios`);
