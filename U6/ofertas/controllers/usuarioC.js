//Importar el modelo de Usuario
const Usuario = require('../Models/usuario');
//Importar bcrypt
const cifrar = require('bcrypt');

function login(req, res) {
    //Recuperar los datos de la solicitud (req)
    res.status(200).send('Página de login');
}

function registro(req, res) {

    res.status(200).send('Página de registro');
}

//Exportar funciones para usarlas fuera de este fichero
module.exports = {
    login,
    registro
}

