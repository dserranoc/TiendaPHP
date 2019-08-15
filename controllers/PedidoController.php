<?php

require_once 'models/pedido.php';
require_once 'models/producto.php';

class PedidoController
{
    public function hacer()
    {
        require_once 'views/pedido/hacer.php';
    }

    public function add()
    {
        Utils::isLogged();
        $usuario_id = $_SESSION['identity']->id;

        $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
        $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
        $stats = Utils::statsCarrito();
        $coste = $stats['total'];

        if ($provincia && $localidad && $direccion) {

            //  Guardar datos en la BD
            $pedido = new Pedido();

            $pedido->setUsuario_id($usuario_id);
            $pedido->setProvincia($provincia);
            $pedido->setLocalidad($localidad);
            $pedido->setDireccion($direccion);
            $pedido->setCoste($coste);
            $saved = $pedido->save();

            //Guardar linea-pedido

            $save_linea = $pedido->saveLine();

            if ($saved && $save_linea) {
                $_SESSION['pedido'] = 'completed';
            } else {
                $_SESSION['pedido'] = 'failed';
            }
        } else {
            $_SESSION['pedido'] = 'failed';
        }
        header('Location:' . base_url . 'pedido/confirmado');
    }
    public function confirmado()
    {
        if (isset($_SESSION['identity'])) {
            $identity = $_SESSION['identity'];
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);
            $pedido = $pedido->getOneByUser();

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($pedido->id);
        }
        require_once 'views/pedido/confirmado.php';
    }
    public function mis_pedidos()
    {
        Utils::isLogged();
        $usuario_id = $_SESSION['identity']->id;
        $pedido = new Pedido();
        $pedido->setUsuario_id($usuario_id);
        // Sacamos TODOS los pedidos de un usuario
        $pedidos = $pedido->getByUser();
        require_once 'views/pedido/mis-pedidos.php';
    }

    public function detalle()
    {
        Utils::isLogged();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Sacamos el pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $ped = $pedido->getOne();

            // Sacamos los productos del pedido

            $productos_pedido = $pedido->getProductosByPedido($id);


            require_once 'views/pedido/detalle.php';
        } else {
            header('Location:' . base_url . 'pedido/mis_pedidos');
        }
    }

    public function gestion()
    {
        Utils::isAdmin();
        $gestion = true;

        $pedido = new Pedido();
        $pedidos = $pedido->getAll();

        require_once 'views/pedido/mis-pedidos.php';
    }

    public function estado()
    {
        Utils::isAdmin();
        if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
            // Recogemos datos del formulario
            $estado = $_POST['estado'];
            $pedido_id = $_POST['pedido_id'];
            // Actualizacion del pedido
            $pedido = new Pedido();
            $pedido->setId($pedido_id);
            $pedido->setEstado($estado);
            $pedido->updateOne();

            header('Location:' . base_url.'pedido/detalle&id='.$pedido_id);
        } else {
            header('Location:' . base_url);
        }
    }
}
