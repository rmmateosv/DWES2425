function login(req,res){
    res.status(200).send('Página de login');
}

function registro(req,res){
    res.status(200).send('Página de registro');
}

//Exportar funciones para usarlas fuera de este archivo
module.exports = {
    login,
    registro
}