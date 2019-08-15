<?php

require_once 'models/usuario.php';

class UsuarioController
{
    public function index()
    {
        echo 'Controlador Usuario, Accion Index';
    }

    public function register()
    {
        require_once 'views/usuario/register.php';
    }
    public function save()
    {
        // require_once 'views/usuario/save-user.php';

        if (isset($_POST)) {
            $nombre = isset($_POST['name']) ? $_POST['name'] : false;
            $apellidos = isset($_POST['surname']) ? $_POST['surname'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            $errors = array();
            //CHECK DATA BEFORE INSERT IN DATABASE
            // Name validation
            if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
                $validated_name = true;
            } else {
                $validated_name = false;
                $errors['name'] = 'El nombre no es válido';
                echo $errors['name'];
            }
            // Surname validation
            if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
                $validated_surname = true;
            } else {
                $validated_surname = false;
                $errors['surname'] = 'Los apellidos no son válidos';
                echo $errors['surname'];
            }
            // Email validation
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validated_email = true;
            } else {
                $validated_email = false;
                $errors['email'] = 'El email no es válido';
                echo $errors['email'];
            }
            // Password validation
            if (!empty($password)) {
                $validated_password = true;
            } else {
                $validated_password = false;
                $errors['password'] = 'La contraseña no puede estar vacía';
                echo $errors['password'];
            }

            $save_user = false;
            if (empty($errors)) {
                $save_user = true;

                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setPassword($password);
                $save = $usuario->save();
                if ($save) {
                    $_SESSION['register'] = 'completed';
                } else {
                    $_SESSION['register'] = 'failed';
                    $_SESSION['errors'] = $errors;
                }
            } else {
                $_SESSION['register'] = 'failed';
                $_SESSION['errors'] = $errors;
            }
        }
        header('Location:' . base_url . 'usuario/register');
    }

    public function login()
    {
        if (isset($_POST)) {
            // IDENTIFICAMOS AL USUARIO
            // Consulta a la base de datos para comprobar credenciales
            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);
            $identity = $usuario->login();
            // Crear sesion

            if ($identity && is_object($identity)) {
                $_SESSION['identity'] = $identity;

                if ($identity->rol == 'admin') {
                    $_SESSION['admin'] = true;
                }
            } else {
                $_SESSION['error_login'] = '¡Ha habido un error al iniciar sesion!';
            }
        }
        header('Location: ' . base_url);
    }
    public function logout()
    {
        if (isset($_SESSION['identity'])) {
            $_SESSION['identity'] = null;
        }
        if (isset($_SESSION['admin'])) {
            $_SESSION['admin'] = null;
        }
        header('Location: ' . base_url);
    }
}
