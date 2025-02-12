//Cargar libreria de Express
const express = require("express");

//inicializar el sistema de rutas
const api = express.Router();

//Importamos el controlador donde se definen las funciones asignadas a las rutas
const controlador = require("../controllers/usuarioC");

//Creamos las rutas
api.post("/login", controlador.login);
api.post("/registro", controlador.registro);

//Exportamos las rutas de esre fichero
module.exports = api;
