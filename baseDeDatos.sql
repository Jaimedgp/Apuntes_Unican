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
(6, '2016/2017'),
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
(1, 'G31', 'Física Básica Experimental I: Movimiento, Fuerza, Astronomía', 0, 1),
(2, 'G32', 'Física Básica Experimental II: Ondas: Luz y Sonido', 0, 1),
(3, 'G39', 'Herramientas Computacionales en el Laboratorio', 0, 1),
(4, 'G35', 'Matemáticas I: Álgebra Lineal y Geometría', 0, 1),
(5, 'G36', 'Matemáticas II: Cálculo Diferencial', 0, 1),
(6, 'G33', 'Física Básica Experimental III: La Materia y sus Propiedades', 0, 1),
(7, 'G34', 'Física Básica Experimental IV: Circuitos y Electrónica', 0, 1),
(8, 'G38', 'Laboratorio Multidisciplinar', 0, 1),
(9, 'G37', 'Matemáticas III: Cálculo Integral', 0, 1),
(10, 'G40', 'Programación', 0, 1),

(11, 'G53', 'Termodinámica', 0, 2),
(12, 'G51', 'Electricidad y magnetismo', 0, 2),
(13, 'G55', 'Física Cuántica y Estructura de la Materia I: Fundamentales', 0, 2),
(14, 'G1722', 'Habilidades, Valores y Competencias Transversales', 0, 2),
(15, 'G62', 'Laboratorio de Física I', 0, 2),
(16, 'G63', 'Laboratorio de Física II', 0, 2),
(17, 'G49', 'Mecánica Clásica y Relatividad', 0, 2),
(18, 'G59', 'Ecuaciones Diferenciales Ordinarias', 0, 2),
(19, 'G60', 'Ecuaciones Derivadas Parciales', 0, 2),
(20, 'G261', 'Inglés', 0, 2),

(21, 'G54', 'Física estadística', 0, 3),
(22, 'G56', 'Física Cuántica II: Átomos, Moléculas y Sólidos', 0, 3),
(23, 'G57', 'Cuántica III', 0, 3),
(24, 'G58', 'Cuántica IV', 0, 3),
(25, 'G64', 'Laboratorio de Física III', 0, 3),
(26, 'G65', 'Laboratorio de Física IV', 0, 3),
(27, 'G61', 'Métodos numéricos', 0, 3),
(28, 'G52', 'Óptica y electromagnetismo', 0, 3),
(29, 'G50', 'Astronomía', 0, 3),
(30, 'G66', 'Historia y panorama de la ciencia', 0, 3),
(31, 'G1778', 'Experimental optics', 0, 3),
(32, 'G1776', 'Astronomy', 0, 3),

(33, 'G80', 'Advanced Computation', 0, 4),
(34, 'G79', 'Advanced Experimental Techniques (1C)', 0, 4),
(35, 'G69', 'Astrofísica', 0, 4),
(36, 'G77', 'Electrónica Aplicada', 0, 4),
(37, 'G78', 'Experimentación Didáctica', 0, 4),
(38, 'G76', 'Física de la Tierra', 0, 4),
(39, 'G70', 'Física de Materiales', 0, 4),
(40, 'G71', 'Física de Partículas Elementales', 0, 4),
(41, 'G72', 'Fotónica', 0, 4),
(42, 'G74', 'Fuentes de Energía', 0, 4),
(43, 'G68', 'Mecánica Cuántica', 0, 4),
(44, 'G73', 'Química', 0, 4),
(45, 'G75', 'Radiofísica', 0, 4),
(46, 'G1775', 'Advanced Experimental Techniques (2C)', 0, 4),
(47, 'G1777', 'Particle Physics', 0, 4),
(48, 'G1779', 'Physics of Materials', 0, 4),
(49, 'G67', 'Proyectos: Concepción, Desarrollo y Herramientas', 0, 4),
(50, 'G1682', 'Computación Avanzada', 0, 4),
(51, 'G1681', 'Técnicas Experimentales Avanzadas', 0, 4),

(52, 'G42', 'Álgebra Lineal I', 1, 1),
(53, 'G41', 'Cálculo Diferencial', 1, 1),
(54, 'G46', 'Física Básica Experimental', 1, 1),
(55, 'G1725', 'Habilidades, Valores y Competencias Transversales', 1, 1),
(56, 'G43', 'Introducción al Lenguaje Matemático', 1, 1),
(57, 'G44', 'Cálculo Integral', 1, 1),
(58, 'G48', 'Estadística Básica', 1, 1),
(59, 'G45', 'Geometría, Arte y Naturaleza', 1, 1),
(60, 'G260', 'Inglés', 1, 1),
(61, 'G47', 'Programación', 1, 1),

(62, 'G89', 'Álgebra Lineal II', 1, 2),
(63, 'G84', 'Ampliación de Cálculo Diferencial', 1, 2),
(64, 'G93', 'Cálculo de Probabilidades', 1, 2),
(65, 'G83', 'Ecuaciones Diferenciales Ordinarias', 1, 2),
(66, 'G95', 'Topología', 1, 2),
(67, 'G86', 'Ampliación de Cálculo Integral', 1, 2),
(68, 'G98', 'Cálculo Numérico I', 1, 2),
(69, 'G90', 'Estructuras Algebraicas', 1, 2),
(70, 'G96', 'Geometría de Curvas y Superficies', 1, 2),
(71, 'G85', 'Introducción a las Ecuaciones en Derivadas Parciales', 1, 2),

(72, 'G99', 'Cálculo Numérico II', 1, 3),
(73, 'G1752', 'Hilbert Spaces', 1, 3),
(74, 'G1683', 'Matemática Discreta', 1, 3),
(75, 'G94', 'Statistical Inference', 1, 3),
(76, 'G91', 'Teoría de Galois', 1, 3),
(77, 'G97', 'Teoría Global de Superficies', 1, 3),
(78, 'G92', 'Álgebra Conmutativa', 1, 3),
(79, 'G101', 'Discrete Mathematics', 1, 3),
(80, 'G88', 'Espacios Hilbert', 1, 3),
(81, 'G1684', 'Inferencia Estadística', 1, 3),
(82, 'G100', 'Optimización I', 1, 3),
(83, 'G102', 'Taller de Modelización', 1, 3),
(84, 'G87', 'Variable Compleja', 1, 3),

(85, 'G1894', 'Advanced Probability', 1, 4),
(86, 'G107', 'Ampliación de Análisis', 1, 4),
(87, 'G108', 'Ampliación de Probabilidades', 1, 4),
(88, 'G104', 'Análisis Funcional', 1, 4),
(89, 'G117', 'Análisis y Diseño de Algoritmos', 1, 4),
(90, 'G902', 'Análisis y Evaluación de Inversiones', 1, 4),
(91, 'G114', 'Cálculo Numérico III', 1, 4),
(92, 'G118', 'Economía y Administración de Empresas', 1, 4),
(93, 'G651', 'Estructuras de Datos', 1, 4),
(94, 'G899', 'Herramientas para la Decisión en Operaciones', 1, 4),
(95, 'G655', 'Introducción a los Sistemas Inteligentes', 1, 4),
(96, 'G680', 'Modelos de Cálculo', 1, 4),
(97, 'G115', 'Optimización II', 1, 4),
(98, 'G106', 'Teoría Cualitativa de EDO', 1, 4),
(99, 'G111', 'Topología Algebraica', 1, 4),
(100, 'G110', 'Variedades Diferenciables', 1, 4),
(101, 'G116', 'Álgebra Computacional', 1, 4),
(102, 'G652', 'Algorítmica y Complejidad', 1, 4),
(103, 'G113', 'Ampliación de Álgebra', 1, 4),
(104, 'G109', 'Ampliación de Estadística', 1, 4),
(105, 'G913', 'Análisis de los Mercados de Valores', 1, 4),
(106, 'G112', 'Geometría Proyectiva y Algebraica', 1, 4),
(107, 'G907', 'Investigación de Mercados', 1, 4),
(108, 'G345', 'Macroeconomía', 1, 4),
(109, 'G119', 'Matemáticas para la Educación Secundaria', 1, 4),
(110, 'G271', 'Métodos de Programación', 1, 4),
(111, 'G1753', 'Numerical Analysis III', 1, 4),
(112, 'G105', 'Teoría de la Medida', 1, 4),
(113, 'G120', 'Prácticas Externas I', 1, 4),
(114, 'G218', 'Prácticas Externas II', 1, 4),
(115, 'G103', 'Trabajo Fin de Grado', 1, 4),


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
