DROP DATABASE IF EXISTS gimnasio;
CREATE DATABASE gimnasio;
use gimnasio;

create table usuario(
	usuario varchar(10) primary key,
    clave blob,
    tipo enum ('C','A') default 'C'
) engine Innodb;
insert into usuario values('admin',sha2('admin',0),'A'),
('dario63',sha2('1A',0),'C'),
('mariaG',sha2('2A',0),'C'),
('ritaF21',sha2('3A',0),'C'),
('carlosNS',sha2('4A',0),'C');

CREATE TABLE cliente (
    id INTEGER NOT NULL AUTO_INCREMENT,
    usuario varchar(10) not null unique,
    dni VARCHAR(10) NOT NULL unique,
    apellidos VARCHAR(40) NOT NULL,
    nombre VARCHAR(20) NOT NULL,
    telf VARCHAR(9),
    baja boolean DEFAULT false,
    numActividades int not null default 0,
    PRIMARY KEY(id),
    foreign key(usuario) references usuario(usuario)
) ENGINE=InnoDB;
insert into cliente(usuario, dni, apellidos,nombre, telf) values ('dario63','1A','Martín Luis','Darío','611111111'),
('mariaG','2A','García','María','622222222'),
('ritaF21','3A','Fernández','Rita','633333333'),
('carlosNS','4A','Navarro Sanz','Carlos','644444444');

CREATE TABLE actividad (
    id INTEGER NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    coste_mensual float NOT NULL DEFAULT 0,
    activa ENUM('ACTIVA','INACTIVA') DEFAULT 'ACTIVA',
    PRIMARY KEY(id)
    
) ENGINE=InnoDB;
insert into actividad(nombre, coste_mensual) values ('Fitness',12.00),
('Baile Latino',25.00),
('Boxeo',15.00),
('GAP',11.00),
('Crossfit',15.00),
('Yoga',32.00);


CREATE TABLE recibo (
    cliente_id INTEGER NOT NULL,
    fecha_emision DATE NOT NULL,
    fecha_pago DATE,
    cuantia float NOT NULL,
    pagado boolean,
    PRIMARY KEY(cliente_id, fecha_emision),
    FOREIGN KEY(cliente_id) REFERENCES cliente(id)
        ON update CASCADE
        on delete restrict
) ENGINE=InnoDB;

CREATE TABLE participa (
    actividad_id INTEGER NOT NULL,
    cliente_id INTEGER NOT NULL,
    PRIMARY KEY(actividad_id, cliente_id),
    FOREIGN KEY(actividad_id) REFERENCES actividad(id)
        ON update CASCADE
        on delete restrict,
    FOREIGN KEY(cliente_id) REFERENCES cliente(id)
        ON update CASCADE
        on delete restrict
) ENGINE=InnoDB;


-- Generar recibos

delimiter //

-- Devuelve 1 si se generan, 0 si ya se han generado
create function generar_recibos(mes int, anio int)
 returns int deterministic
 begin
	-- Comprobamos si ya se han generado los recibos
    declare vfecha date default null;
    
    select fecha_emision into vfecha
		from recibo
        where month(fecha_emision) = mes and
        year(fecha_emision) = anio
        limit 1;
	if vfecha is null then
		-- Generamos los recibos
		insert into recibo select c.id, concat_ws('-',anio,mes,'01'), null, sum(a.coste_mensual), false  from cliente c join participa p on c.id = p.cliente_id
         join actividad a on a.id = p.actividad_id
         where c.baja = false
         group by c.id;
		return 1;
    else
		return 0;
    end if;
 end//
 
 
 