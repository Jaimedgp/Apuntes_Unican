create database if not exists Apuntes;

use Apuntes;


    --    AÑO    --
create table ANIO (
    idAnio    int(11)   not null,
    anio      char(9)   default(null)
);


    --   DOCUMENTOS    --
create table DOCUMENTO (
    idApuntes     int(11)       not null,
    titulo        varchar(50)   not null,
    usuario       int(11)       not null,
    fechaSubida   datetime      default current_timestamp,
    tipo          int(11)       not null,
    anio          int(11)       not null,
    documento     varchar(50)   not null,
    hash          varchar(32)   not null,
    comentario    varchar(300)  not null,
    asignatura    int(11)       not null
);


    --   ASIGNATURA    --
create table ASIGNATURA (
    idAsignatura    int(11)         not null,
    codigo          varchar(10)     not null,
    nombre          varchar(100)    not null,
    estudios        int(11)         not null,
    curso           int(11)         not null
);


    --   CURSO    --
create table CURSO (
    idCurso	int(11)	not null
);


    --   COMENTARIOS    --
create table COMENTARIOS (
    idComentario    int(11),
    idUsuario       int(11),
    idApuntes       int(11),
    puntuacion      float,
    comentario      varchar(300),
    fecha           date,
    Pseudonimo      char(12),
    constraint pk_coment primary key(idComentarios),
    unique key usr_apunt (idUsuario, idApuntes),
    unique key apunt_pseu (idApunte, pseudonimo)
);


    --   ESTUDIOS    --
create table ESTUDIOS (
    idEstudios    int(11),
    nombre        varchar(12)
);


    --   SESION    --
create table SESION (
    idSesion    int(11),
    idUsuario   int(11)
);


    --   TIPO    --
create table TIPO (
    idTipo    int(11),
    nombre    varchar(12)
);


    --   USUARIO    --
create table USUARIO (
    idUsuario       int(11),
    nombre          varchar(30),
    apellido1       varchar(30),
    apellido2       varchar(30)     default null,
    password        varchar(34),
    nick            varchar(20),
    email           varchar(50)
);


    --   INVITACION    --
create table INVITACION (
    idCodigo    int(11),
    codigo      char(12),
);
