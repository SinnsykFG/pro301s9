<?php 

require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Controller\LoginController;
use MVC\Router;

$router = new Router();

// Rutas
//BIenvenida
$router->get('/bienvenida', [LoginController::class, 'bienvenida']);
// Iniciar Sesión
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
//Cerrar Sesión
$router->get('/logout', [LoginController::class, 'logout']);
//Recuperar contraseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
//crear cuenta
$router->get('/register', [LoginController::class, 'register']);
$router->post('/register', [LoginController::class, 'register']);





// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

