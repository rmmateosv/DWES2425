//Importar Aplicación app.js
const app = require('./app')

//Puerto de escucha del servidor
const puerto=3000

//Lanzar aplicación
app.listen(puerto,()=>{
    console.log('Aplicación lanzada en http://localhost:3000')
})