drop database if exists mcDaw;
create database mcDaw;
use mcDaw;

create table tienda(
	codigo int primary key auto_increment,
    nombre varchar(100) not null,
    telefono varchar(9) not null
)engine innodb;
insert into tienda values 
(default,'Navalmoral de la Mata 1',927111111),
(default,'Cáceres 1',927111111),
(default,'Plasencia 1',927111111);



create table producto(
	codigo int primary key auto_increment,
    nombre varchar(100),
    precio float
);
insert into producto(nombre,precio) values
('Hamburguesa Clásica', 8.99),
('Cheeseburger Doble', 10.99),
('Papas Fritas', 3.49),
('Aros de Cebolla', 4.99),
('Refresco Grande', 1.99),
('Ensalada de Pollo', 7.49),
('Batido de Chocolate', 4.99),
('Nuggets de Pollo (10 piezas)', 6.99),
('Agua Mineral', 1.49),
('Postre de Manzana', 3.99);
create table pedido(
	codigo int primary key auto_increment,
    fecha date not null,
    tienda int not null,
    foreign key(tienda) references tienda(codigo) on update cascade on delete restrict
)engine innodb;

create table detalle(
	linea int,
    pedido int,
    producto int,
    cantidad int not null,
    precioU float not null,
    primary key(linea, pedido,producto),
    foreign key(pedido) references pedido(codigo) on update cascade on delete restrict,
    foreign key(producto) references producto(codigo) on update cascade on delete restrict
)engine innodb;

delimiter //
create procedure datosPedido(pCodigo int)
begin
   
	select pCodigo as codigo, count(*) as numProd, sum(cantidad*precioU) as total 
		from detalle 
		where pedido = pCodigo;
end//

