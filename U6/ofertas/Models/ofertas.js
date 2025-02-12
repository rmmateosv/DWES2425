//Importar librerías de tipos de datos de sequelize
const { DataTypes } = require("sequelize");

//Importar configuracion de la base de datos
const bd = require("../config/database");

//Defiimos el modelo de ofertas
const Oferta = bd.define('Oferta',
    {
        id: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            autoIncrement: true,
        },
        titulo: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        descripcion: {
            type: DataTypes.STRING,
            allowNull: false,
        },
        usurio_id: {
            type: DataTypes.INTEGER,
            references: {
                model: 'usuarios',
                key: 'id'
            },
            allowNull: false,
            onDelete: 'RESTRICT', //Si un usuario es eliminado, las ofertas asociadas también serán eliminadas
            onUpdate: 'CASCADE', //Si un usuario es modificado, las ofertas asociadas también serán modificadas
        }
       
    },
    {
        tableName: 'ofertas', //Nombre de la tabla en la base de datos
        timestamps: true, //Agrega createdAt y updatedAt automaticamente
    }
)