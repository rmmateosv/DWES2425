// Cargar librería de Express
const express = require('express');

//Inicializar el sistema de rutas
const api = express.Router();

//Importamos el controlador donde se definen las funciones asignadas
//a las rutas
const controlador = require('../controllers/usuarioC');

//Creamos rutas
api.post('/login',controlador.login);
api.post('/registro',controlador.registro);

//Exportamos las rutas de este fichero
module.exports = api;