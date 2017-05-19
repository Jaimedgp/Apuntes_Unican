if exists(select * from sys.databases where name='Apuntes')
  drop database Apuntes
go


create database Apuntes;

go

use Apuntes;



    --    AÑO    --
create table ANIO (
    idAnio    int     not null,
    anio      char(9) not null,

    unique (anio),

    primary key (idAnio)
);


    --   ESTUDIOS    --
create table ESTUDIOS (
    idEstudios    int            not null,
    nombre        varchar(12)    not null,
    descripcion    varchar(40), 

    primary key (idEstudios)
);


    --   TIPO    --
create table TIPO (
    idTipo    int            not null,
    nombre    varchar(12)    not null,

    constraint chk_nombre CHECK (nombre in ('Apuntes', 'Apuntes Profesor', 'Examenes')),

    primary key (idTipo)
);


    --   ASIGNATURA    --
create table ASIGNATURA (
    idAsignatura    int             not null,
    codigo          varchar(10)     not null,
    nombre          varchar(100)    not null,
    estudios        int             not null,
    curso           int             not null,
    descripcion     varchar(300),

    constraint chk_curso CHECK (curso between 1 and 4),

    primary key    (idAsignatura),
    foreign key    (estudios)        references ESTUDIOS(idEstudios),

    unique (codigo)
);


    --   USUARIO    --
create table USUARIO (
    idUsuario       int                              not null,
    nombre          varchar(30)                      not null,
    apellido1       varchar(30)                      not null,
    apellido2       varchar(30)                              ,
    password        varchar(34)                      not null,
    nick            varchar(20)                      not null,
    email           varchar(50)                      not null,
    estudios        int                              not null,
    fechaAlta       datetime     default getdate()           ,
    fechaBaja       datetime                                 ,

    constraint chk_fechaSub_fechaBaja  CHECK (fechaBaja > fechaAlta),
    constraint chk_email CHECK (email like '%@%'),

    unique (email),
    unique (nick),

    primary key    (idUsuario),
    foreign key    (estudios)   references  ESTUDIOS(idEstudios)
);


    --   SESION    --
create table SESION (
    idSesion    int    not null,
    idUsuario   int    not null,

    primary key    (idSesion),
    foreign key    (idUsuario)  references  USUARIO(idUsuario)
);


    --   DOCUMENTOS    --
create table DOCUMENTOS (
    idDocumento   int                                     not null,
    titulo        varchar(50)                             not null,
    usuario       int                                     not null,
    fechaSubida   datetime     default current_timestamp          ,
    tipo          int                                     not null,
    anio          int                                     not null,
    documento     varchar(50)                             not null,
    hash          varchar(32)                             not null,
    asignatura    int                                     not null,
    comentario    varchar(300)                            not null,
    fechadescat   datetime                                        ,

    constraint chk_fechaSubida CHECK (fechaSubida < fechadescat),

    unique (hash),

    primary key   (idDocumento),
    foreign key   (usuario)     references  USUARIO(idUsuario),
    foreign key   (tipo)        references  TIPO(idTipo),
    foreign key   (anio)        references  ANIO(idAnio),
    foreign key   (asignatura)  references  ASIGNATURA(idAsignatura)
);


    --   COMENTARIOS    --
create table COMENTARIOS (
    idUsuario       int                                      not null,
    idDocumento     int                                      not null,
    puntuacion      float                                    not null,
    comentario      varchar(300)                             not null,
    fecha           datetime      default current_timestamp          ,
    pseudonimo      char(12)      default 'anonimo'          not null,

    constraint chk_puntuacion CHECK (puntuacion between 0 and 5)

    primary key    (idUsuario, idDocumento),
    foreign key    (idUsuario)      references  USUARIO(idUsuario),
    foreign key    (idDocumento)    references  DOCUMENTOS(idDocumento),

    constraint apunt_pseu unique (idDocumento , pseudonimo)
);


    -- REPORTES --
create table REPORTES (
    idReportes    int                                      not null,
    idDocumento   int                                      not null,
    idUsuario     int                                      not null, -- Usuario que hace el reporte
    fechaReporte  datetime      default current_timestamp          ,
    comentario    varchar(300)                             not null,

    primary key (idReportes),
    foreign key (idDocumento)    references DOCUMENTOS(idDocumento),
    foreign key (idUsuario)      references USUARIO(idUsuario)

);