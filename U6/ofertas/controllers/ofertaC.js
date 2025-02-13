//Incluir modelos
const {Oferta, Usuario} = require('../Models');

async function index(req,res){
    try {
        //Recuperar las ofertas y los datos del usuario 
        //que las ha creado
        const ofertas = await Oferta.findAll({include: Usuario});
        res.json(ofertas);
        
    } catch (error) {
        res.status(500).send({textoError:error});
    }
}
async function show(req,res){
    try {
        //REcuperar oferta por id que es PK y llega por la ruta
        const oferta = await Oferta.findByPk(req.params.id,{include:Usuario});
        if(!oferta){
            throw 'Oferta no encontrada'
        }
        else{
            res.json(oferta);
        }
    } catch (error) {
        res.status(500).send({textoError:error});
    }
}
function store(req,res){
    res.status(200).send('Crear oferta');
}
function update(req,res){
    res.status(200).send('Modificar oferta');
}
function destroy(req,res){
    res.status(200).send('Borrar oferta');
}

module.exports={
    index,
    show,
    update,
    destroy,
    store
}