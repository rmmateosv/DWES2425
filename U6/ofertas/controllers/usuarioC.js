//Importar el modelo de Usuario
const Usuario = require('../Models/usuario');
//Importar bcrypt
const cifrar = require('bcrypt');

function login(req, res) {


    res.status(200).send('Página de login');
}

async function registro(req, res) {
    try {
        //Recuperar los datos de la solicitud (req)
        const { nombre, email, password, perfil } = req.body;

        //Validar si vienen todos los datos para registro
        if (!nombre || !email || !password || !perfil) {
            throw 'Faltan datos para registrar al usuario' ;
        }
        //Comprobar que no hay otro usuario con el mismo email
        //Hacemos un select a la tabla usuarios por email
        //where:{campo:valor} si coincide se puede poner where:{email}
        //Debemos esperar a que termien de ejecutarse el findOne para
        //continuar. Debemos llamar a findOne con await
        const u = await Usuario.findOne({ where: { email: email } });
        if (u) {
            //Se ha recuperado un usuario
            throw 'Ya existe usuario con ese email';
        }
        //Cifrar pswd
        const hashPs = await cifrar.hash(password, 10);
        //Crear usuario
        const us = await Usuario.create({ nombre, email, password: hashPs, perfil })
        //Devolver el usuario creado
        res.status(200).send(us);
    } catch (error) {
        res.status(500).send({textoError:error});
    }

}

//Exportar funciones para usarlas fuera de este fichero
module.exports = {
    login,
    registro
}

