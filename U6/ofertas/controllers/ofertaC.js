function index(req,res){
    res.status(200).send('Obtener todas las ofertas');
}
function show(req,res){
    res.status(200).send('Obtener una oferta');
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