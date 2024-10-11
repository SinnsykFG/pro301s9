<?php

namespace Controller;

use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController
{
    public static function login(Router $router)
    {
        $router->render('auth/login');
    }

    public static function logout()
    {
        echo "Desde el Logout";
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
        $usuario = new Usuario($_POST);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alertas esté vacío
            if (empty($alertas)) {
                echo "Todos los campos fueron llenados correctamente";
                
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
                        header('Location: /login');
                    } else {
                        echo "Error al crear el usuario";
                    }
                    debuguear($usuario);
                }
            }
        }

        $router->render('auth/register', [
            'usuario' => $usuario
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

        Usuario::where('token', $token); // Cambié el token aquí para obtener dinámicamente el valor de $_GET

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
