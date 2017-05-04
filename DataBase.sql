drop database if exists Apuntes;
create database Apuntes;

use Apuntes;


    --    AÑO    --
create table ANIO (
    IdAnio    int(11)   not null,
    Anio      char(9),
    unique (Anio),
    primary key (IdAnio)
);


    --   ESTUDIOS    --
create table ESTUDIOS (
    IdEstudios    int(11)        not null,
    Nombre        varchar(50)    not null,

    primary key (IdEstudios)
);


    --   TIPO    --
create table TIPO (
    IdTipo    int(11)        not null,
    Nombre    varchar(25)    not null,

    primary key (IdTipo)
);


    --   INVITACION    --
create table INVITACION (
    IdCodigo    int(11),
    Codigo      char(32)    not null,

    primary key (IdCodigo)
);


    --   ASIGNATURA    --
create table ASIGNATURA (
    IdAsignatura    int(11)         not null,
    Codigo          varchar(6)     not null,
    Nombre          varchar(100)    not null,
    Estudios        int(11)         not null,
    Curso           int(1)          not null,

    primary key    (IdAsignatura),
    foreign key    (Estudios)        references ESTUDIOS(IdEstudios),

    unique (codigo)
);


    --   USUARIO    --
create table USUARIO (
    IdUsuario       int(11),
    Nombre          varchar(30)    not null,
    Apellido1       varchar(30)    not null,
    Apellido2       varchar(30),
    Password        varchar(32)    not null,
    Nick            varchar(20)    not null,
    Email           varchar(50)    not null,
    Puntuacion      float, 			--- Ésta se calculará con un método 
    Estudios        int(11),

    unique (Nick),
   unique (Nombre, Apellido1, Apellido2),	 ---Puede haber dos usuarios con el mismo nombre y apellidos

    primary key    (IdUsuario),
    foreign key    (Estudios)   references  ESTUDIOS(IdEstudios)
);


    --   SESION    --
create table SESION (
    IdSesion    varchar(32)    not null,
    IdUsuario   int(11)    not null,

    primary key    (IdSesion),
    foreign key    (IdUsuario)  references  USUARIO(IdUsuario)
);


    --   DOCUMENTOS    --
create table DOCUMENTOS (
    IdDocumento   int(11)       not null,
    Titulo        varchar(50)   not null,
    Usuario       int(11)	not null,
    FechaSubida   datetime      default current_timestamp,
    Tipo          int(11)       not null,
    Anio          int(11)       not null,
    Documento     varchar(50)   not null,
    Hash          varchar(32)   not null,
    Asignatura    int(11)       not null,
    Comentario    varchar(500),
    Puntuacion    float,

    unique (Hash),

    primary key   (IdDocumento),
    foreign key   (Usuario)     references  USUARIO(IdUsuario),
    foreign key   (Tipo)        references  TIPO(IdTipo),
    foreign key   (Anio)        references  ANIO(IdAnio),
    foreign key   (Asignatura)  references  ASIGNATURA(IdAsignatura)
);


    --   COMENTARIOS    --
create table COMENTARIOS (
    IdComentario    int(11),
    IdUsuario       int(11),
    IdDocumento     int(11),
    Puntuacion      float,
    Comentario      varchar(300),
    Fecha           date,
    Pseudonimo      char(12),

    primary key    (IdComentario),
    foreign key    (IdUsuario)      references  USUARIO(IdUsuario),
    foreign key    (IdDocumento)    references  DOCUMENTOS(IdDocumento),

    constraint usr_apunt  unique (IdUsuario, IdDocumento),
    constraint apunt_pseu unique (IdDocumento , Pseudonimo)
	---,

    ---check (puntuacion < 5.0) No funciona en MySQL
);
