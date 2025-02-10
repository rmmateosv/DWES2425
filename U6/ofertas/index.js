//Importar express
const express = require('express')

// Crear aplicación express
const app = express()

//Puerto de escucha del servidor
const puerto=3000

//Crear ruta por get
app.get('/',(req,res)=>{
    console.log('Hola Mundo')
    res.status(200).send('Acceso por get a / ok')
})

//Lanzar aplicación
app.listen(puerto,()=>{
    console.log('Aplicación lanzada en http://localhost:3000')
})