//Importamos express
const express = require('express');

//Inicializar el sistema de rutas
const api = express.Router();

//Importamos el controlador donde se definen las funciones asignadas
//a las rutas
const controlador = require('../controllers/ofertaC');

//Creamos rutas
api.get('/ofertas',controlador.index);
api.get('/oferta/:id',controlador.show); //Se recupera id en req.params
api.post('/oferta',controlador.store);
api.put('/oferta',controlador.update);
api.delete('/oferta',controlador.destroy);


//Exportamos las rutas de este fichero
module.exports = api;