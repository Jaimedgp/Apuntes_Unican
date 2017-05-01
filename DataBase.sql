create database if not exists Apuntes;

use Apuntes;


    --    AÑO    --
create table ANIO (
    idAnio    int(11)   not null,
    anio      char(9),
    unique (anio),
    primary key (idAnio)
);


    --   ESTUDIOS    --
create table ESTUDIOS (
    idEstudios    int(11)        not null,
    nombre        varchar(12)    not null,

    primary key (idEstudios)
);


    --   TIPO    --
create table TIPO (
    idTipo    int(11)        not null,
    nombre    varchar(12)    not null,

    primary key (idTipo)
);


    --   INVITACION    --
create table INVITACION (
    idCodigo    int(11),
    codigo      char(12)    not null,

    primary key (idCodigo)
);


    --   ASIGNATURA    --
create table ASIGNATURA (
    idAsignatura    int(11)         not null,
    codigo          varchar(10)     not null,
    nombre          varchar(100)    not null,
    estudios        int(11)         not null,
    curso           int(1)          not null,

    primary key    (idAsignatura),
    foreign key    (estudios)        references ESTUDIOS(idEstudios),

    unique (codigo)
);


    --   USUARIO    --
create table USUARIO (
    idUsuario       int(11),
    nombre          varchar(30)    not null,
    apellido1       varchar(30)    not null,
    apellido2       varchar(30),
    password        varchar(34)    not null,
    nick            varchar(20)    not null,
    email           varchar(50)    not null,
    puntuación      float,
    estudios        int(11),

    unique (nick),
    unique (nombre, apellido1, apellido2),

    primary key    (idUsuario),
    foreign key    (estudios)   references  ESTUDIOS(idEstudios)
);


    --   SESION    --
create table SESION (
    idSesion    int(11)    not null,
    idUsuario   int(11)    not null,

    primary key    (idSesion),
    foreign key    (idUsuario)  references  USUARIO(idUsuario)
);


    --   DOCUMENTOS    --
create table DOCUMENTOS (
    idDocumento   int(11)       not null,
    titulo        varchar(50)   not null,
    usuario       int(11),
    fechaSubida   datetime      default current_timestamp,
    tipo          int(11)       not null,
    anio          int(11)       not null,
    documento     varchar(50)   not null,
    hash          varchar(32)   not null,
    asignatura    int(11)       not null,
    comentario    varchar(300),
    puntuacion    float,

    unique (hash),

    primary key   (idDocumento),
    foreign key   (usuario)     references  USUARIO(idUsuario),
    foreign key   (tipo)        references  TIPO(idTipo),
    foreign key   (anio)        references  ANIO(idAnio),
    foreign key   (asignatura)  references  ASIGNATURA(idAsignatura)
);


    --   COMENTARIOS    --
create table COMENTARIOS (
    idComentario    int(11),
    idUsuario       int(11),
    idDocumento     int(11),
    puntuacion      float,
    comentario      varchar(300),
    fecha           date,
    pseudonimo      char(12),

    primary key    (idComentario),
    foreign key    (idUsuario)      references  USUARIO(idUsuario),
    foreign key    (idDocumento)    references  DOCUMENTOS(idDocumento),

    constraint usr_apunt  unique (idUsuario, idDocumento),
    constraint apunt_pseu unique (idDocumento , pseudonimo),

    check (puntuacion < 5.0)
);
