//Importar el modelo de Usuario
const Usuario = require('../Models/usuario');
//Importar bcrypt
const cifrar = require('bcrypt');

//Importar gestión de tokens
const servicioJWT = require('../service/jwt');
const { request } = require('express');

//Importar librerías que permiten trabajar con ficheros
const fs = require('fs');
const path = require('path');

async function login(req, res) {

    try {
        //Recuperar datos
        const { email, password } = req.body;
        if (!email || !password) {
            throw 'Falta email o ps';
        }
        //REcuperar el us por el email
        const us = await Usuario.findOne({ where: { email } });
        if (!us) {
            throw 'Usuario incorrecto';
        }
        else {
            //Comprobar con bcrypt si la contraseña es correcta
            if (await cifrar.compare(password, us.password)) {
                //Crear token
                const token = servicioJWT.crearToken(us, '24h');
                res.status(200).send({
                    email: us.email, nombre: us.nombre,
                    perfil: us.perfil, token: token
                });
                //res.status(200).send({us:us, token:token});
            }
            else {
                throw 'Usuario incorrecto';
            }
        }

    } catch (error) {
        res.status(500).send({ textoError: error });
    }

}

async function registro(req, res) {
    try {
        //Recuperar los datos de la solicitud (req)
        const { nombre, email, password, perfil } = req.body;

        //Validar si vienen todos los datos para registro
        if (!nombre || !email || !password || !perfil) {
            throw 'Faltan datos para registrar al usuario';
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
        res.status(500).send({ textoError: error });
    }

}
async function subirAvatar(req, res) {
    try {
        console.log(req.files);
        //Comprobar si hay fichero en req
        if (!req.files.avatar) {
            throw 'No has proporcionado fichero';
        }
        //Obtener el nombre del fichero para
        //guardarlo en la bd, en el usuario
        const rutaF = req.files.avatar.path.split('/');
        //datosUS lo hemos crado en req al validar el token
        const us = await Usuario.findByPk(req.datosUS.id);
        //Rellenar el atributo avatar con el nombre del fichero subido
        us.avatar = rutaF[1];
        if (us.changed()) {
            await us.save();
            res.status(200).send('Avatar actualizado');
        }
        else {
            res.status(200).send('No se han mpdificado datos');
        }

    } catch (error) {
        res.status(500).send({ textoError: error });
    }

}
async function obtenerAvatar(req, res) {
    try {
        //Comproba que us existe y tiene avatar
        const us = await Usuario.findByPk(req.datosUS.id);
        if (!us || !us.avatar) {
            throw 'Usuario no existe o no tiene avatar';
        }
        else {
            const nombreF = `./avatars/${us.avatar}`;
            //Acceder al fichero para devolver
            fs.stat(nombreF,(error,stat)=>{
                if(error){
                    throw 'Imagen no disponible';
                }
                else{
                    res.sendFile(path.resolve(nombreF));
                }
            });
        }
    } catch (error) {
        res.status(500).send({ textoError: error });
    }
}
//Exportar funciones para usarlas fuera de este fichero
module.exports = {
    login,
    registro,
    subirAvatar,
    obtenerAvatar
}

