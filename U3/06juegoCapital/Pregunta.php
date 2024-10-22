<?php
class Pregunta{
    private $id,$pais,$capital;


    function __construct($id,$pais,$capital)
    {
        $this->id=$id;
        $this->pais=$pais;
        $this->capital=$capital;
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
     * Get the value of pais
     */ 
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set the value of pais
     *
     * @return  self
     */ 
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get the value of capital
     */ 
    public function getCapital()
    {
        return $this->capital;
    }

    /**
     * Set the value of capital
     *
     * @return  self
     */ 
    public function setCapital($capital)
    {
        $this->capital = $capital;

        return $this;
    }
}
?>