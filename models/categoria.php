<?php

class Categoria
{
    private $id;
    private $nombre;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }


    public function getId()
    {

        return $this->id;
    }


    public function getNombre()
    {

        return $this->nombre;
    }


    public function setId($id)
    {

        $this->id = $id;
    }


    public function setNombre($nombre)
    {

        $this->nombre = $this->db->real_escape_string($nombre);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM categorias;";
        $categorias = $this->db->query($sql);

        return $categorias;
    }

    public function getOne(){
        $sql = "SELECT * FROM categorias WHERE id={$this->getId()};";
        $categoria = $this->db->query($sql);

        return $categoria->fetch_object();
    }

    public function save()
    {

        $sql = "INSERT INTO categorias VALUES (NULL, '{$this->nombre}')";
        $categorias = $this->db->query($sql);

        $saved = false;

        if($categorias) {
            $saved = true;
        }

        return $saved;
    }
}
