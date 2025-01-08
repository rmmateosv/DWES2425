drop database if exists biblioteca;
create database biblioteca;
use biblioteca;

create table usuarios(
	id varchar(9) primary key,
    ps blob not null,
    tipo enum ('A','S') not null -- A para admin y S para socios
)engine innodb;
insert into usuarios values('admin',sha2('admin',512), 'A' ),
('11111111A',sha2('11111111A',512), 'S' ),
('22222222A',sha2('22222222A',512), 'S' ),
('33333333A',sha2('33333333A',512), 'S' ),
('44444444A',sha2('44444444A',512), 'S' ),
('55555555A',sha2('55555555A',512), 'S' );
create table socios(
	id int auto_increment primary key, 
    nombre varchar(100) not null,
    fechaSancion date default null,
    email varchar(255) not null,
    us varchar(9) not null unique,
    foreign key (us) references usuarios(id) on update cascade on delete restrict
)engine innodb;
insert into socios values (null,'Carlos Díaz',null,'carlos@gmail.com','11111111A'),
 (null,'Marta Sánchez',null,'marta@gmail.com','22222222A'),
 (null,'Lucas López',null,'lucas@gmail.com','33333333A'),
 (null,'Raúl García',null,'raul@gmail.com','44444444A'),
 (null,'Ana Martín',20241231,'ana@gmail.com','55555555A');

create table libros(
	id int auto_increment primary key,
    titulo varchar(100) not null,
    ejemplares int not null,
    autor varchar(100) not null
)engine innodb;
insert into libros values (null,'La sombra del viento',0,'Carlos Ruíz Zafón'),
	(null,'El quijote',12,'Cervantes'),
    (null,'Redes',5,'Eloy Moreno'),
    (null,'Invisible',10,'Eloy Moreno'),
    (null,'Terra Alta',3,'Javier Cercas');

create table prestamos(
	id int auto_increment primary key,
    socio int not null,
    libro int not null,
    fechaP date not null, -- Fecha Pŕestamo
    fechaD date not null, -- Fecha Devolución
    fechaRD date null default null,	  -- Fecha Real de devolución
    foreign key (socio) references socios(id) on update cascade on delete restrict,
    foreign key (libro) references libros(id) on update cascade on delete restrict
)engine innodb;

insert into prestamos values (null,1,1,20230101,20230115,null),
(null,2,1,20230101,20230115,20230110),
(null,2,3,20240901,20241031,null),
(null,2,1,20240901,20241031,null),
(null,3,3,20240901,20241031,null);



-- Función que comprueba si se puede prestar el libro al socio
-- Devuelve:
-- 1: Si se puede hacer el préstamo
-- -1 Si no hay ejemplares del libro o el libro no existe
-- -2 Si el socio está sancionado o el socio no existe
-- -3 Si el socio tiene préstamos caducados
-- -4 Si el socio tiene más de 2 libros prestados
delimiter //
create function comprobarSiPrestar(pSocio int, pLibro int) returns int deterministic
begin
	declare resultado int default 1;
    declare vId int;
    
    -- Comprobar ejemplares
    select id into vId from libros
		where id = pLibro  and ejemplares >0;
    if(vId is null) then
		return -1;
    end if;
    -- Comprobar socio
    set vId=null;
    select id into vId from socios
		where id = pSocio and (fechaSancion is null or fechaSancion < curdate());
    if(vId is null) then
		return -2;
    end if;  
    
    -- Chequear si el socio tiene préstamos caducados
    select  count(*) into  vId from prestamos
		where socio = pSocio and fechaD < curdate() and fechaRD is null;
    if(vId>0) then
		return -3;
    end if;
    
    -- Chequear si el scocio tiene 2 o más libros
	select  count(*) into  vId from prestamos
		where socio = pSocio  and fechaRD is null;
    if(vId>=2) then
		return -4;
    end if;
    
    return resultado;
end//

create procedure infoSocio(pIdS int)
begin
-- Nº de prestamos, fecha primer préstamo y fecha último préstamo
	select count(*), min(fechaP), max(fechaP)
		from prestamos
		where socio = pIdS;
-- Nº de préstmos no devueltos, nº de préstamos devueltos, título del último libro prestado
select (select count(*) from prestamos where socio=pIdS and fechaRD is null),
		(select count(*) from prestamos where socio=pIdS and fechaRD is not null),
        (select titulo from libros where id = 
			(select libro from prestamos where socio = pIdS and fechaP=(select fechaP
				from prestamos where socio = pIdS order by fechaP desc limit 1) 
			 limit 1)
		);
-- Nº de libros leídos por autor
select  l.autor, count(*)
	from prestamos p inner join libros l on p.libro = l.id
    where p.socio = pIdS
    group by l.autor;
        
end//

delimiter ;

select comprobarSiPrestar(5,1);  -- Chequea ejemplares
select comprobarSiPrestar(5,100);  -- Chequea libro existe
select comprobarSiPrestar(50,2);  -- Chequea socio
select comprobarSiPrestar(5,2);  -- Chequea socio
select comprobarSiPrestar(1,2);  -- Préstamos caducado
select comprobarSiPrestar(2,2);  -- Socio con 2 o más préstamos
select comprobarSiPrestar(3,2);  -- Correcto
select comprobarSiPrestar(4,2);  -- Correcto

call infoSocio(14);