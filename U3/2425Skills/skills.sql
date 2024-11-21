drop database if exists skills;
create database skills;
use skills;

create table modalidad(
	id int auto_increment primary key,
    modalidad varchar(50)
)engine innodb;
insert into modalidad values
(default,'Desarrollo Web'),
(default,'Carpintería'),
(default,'Electricidad');

create table alumno(
	id int auto_increment primary key,
    nombre varchar(100) not null,
    modalidad int not null,
    puntuacion int not null default 0,
    finalizado boolean not null default false,
    foreign key(modalidad) references modalidad(id) on update cascade on delete restrict
)engine innodb;

insert into alumno(id, nombre, modalidad) values 
(default,'Pedro',1),
(default,'María',1),
(default,'Clara',1),
(default,'Luis',1),
(default,'Lucía',2),
(default,'María',2),
(default,'Javier',2),
(default,'Paco',2),
(default,'Martina',3),
(default,'Paula',3),
(default,'Matías',3),
(default,'Quique',3);

create table prueba(
	id int auto_increment primary key,
    modalidad int not null,
    fecha datetime not null,
    descripcion varchar(255),
    puntuacion int,
    foreign key(modalidad) references modalidad(id) on update cascade on delete restrict
)engine innodb;
insert into prueba values 
(default, 3, '20240501100000', 'Prueba 1', 4),
(default, 3, '20240501100000','Prueba 2', 3),
(default, 3, '20240502140000','Prueba 3', 2),
(default, 3, '20240502140000','Prueba 4', 1),
(default, 2, '20240501100000','Prueba 1', 3),
(default, 2, '20240501100000','Prueba 2', 3),
(default, 2, '20240502140000','Prueba 3', 2),
(default, 2, '20240502140000','Prueba 4', 2),
(default, 1, '20240501100000','Prueba 1', 3),
(default, 1, '20240501100000','Prueba 2', 2),
(default, 1, '20240502140000','Prueba 3', 2),
(default, 1, '20240501100000','Prueba 4', 3);

create table correccion(
	alumno int,
    prueba int,
    puntos int,
    comentario varchar(100),
    primary key (alumno, prueba),
    foreign key (alumno) references alumno(id) on update cascade on delete restrict,
    foreign key (prueba) references prueba(id) on update cascade on delete restrict
)engine innodb;

delimiter //
create function crearModalidad(pNombre varchar(50))
returns int deterministic begin
	declare vId int;
    select id into vId from modalidad where modalidad = pNombre;
    if(vId is null) then
		insert into modalidad values (default,pNombre);
		return last_insert_id();
	else
		return -1;
	end if;
end//
create procedure obtenerGanadores()
begin
	select m.modalidad, a.nombre, a.puntuacion 
		from alumno a inner join modalidad m on a.modalidad = m.id
        where a.finalizado = true and a.puntuacion = (select max(puntuacion) from alumno where finalizado=true and modalidad = m.id);
end//