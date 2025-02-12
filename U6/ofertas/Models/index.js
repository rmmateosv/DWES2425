//Importar sequelize 
const {Sequelize} = require('sequelize');

//Importar configuracion de la base de datos
const bd = require('../config/database');

//Importar el modelo de Usuario
const Usuario = require('./usuario');

//Definir relaciones 

//exportar conexion , modelo y relaciones
module.exports = {
  bd,
  Usuario,
};