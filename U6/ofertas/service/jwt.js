//Importar librería jwt
const jwt  = require('jsonwebtoken');
//Importar dotenv
const dotenv = require('dotenv');
dotenv.config();

//Función crear token 
function crearToken(usuario, caducidad){
    try {
        //Obtener datos de usuario que van en el token
        //Esto es el payload
        const {id,email} = usuario;

        //Crear el payload 
        const payload = {id,email};

        //Generar y devolver el token
        return jwt.sign(payload, process.env.CLAVE_JWT,
            {expiresIn:caducidad});
    } catch (error) {
        throw `Error al generar el token:${error}`;
    }
}


//Función verificar token
//Verifica la firma y la caducidad
function verificarToken(token){
    try {
        const datosVerficacion = jwt.verify(token,process.env.CLAVE_JWT);
        return datosVerficacion;
    } catch (error) {
        throw `Error al verificar el token:${error}`;
    }
}

module.exports = {
    crearToken,
    verificarToken
}
