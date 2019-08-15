<?php


class Utils
{

    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION['$name'] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    public static function showError($errors, $field)
    {
        $alert = '';
        if (isset($errors[$field]) && !empty($field)) {
            $alert = "<div class='alert error-alert'>" . $errors[$field] . "</div>";
        }
        return $alert;
    }

    public static function isAdmin()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location:' . base_url);
        } else {
            return true;
        }
    }

    public static function isLogged()
    {
        if (!isset($_SESSION['identity'])) {
            header('Location:' . base_url);
        } else {
            return true;
        }
    }

    public static function showCategorias()
    {
        require_once 'models/categoria.php';

        $categoria = new Categoria();
        $categorias = $categoria->getAll();

        return $categorias;
    }

    public static function showProductos()
    {
        require_once 'models/producto.php';

        $producto = new Producto();
        $productos = $producto->getAll();

        return $productos;
    }

    public static function statsCarrito()
    {
        $stats = array(
            'count' => 0,
            'total' => 0
        );
        if (isset($_SESSION['carrito'])) {
            $stats['count'] = count($_SESSION['carrito']);

            foreach ($_SESSION['carrito'] as $producto) {
                $stats['total'] += $producto['precio'] * $producto['unidades'];
            }
        }

        return $stats;
    }

    public static function showEstado($status)
    {
        if ($status == 'confirmed') {

            $estado = 'Pendiente';
        } elseif ($status == 'preparation') {
            $estado = 'En preparación';
        } elseif ($status == 'ready') {
            $estado = 'Preparado para enviar';
        } else {
            $estado = 'Enviado';
        }

        return $estado;
    }
}
