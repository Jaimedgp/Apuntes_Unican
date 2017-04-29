create database if not exists Apuntes;

use Apuntes;


    --    AÑO    --
create table ANIO (
    idAnio    int(11)   not null,
    anio      char(9)   default(null),

    primary key (idAnio),

		unique (anio)
);


    --   DOCUMENTOS    --
create table DOCUMENTOS (
    idDocumento   int(11)       not null,
    titulo        varchar(50)   not null,
    usuario       int(11)       default null,
    fechaSubida   datetime      default current_timestamp,
    tipo          int(11)       not null,
    anio          int(11)       not null,
    documento     varchar(50)   not null,
    hash          varchar(32)   not null,
    comentario    varchar(300)  not null,
    asignatura    int(11)       not null,

    primary key   (idApuntes),
    foreign key   (usuario)     references  USUARIO(idUsuario),
    foreign key   (tipo)        references  TIPO(idTipo),
    foreign key   (anio)        references  ANIO(idAnio),
    foreign key   (asignatura)  references  ASIGNATURA(idAsignatura),

		unique (hash)

);


    --   ASIGNATURA    --
create table ASIGNATURA (
    idAsignatura    int(11)         not null,
    codigo          varchar(10)     not null,
    nombre          varchar(100)    not null,
    estudios        int(11)         not null,
    curso           int(1)         not null,

    primary key    (idAsigantura),
    foreign key    (estudios)        references ESTUDIOS(idEstudios),

		unique (codigo)
);


    --   COMENTARIOS    --
create table COMENTARIOS (
    idComentario    int(11),
    idUsuario       int(11),
    idDocumento     int(11),
    puntuacion      float,
    comentario      varchar(300),
    fecha           date,
    Pseudonimo      char(12),

    primary key    (idComentarios),
    foreign key    (idUsuario)      references  USUARIO(idUsuario),
    foreign key    (idDocumento)    references  DOCUMENTOS(idDocumento),

    constraint usr_apunt  unique (idUsuario, idApuntes ),
    constraint apunt_pseu unique (idApunte , pseudonimo)
);


    --   ESTUDIOS    --
create table ESTUDIOS (
    idEstudios    int(11)        not null,
    nombre        varchar(12)    not null,

    primary key (idEstudios)
);


    --   SESION    --
create table SESION (
    idSesion    int(11),
    idUsuario   int(11),

    primary key    (idSesion),
    foreign key    (idUsuario)  references  USUARIO(idUsuario)
);


    --   TIPO    --
create table TIPO (
    idTipo    int(11),
    nombre    varchar(12),

    primary key (idTipo)
);


    --   USUARIO    --
create table USUARIO (
    idUsuario       int(11),
    nombre          varchar(30),
    apellido1       varchar(30),
    apellido2       varchar(30)     default null,
    password        varchar(34),
    nick            varchar(20),
    email           varchar(50),

    primary key (idUsuario)
);


    --   INVITACION    --
create table INVITACION (
    idCodigo    int(11),
    codigo      char(12),

    primary key (idCodigo)
);
