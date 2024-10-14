drop database if exists biblioteca;
create database biblioteca;
use biblioteca;

create table socios(
	id int auto_increment primary key,
    nombre varchar(100) not null,
    fechaSancion date default null,
    email varchar(255) not null
)engine innodb;

create table libros(
	id int auto_increment primary key,
    titulo varchar(100) not null,
    ejemplares int not null,
    autor varchar(100)
)engine innodb;

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
-- Función que comprueba si se puede prestar el libro al socio
-- Devuelve:
-- 1: Si se puede hacer el préstamo
-- -1 Si no hay ejemplares del libro o el libro no existe
-- -2 Si el socio está sancionado o el socio no existe
-- -3 Si el socio tiene préstamos caducados
-- -4 Si el socio tiene más de 2 libros prestados
-- 0 en cualquier otro caso (error)
delimiter //
create function comprobarSiPrestar(pSocio int, pLibro int) returns int 
begin
	declare resultado int default 0;
    declare vId int;
    
    -- Comprobar ejemplares
    select id from libros
		into vId
		where id = pLibro  and ejemplares >0;
    if(vId is null) then
		return -1;
    end if;
    -- Comprobar socio
    select id from socio
		into vId
		where id = pSocio and fechaSancion is null;
    if(vId is null) then
		return -2;
    end if;  
    
    -- Chequear si el socio tiene préstamos caducados
    select  count(*) from prestamos
		into  vId
		where socio = pSocio and fechaD < curdate() and fechaRD is null;
    if(vId>0) then
		return -3;
    end if;
    
    
        
    return resultado;
end;
delimiter ;