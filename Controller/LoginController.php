<?php

namespace Controller;

use MVC\Router;
use Model\Usuario;
use Classes\Email;
;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);


            if ($usuario->login()) {
                error_log('Usuario logueado');
                if ($_SESSION['tipo_usuario'] === 'lector') {
                    header('Location: views\noticias.php');
                } else {
                    header('Location: views\agregar-noticia.php');
                }
                exit();
            } else {
                $alertas = Usuario::getAlertas();
            }
        
        }
        $router->render('auth/login', ['alertas' => $alertas]);
    }

    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: /');
        exit();
    }

    public static function olvide(Router $router)
    {
        $router->render('auth/olvide', []);
    }

    public static function recuperar()
    {
        echo "Desde el Recuperar";
    }

    public static function register(Router $router)
    {
        
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alertas esté vacío
            if (empty($alertas)) {           
                // Revisar si el usuario ya existe
                $resultado = $usuario->existeUsuario();

                if ($resultado) { // Cambiado para que PDO regrese un array, no un objeto
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();
                    // Generar un token único
                    $usuario->generarToken();
                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: auth/login');
                        exit;
                    } else {
                        Usuario::setAlerta('error','Hubo un problema al crear el usuario'); 
                    }
                    
                }
            }
        }

        $router->render('auth/register', [
            'usuario' => $usuario,
            'alertas' => Usuario::getAlertas()
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);

        Usuario::where('token', $token);

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}

