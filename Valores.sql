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

insert into ESTUDIOS (idEstudios, nombre                  )
              values (0         , 'Fisica'                ),
              values (1         , 'Matematicas'           ),
              values (2         , 'Ingenieria Informatica')
;

insert into SESION (idSesion, idUsuario)
            values ('0a5ff911d3af9823ba2d50d77b6a6595', 1),
            values ('8f7a2b3dddcf0ad39a4875f62a97907f', 8)
;

insert into TIPO (idTipo, nombre          )
          values (0     , 'Apuntes'       ),
          values (1     , 'Examen Parcial'),
          values (2     , 'Examen Final'  )
;
