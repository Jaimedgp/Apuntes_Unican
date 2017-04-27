create table COMENTARIOS (
	id_comentario char(9),
	id_usuario char(9),
	id_apuntes char(9),
	puntuacion float,
	comentario varchar(300),
	fecha date,
	Pseudonimo char(12),
	constraint pk_coment primary key(id_comentarios),
	unique key usr_apunt (id_usuario, id_apuntes)
);


create table invitacion (
	id_codigo char(10),
	constraint pk_cod primary key(id_codigo)
);
