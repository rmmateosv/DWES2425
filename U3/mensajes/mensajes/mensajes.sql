drop database if exists mensajes;
create database mensajes;
use mensajes;

create table departamento(
	idDep int primary key not null auto_increment,
    nombre varchar(100) not null
)engine innodb;
insert into departamento values
	(null, 'RRHH'),
    (null, 'Contabilidad'),
    (null, 'Ventas'),
    (null, 'Compras'),
    (null, 'Almacen');
    
create table empleado(
	idEmp int auto_increment  key,
    dni varchar(9) not null unique,
    ps blob not null,
    nombreEmp varchar(100) not null,
    fechaNac date not null,
    departamento  int not null,
    cambiarPs boolean default true,
    foreign key (departamento) references departamento(idDep) on update cascade on delete restrict
)engine innodb;

insert into empleado(dni,ps,nombreEmp,fechaNac, departamento) values
	('1A',sha2('1A',0),'Ana Díaz',20000101,2),
	('2A',sha2('2A',0),'Luisa Amor',20000201,1),
	('3A',sha2('3A',0),'Gema Contreas',20000301,3),
	('4A',sha2('4A',0),'Margarita Flores',20000401,4),
	('5A',sha2('5A',0),'Mónica Vaz',20000501,2),
	('6A',sha2('6A',0),'Pilar Sanz',20000601,5),
    ('7A',sha2('7A',0),'Lucía Vilalr',20000701,1);


create table mensaje(
	idMen int primary key auto_increment,
    deEmpleado int not null,
    paraDepartamento int not null,
    asunto varchar(100),
    fechaEnvio date not null,
    mensaje varchar(500),
    foreign key (deEmpleado) references empleado(idEmp) on update cascade on delete restrict,
    foreign key (paraDepartamento) references departamento(idDep) on update cascade on delete restrict
) engine Innodb;

create table para(
	idMen int,
	paraEmpleado int not null,
    leido boolean not null default false,
    primary key(idMen,paraEmpleado),
    foreign key (idMen) references mensaje(idMen) on update cascade on delete restrict,
    foreign key (paraEmpleado) references empleado(idEmp) on update cascade on delete restrict
)engine innodb;

delimiter //
create function login(pUs int, pPs varchar(100))
	returns int deterministic
begin
	declare vCambiar boolean;
    select cambiarPs into vCambiar from empleado where idEmp = pUs and ps = sha2(pPs,0);
    if vCambiar is null then return 0;
    else return 1;
    end if;
end//
