<?php
class Libro{
    private $id,$titulo,$ejemplares,$autor;

    function __construct($id,$titulo,$ejemplares,$autor)
    {
        $this->id=$id;
        $this->titulo=$titulo;
        $this->ejemplares=$ejemplares;
        $this->autor=$autor;
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of titulo
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */ 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of ejemplares
     */ 
    public function getEjemplares()
    {
        return $this->ejemplares;
    }

    /**
     * Set the value of ejemplares
     *
     * @return  self
     */ 
    public function setEjemplares($ejemplares)
    {
        $this->ejemplares = $ejemplares;

        return $this;
    }

    /**
     * Get the value of autor
     */ 
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set the value of autor
     *
     * @return  self
     */ 
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }
}
?>