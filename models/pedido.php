<?php

class Pedido
{
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
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

        $this->id = $id;
    }


    public function getUsuario_id()
    {

        return $this->usuario_id;
    }


    public function setUsuario_id($usuario_id)
    {

        $this->usuario_id = $usuario_id;
    }


    public function getProvincia()
    {

        return $this->provincia;
    }


    public function setProvincia($provincia)
    {

        $this->provincia = $this->db->real_escape_string($provincia);
    }


    public function getLocalidad()
    {

        return $this->localidad;
    }


    public function setLocalidad($localidad)
    {

        $this->localidad = $this->db->real_escape_string($localidad);
    }


    public function getDireccion()
    {

        return $this->direccion;
    }


    public function setDireccion($direccion)
    {

        $this->direccion = $this->db->real_escape_string($direccion);
    }


    public function getCoste()
    {

        return $this->coste;
    }


    public function setCoste($coste)
    {

        $this->coste = $coste;
    }


    public function getEstado()
    {

        return $this->estado;
    }


    public function setEstado($estado)
    {

        $this->estado = $estado;
    }


    public function getFecha()
    {

        return $this->fecha;
    }


    public function setFecha($fecha)
    {

        $this->fecha = $fecha;
    }


    public function getHora()
    {

        return $this->hora;
    }


    public function setHora($hora)
    {

        $this->hora = $hora;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
        $productos = $this->db->query($sql);

        return $productos;
    }


    public function getOne()
    {
        $sql = "SELECT * FROM pedidos WHERE id={$this->getId()} ORDER BY id DESC";
        $producto = $this->db->query($sql);

        return $producto->fetch_object();
    }
    public function getOneByUser()
    {
        $sql = "SELECT p.id, p.coste FROM pedidos p "
        // ."INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "
        ."WHERE p.usuario_id={$this->getUsuario_id()} ORDER BY id DESC LIMIT 1";
        $pedido = $this->db->query($sql);

        return $pedido->fetch_object();
    }
    public function getByUser()
    {
        $sql = "SELECT p.* FROM pedidos p "
        ."WHERE p.usuario_id={$this->getUsuario_id()} ORDER BY id DESC";
        $pedido = $this->db->query($sql);

        return $pedido;
    }

    public function getProductosByPedido($id){
        $sql = "SELECT * FROM productos WHERE id IN " 
        ."(SELECT producto_id FROM lineas_pedidos WHERE pedido_id = {$id})";

        $sql = "SELECT pr.*, lp.unidades FROM productos pr INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id WHERE lp.pedido_id = {$id}";

        $productos = $this->db->query($sql);

        return $productos;
    }

    public function save()
    {
        $sql = "INSERT INTO pedidos VALUES(null, {$this->usuario_id}, '{$this->provincia}', '{$this->localidad}', '{$this->direccion}', {$this->coste}, 'confirmed', CURDATE(), CURTIME());";
        $saved = $this->db->query($sql);
        return $saved;
        
    }

    public function saveLine()
    {
        $sql = "SELECT LAST_INSERT_ID() as 'pedido';";
        $query = $this->db->query($sql);
        $pedido_id = $query->fetch_object()->pedido;

        foreach ($_SESSION['carrito'] as $elemento) {
            $producto = $elemento['producto'];

            $insert = "INSERT INTO lineas_pedidos VALUES(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']});";
            $save = $this->db->query($insert);
            $this->updateStock($producto->id, $elemento['unidades']);
        }
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;

    }

    public function updateOne(){
        $sql = "UPDATE pedidos SET estado = '{$this->getEstado()}'"; 
        $sql .= " WHERE id={$this->getId()};";
        echo $sql;
        $edited = $this->db->query($sql);
        return $edited;
    }

    
    public function updateStock($id, $unidades){
        $sql = "SELECT stock FROM productos WHERE id= $id";
        $query = $this->db->query($sql);
        $stock = $query->fetch_object()->stock;

        $newStock = 0;
        if($stock){
            $newStock = $stock;
        }
        $newStock -= $unidades;
        
        $sql = "UPDATE productos SET stock = $newStock WHERE id = $id";
        $this->db->query($sql);
        
        }
}
