<?php

class Producto
{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $imagen;
    private $fecha;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }




    public function getId()
    {

        return $this->id;
    }


    public function setId($id)
    {

        $this->id = $this->db->real_escape_string($id);
    }


    public function getCategoria_id()
    {

        return $this->categoria_id;
    }


    public function setCategoria_id($categoria_id)
    {

        $this->categoria_id = $categoria_id;
    }


    public function getNombre()
    {

        return $this->nombre;
    }


    public function setNombre($nombre)
    {

        $this->nombre = $this->db->real_escape_string($nombre);
    }


    public function getDescripcion()
    {

        return $this->descripcion;
    }


    public function setDescripcion($descripcion)
    {

        $this->descripcion = $this->db->real_escape_string($descripcion);
    }


    public function getPrecio()
    {

        return $this->precio;
    }


    public function setPrecio($precio)
    {

        $this->precio = $this->db->real_escape_string($precio);
    }


    public function getStock()
    {

        return $this->stock;
    }


    public function setStock($stock)
    {

        $this->stock = $stock;
    }


    public function getOferta()
    {

        return $this->oferta;
    }


    public function setOferta($oferta)
    {

        $this->oferta = $this->db->real_escape_string($oferta);
    }


    public function getImagen()
    {

        return $this->imagen;
    }


    public function setImagen($imagen)
    {

        $this->imagen = $imagen;
    }


    public function getFecha()
    {

        return $this->fecha;
    }


    public function setFecha($fecha)
    {

        $this->fecha = $fecha;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $productos = $this->db->query($sql);

        return $productos;
    }

    public function getAllCategory()
    {
        $sql = "SELECT p.*, c.nombre AS 'nombre_cat' FROM productos p "
        ."INNER JOIN categorias c ON c.id = p.categoria_id "
        ."WHERE p.categoria_id = {$this->getCategoria_id()} "
        ."ORDER BY id DESC";
        $productos = $this->db->query($sql);

        return $productos;
    }

    public function getRandom($limit) {
        $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT $limit";
        $productos = $this->db->query($sql);

        return $productos;
    }
    public function getProduct()
    {
        $sql = "SELECT * FROM productos WHERE id={$this->getId()} ORDER BY id DESC";
        $producto = $this->db->query($sql);

        return $producto->fetch_object();
    }

    public function save()
    {
        $sql = "INSERT INTO productos VALUES(null, {$this->categoria_id}, '{$this->nombre}', '{$this->descripcion}', '{$this->precio}', {$this->stock}, '{$this->oferta}', CURDATE(), '{$this->imagen}');";
        $saved = $this->db->query($sql);
        return $saved;
    }

    public function edit()
    {
        $sql = "UPDATE productos SET categoria_id = '{$this->categoria_id}', nombre = '{$this->nombre}', descripcion='{$this->descripcion}', precio='{$this->precio}', stock={$this->stock}, oferta='{$this->oferta}'";
        if ($this->getImagen() != null) {
            $sql .= ", imagen='{$this->getImagen()}'";
        }
        
        $sql .= " WHERE id={$this->id};";
        $edited = $this->db->query($sql);
        return $edited;
    }

    public function delete()
    {
        $sql = "DELETE FROM productos WHERE id={$this->id}";
        $saved = $this->db->query($sql);
        return $saved;
    }

}
