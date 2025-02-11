//Importar librería de tipos de datos de sequelize
const { DataTypes } = require('sequelize');

//Importar configuración BD
const bd = require('../config/database');

//DEfinimos el modelo de oferta
const Oferta = bd.define('Oferta',
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
                model:'usuarios',
                key:'id'
            },
            onUpdate: 'CASCADE',
            onDelete: 'RESTRICT',
        }
    },
    {
        tablename:'ofertas',
        timestamps:true
    });