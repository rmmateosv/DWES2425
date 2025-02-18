//Importamos express
const express = require('express');

//Inicializar el sistema de rutas
const api = express.Router();

//Importamos el controlador donde se definen las funciones asignadas
//a las rutas
const controlador = require('../controllers/ofertaC');

//Importar middelware
const mAuth = require('../middelware/auth');

//Creamos rutas
api.get('/ofertas',[mAuth.comprobarAuth],controlador.index);
api.get('/oferta/:id',[mAuth.comprobarAuth],controlador.show); //Se recupera id en req.params
api.post('/oferta',[mAuth.comprobarAuth],controlador.store);
api.put('/oferta/:id',[mAuth.comprobarAuth],controlador.update);
api.delete('/oferta/:id',[mAuth.comprobarAuth],controlador.destroy);


//Exportamos las rutas de este fichero
module.exports = api;