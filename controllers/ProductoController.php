<?php

require_once 'models/producto.php';

class ProductoController
{
    public function index()
    {
        // Renderizar vista

        $producto = new Producto();
        $productos = $producto->getRandom(6);


        require_once 'views/producto/destacados.php';
    }

    public function ver()
    {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            $prod = $producto->getProduct();
        }
        require_once 'views/producto/ver.php';
    }

    public function gestion()
    {
        Utils::isAdmin();
        $producto = new Producto();
        $productos = $producto->getAll();
        require_once 'views/producto/gestion.php';
    }

    public function crear()
    {
        // Utils::isAdmin();
        require_once 'views/producto/crear.php';
    }

    public function save()
    {
        Utils::isAdmin();
        if (isset($_POST)) {

            $nombre = isset($_POST['name']) ? $_POST['name'] : false;
            $descripcion = isset($_POST['description']) ? $_POST['description'] : false;
            $categoria = isset($_POST['category']) ? $_POST['category'] : false;
            $precio = isset($_POST['price']) ? $_POST['price'] : false;
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
            $oferta = isset($_POST['offer']) ? $_POST['offer'] : false;
            // $imagen = isset($_POST['image']) ? $_POST['image'] : false;


            if ($nombre && $descripcion && $categoria && $precio && $stock && $oferta) {
                $producto = new Producto();
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setCategoria_id($categoria);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setOferta($oferta);

                // Guardar imagen
                if (isset($_FILES['image'])) {
                    $file = $_FILES['image'];
                    $filename = $_FILES['image']['name'];
                    $mimetype = $_FILES['image']['type'];

                    if ($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype == "image/png" || $mimetype == "image/gif") {
                        if (!is_dir('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                        move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                        $producto->setImagen($filename);
                    }
                }
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $producto->setId($id);
                    $save = $producto->edit();
                } else {
                    $save = $producto->save();
                }

                if ($save) {
                    $_SESSION['producto'] = "completed";
                } else {
                    $_SESSION['producto'] = "failed";
                }
            } else {
                $_SESSION['producto'] = "failed";
            }
        } else {
            $_SESSION['producto'] = "failed";
        }
        header('Location:' . base_url . "producto/gestion");
    }

    public function editar()
    {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $edit = true;
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            $prod = $producto->getProduct();
            require_once 'views/producto/crear.php';
        } else {
            header('Location:' . base_url . 'producto/gestion');
        }
    }
    public function eliminar()
    {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $producto = new Producto();
            $id = $_GET['id'];
            $producto->setId($id);


            $delete = $producto->delete();

            if ($delete) {
                $_SESSION['delete'] = 'completed';
            } else {
                $_SESSION['delete'] = 'failed';
            }
        } else {
            $_SESSION['delete'] = 'failed';
        }
        header('Location:' . base_url . 'producto/gestion');
    }
}
