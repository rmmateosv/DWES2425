//Importar librerías de tipos de datos de sequelize
const { DataTypes } = require("sequelize");

//Importar configuracion de la base de datos
const bd = require("../config/database");

const usuario = bd.define(
  "Usuario",
  {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true,
      autoIncrement: true,
    },
    nombre: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    email: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true, //clave alternativa
    },
    password: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    perfil: {
      type: DataTypes.ENUM("tienda", "ciudadano"),
      allowNull: false,
    },
    avatar: {
      type: DataTypes.STRING,
      allowNull: true,
    },
  },
  {
    tableName: "usuarios", //Nombre de la tabla en la base de datos
    timestamps: true, //Agrega createdAt y updatedAt automaticamente
  }
);

module.exports = usuario;
