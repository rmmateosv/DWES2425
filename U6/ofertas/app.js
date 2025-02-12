//Importar express
const express = require("express");

// Inicializamos la aplicación express
const app = express();

//Importamos las rutas
const rutaU = require("./routes/usuarioR");
const rutaO = require("./routes/ofertaR");

//Asignamos url base a las aplicaciones
app.use("/api", rutaU);
app.use("/api", rutaO);

//Exportar app pata cargarla en index.js
module.exports = app;
