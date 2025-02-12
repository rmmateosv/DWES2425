//Importar Sequelize
const {Sequelize} = require('sequelize');

//Importar configuración BD
const bd = require('../config/database')

//Importar el modelo de Usuario
const Usuario = require('./usuario')
//Importar el modelo de Oferta
const Oferta = require('./oferta')

//Definir relaciones
//Un usuario (tienda) puede tener 0 o muchas ofertas creadas
Usuario.hasMany(Oferta, {foreignKey:'usuario_id'})
//Una oferta es de un usuario
Oferta.belongsTo(Usuario,{foreignKey:'usuario_id'})

//Eportar conexión, modelos y relaciones
module.exports = {
    bd,
    Usuario,
    Oferta
}