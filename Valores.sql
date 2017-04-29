use Apuntes;

insert into ANIO (idAnio ,Anio       )
          values (0      ,'2010/2011'),
          values (1      ,'2011/2012'),
          values (2      ,'2012/2013'),
          values (3      ,'2013/2014'),
          values (4      ,'2014/2015'),
          values (5      ,'2015/2016'),
          values (6      ,'2016/2017')
;

insert into DOCUMENTOS (idApuntes, titulo                           , usuario, fechaSubida        , tipo, anio, documento            , hash                 , comentario                       , asignatura)
                values (2        , 'Examen Parcial Inexistente'     , 1      , 2017-04-05 14:59:09, 1   , 3   , 'examenparcial.pdf'  , '832rn0xyrqx8yfn08'  , 'Examen parcial del año la polka', 2         ),
                values (3        , 'No es lo mismo montar un follón', 1      , 2017-04-06 23:42:54, 0   , 3   , 'noes.pdf'           , ' '                  , 'Libro sobre cosas'              , 3         ),
                values (4        , 'Electromagnetismo inutil'       , 1      , 2017-04-06 23:43:27, 0   , 3   , 'no2es.pdf'          , ' '                  , 'Tengo cien de estos'            , 2         ),
                values (80       , 'Electromagnetismo jodido'       , 2      , 2017-04-15 17:20:20, 0   , 5   , 'documentoFalso.pdf' , '238nx073rnw7'       , 'Electromagnetismo del jodido 
                                                                                                                                                                 jodido, pero jodido de verdad', 2         )
;

insert into ASIGNATURA (idAsignatura, codigo  , nombre                                                       , estudios, curso)
                values (1           , 'G53'   , 'Termodinámica'                                              , 0       , 2    ),
                values (2           , 'G51'   , 'Electricidad y magnetismo'                                  , 0       , 2    ),
                values (3           , 'G55'   , 'Física Cuántica y Estructura de la Materia I: Fundamentales', 0       , 2    ),
                values (4           , 'G1722' , 'Habilidades, Valores y Competencias Transversales'          , 0       , 2    ),
                values (5           , 'G62'   , 'Laboratorio de Física I'                                    , 0       , 2    ),
                values (6           , 'G63'   , 'Laboratorio de Física II'                                   , 0       , 2    ),
                values (7           , 'G49'   , 'Mecánica Clásica y Relatividad'                             , 0       , 2    ),
                values (8           , 'G59'   , 'Ecuaciones Diferenciales Ordinarias'                        , 0       , 2    ),
                values (9           , 'G60'   , 'Ecuaciones Derivadas Parciales'                             , 0       , 2    ),
                values (10          , 'G261'  , 'Inglés'                                                     , 0       , 2    )
;

insert into ESTUDIOS (idEstudios, nombre                  )
              values (0         , 'Fisica'                ),
              values (1         , 'Matematicas'           ),
              values (2         , 'Ingenieria Informatica')
;

insert into SESION (idSesion                          , idUsuario)
            values ('0a5ff911d3af9823ba2d50d77b6a6595', 1        ),
            values ('8f7a2b3dddcf0ad39a4875f62a97907f', 8        )
;

insert into TIPO (idTipo, nombre          )
          values (0     , 'Apuntes'       ),
          values (1     , 'Examen Parcial'),
          values (2     , 'Examen Final'  )
;

insert into USUARIO (idUsuario, nombre , apellido1 , apellido2       , password                          , nick       , email                       )
             values (1        , 'David', 'Iglesias', 'Sánchez'       , '451d8bb9214d5cf16d1f22e5cbeb0ad2', 'Pelu'     , 'davidiglesanchez@gmail.com'),
             values (2        , 'Jaime', 'Díez'    , 'González-Pardo', '81dc9bdb52d04dc20036dbd8313ed055', 'Jaimedgp' , 'davidiglesanchez@gmail.com'),
             values (7        , 'David', 'Iglesias', 'Sánchez'       , '451d8bb9214d5cf16d1f22e5cbeb0ad2', 'davidigle', 'davidiglesanchez@gmail.com'),
             values (8        , 'David', 'Iglesias', 'Sánchez'       , '451d8bb9214d5cf16d1f22e5cbeb0ad2', 'david'    , 'davidiglesanchez@gmail.com')
;