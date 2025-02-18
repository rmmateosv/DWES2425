//Importar librería de tipos de datos de sequelize
const { DataTypes } = require('sequelize');

//Importar configuración BD
const bd = require('../config/database');

//DEfinimos el modelo de oferta
const Oferta = bd.define('ofertas',
    {
        id:{
            type: DataTypes.INTEGER,
            autoIncrement:true,
            primaryKey:true
        },
        titulo:{
            type:DataTypes.STRING,
            allowNull:false
        },
        descripcion:{
            type:DataTypes.STRING,
            allowNull:false
        },
        usuario_id:{
            type:DataTypes.INTEGER,
            allowNull:false,
            references:{
                model:'usuarios', //Nombre de la tabla
                key:'id'
            },
            onUpdate: 'CASCADE',
            onDelete: 'RESTRICT',
        }
    },
    {
        //tablename:'ofertas',
        timestamps:true
    });

    module.exports=Oferta;