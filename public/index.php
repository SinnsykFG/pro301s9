<?php 
ob_start();
require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/PDO.php';

use Controller\LoginController;
use MVC\Router;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$router = new Router();

// Rutas
// Iniciar Sesión
$router->get('/', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);

//Cerrar Sesión
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar contraseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);

//Crear cuenta
$router->get('/register', [LoginController::class, 'register']);
$router->post('/register', [LoginController::class, 'register']);

//Contacto
$router->get('/contacto', [LoginController::class, 'contacto']);

// Rutas privadas con autenticación
$router->get('/noticias', [LoginController::class, 'mostrarNoticias']);
$router->get('/deportes', [LoginController::class, 'mostrarDeportes']);
$router->get('/negocios', [LoginController::class, 'mostrarNegocios']);
$router->get('/agregar-noticia', [LoginController::class, 'agregarNoticia']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
ob_end_flush();