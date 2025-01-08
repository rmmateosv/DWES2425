<?php
class Socio{
    private $id,$nombre,$fechaSancion,$email,$us;

    function __construct($id,$nombre,$fechaSancion,$email,$us)
    {
        $this->id=$id;
        $this->nombre=$nombre;
        $this->fechaSancion=$fechaSancion;
        $this->email=$email;
        $this->us=$us;
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
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of fechaSancion
     */ 
    public function getFechaSancion()
    {
        return $this->fechaSancion;
    }

    /**
     * Set the value of fechaSancion
     *
     * @return  self
     */ 
    public function setFechaSancion($fechaSancion)
    {
        $this->fechaSancion = $fechaSancion;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of us
     */ 
    public function getUs()
    {
        return $this->us;
    }

    /**
     * Set the value of us
     *
     * @return  self
     */ 
    public function setUs($us)
    {
        $this->us = $us;

        return $this;
    }
}
?>