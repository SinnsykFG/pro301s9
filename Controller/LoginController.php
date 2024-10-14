<?php

namespace Controller;

use MVC\Router;
use Model\Usuario;
use Classes\Email;
use PDO;
use Model\ActiveRecord;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
    
            $usuarioDB = Usuario::where('email', $usuario->email);
                
            if ($usuarioDB) {
                // Verificar contraseña
                if (password_verify($_POST['password'], $usuarioDB->password)) {
                    // Iniciar sesión
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
    
                    $_SESSION['id'] = $usuarioDB->id;
                    $_SESSION['nombre'] = $usuarioDB->nombre;
                    $_SESSION['email'] = $usuarioDB->email;
                    $_SESSION['login'] = true;
                    $_SESSION['tipo_usuario'] = $usuarioDB->tipo_usuario;
                    var_dump($usuarioDB); exit;
                    // Redirigir según rol
                    if ($usuarioDB->tipo_usuario === 'admin' || $usuarioDB->tipo_usuario === 'editor') {
                        header('Location: /noticias');
                    } else {
                        header('Location: /bienvenida');
                    }
                    exit;
                } else {
                    $alertas['error'][] = 'Contraseña incorrecta';
                }
            } else {
                $alertas['error'][] = 'El usuario no existe';
            }
        }
    
        $router->render('auth/login', ['alertas' => $alertas]);
    }
//    {   
//
//        $alertas = [];
//    
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $usuario = new Usuario($_POST);
//            $usuarioDB = Usuario::where('email', $usuario->email);
//    
//            if ($usuarioDB && password_verify($_POST['password'], $usuarioDB->password)) {
//                // Iniciar la sesión si no está iniciada
//                if (session_status() === PHP_SESSION_NONE) {
//                    session_start();
//                }
//    
//                $_SESSION['id'] = $usuarioDB->id;
//                $_SESSION['nombre'] = $usuarioDB->nombre;
//                $_SESSION['email'] = $usuarioDB->email;
//                $_SESSION['login'] = true;
//                $_SESSION['tipo_usuario'] = $usuarioDB->tipo_usuario;
//                error_log("Login exitoso. Usuario: " . $_SESSION['nombre'] . ", Tipo: " . $_SESSION['tipo_usuario']);
//
//                // Redirigir según el rol del usuario
//                if ($_SESSION['tipo_usuario'] === 'admin' || $_SESSION['tipo_usuario'] === 'editor') {
//                    header('Location: /agregar-noticia');
//                } else {
//                    self::mostrarNoticias($router);
//                }
//                exit;
//                // Redirigir según el rol del usuario
//               // header('Location: ' . ($_SESSION['tipo_usuario'] === 'lector' ? '/noticias' : '/agregar-noticia'));
//               // exit;
//            } else {
//                $alertas['error'][] = 'Usuario o contraseña incorrectos';
//            }
//        }
//    
//        $router->render('auth/login', ['alertas' => $alertas]);
//    }


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
        $usuario = new Usuario();
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
                        header('Location: views\auth\login.php');
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

    public static function mostrarNoticias(Router $router)
    {
        if(!isset($_SESSION['login'])|| $_SESSION['login'] == true){
            header('Location: /');
            exit;
        }
        $router->render('noticias');
    }

    public static function mostrarDeportes(Router $router)
    {
        if(!isset($_SESSION['login'])|| $_SESSION['login'] == true){
            header('Location: /');
            exit;
        }
        $router->render('deportes');
    }

    public static function mostrarNegocios(Router $router)
    {
        if(!isset($_SESSION['login'])|| $_SESSION['login'] == true){
            header('Location: /');
            exit;
        }
        $router->render('negocios');
    }

    public static function agregarNoticia(Router $router)
    {
        if(!isset($_SESSION['login'])|| $_SESSION['login'] == true){
            header('Location: /');
            exit;
        }
        $router->render('agregar-noticia');
        
    }
    public static function contacto(Router $router)
    {
        $router->render('auth/contacto', []);
    }
}

