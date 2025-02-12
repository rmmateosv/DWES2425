//Importar express
const express = require('express');

//Incializar express
const app = express();

//Importar rutas
const rutaU = require('./routes/usuarioR');
const rutaO = require('./routes/ofertaR');

//Asignar url base a las aplicación
app.use('/api',rutaU);
app.use('/api',rutaO);

//Exportar app para cargarla en index.js
module.exports=app;