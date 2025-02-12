//Importar aplicacion app
const app = require("./app");

//Cargar dotenv para trabajar con variables  .env
const dotenv = require("dotenv");
dotenv.config();
//Puerto de escucha del servidor
const puerto = process.env.PORT;

//Cargar configuración de la base de datos
const { bd, Usuario } = require("./Models/index");

//Conectar a la base de datos
bd.sync({
  force: true, // ¡¡CAMBIAR A FALSE  CUANDO EL ESQUEMA DEL BD SEA DEFINITIVO!!
})
  .then(() => {
    console.log("BD SICRONIZADA");
    //Lanzar la aplicación
    app.listen(puerto, () => {
      console.log("Aplicación lanzada en http://localhost:3001");
    });
  })
  .catch((error) => {
    console.error("Error al conectar con la BD:", error);
  });
