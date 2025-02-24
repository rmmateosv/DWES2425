//Cargar configuración jwt
const servicioJWT = require('../service/jwt');

//Implementar función del middelware
function comprobarAuth(req, res, next){
    try {
        //Comprobar que la petición trae
        //el token
        if(!req.headers.authorization){
            return res.status(403).send('No se envía token');
        }
        const resultado = servicioJWT.verificarToken(req.headers.authorization);
        console.log(resultado);
        //Añadirmos a los datos de petición (req) el payload
        req.datosUS = resultado;
        next();
    } catch (error) {
        return res.status(500).send(error);
    }
}

module.exports = {comprobarAuth};