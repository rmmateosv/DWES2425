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
async function store(req,res){
    try {
        const {titulo, descripcion, usuario} = req.body;
        if(!titulo || !descripcion || !usuario){
            throw 'Faltan datos de la oferta';
        }
        //Comprobar que el usuario existe
        const us = await Usuario.findOne({where:{id:usuario,perfil:'tienda'}});
        if(!us){
            throw 'Tienda no existe';
        }
        else{
            const o = await Oferta.create({titulo, descripcion, usuario_id:usuario});
            res.json(o);
        }
    } catch (error) {
        res.status(500).send({textoError:error});
    }
}
async function update(req,res){
    try {
        const {titulo,descripcion} = req.body;
        if(!titulo && !descripcion){
            throw 'Titulo o descripción son obligatorios';
        }
        //Comprobar que la oferta existe
        const o = await Oferta.findByPk(req.params.id);
        if(!o){
            throw 'No existe oferta';
        }
        if(titulo){
           // o.set('titulo',titulo);
           o.titulo = titulo;
        }
        if(descripcion){
            o.set('descripcion',descripcion);
        }
        //Comprobar si se ha modficado algo
        if(o.changed()){
            if(await o.save()){
                res.status(200).send(o);
            }
            else{
                throw 'Error al modificar la oferta';
            }
        }
        else{
            res.status(200).send({textoError:'No se han modificado datos'});
        }
    } catch (error) {
        res.status(500).send({textoError:error});
    }
}
async function destroy(req,res){
    try {
        //Comprobar que la oferta existe
        const o = await Oferta.findByPk(req.params.id);
        if(!o){
            throw 'Oferta no existe';
        }
        //Chequear que el usuario que borra es el creador de la oferta

        if(await o.destroy()){
            res.status(200).send('Oferta borrada')
        }
        else{
            throw 'Error al borrar la oferta';
        }

    } catch (error) {
        res.status(500).send({textoError:error});
    }   
}

module.exports={
    index,
    show,
    update,
    destroy,
    store
}