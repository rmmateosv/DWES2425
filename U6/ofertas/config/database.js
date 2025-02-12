//Cargar dotenv para trabajar con variables  .env
const dotenv = require("dotenv");
dotenv.config();

//Importar libreria de ORM
const sequelize = require("sequelize");

//Configura conección a la base de datos
const configBD = new sequelize(
  process.env.DB_NAME,
  process.env.DB_USER,
  process.env.DB_PASSWORD,
  {
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    dialect: process.env.DB_DIALECT,
    dialectModule: require("mysql2"),
  }
);
module.exports = configBD;
