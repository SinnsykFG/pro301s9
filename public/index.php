<?php 

require_once __DIR__ . '/../includes/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/pdo.php';

use Controller\LoginController;
use MVC\Router;

$router = new Router();

// Rutas
// Iniciar Sesión
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
//Cerrar Sesión
$router->get('/logout', [LoginController::class, 'logout']);
//Recuperar contraseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
//crear cuenta
$router->get('/register', [LoginController::class, 'register']);
$router->post('/register', [LoginController::class, 'register']);
//Contacto
$router->get('/contacto', [LoginController::class, 'contacto']);

// Rutas privadas con autenticación
$router->get('/noticias', function($router) {
    $router -> render('noticias');
});

$router->get('/deportes', function() {
    $router -> render('deportes');
});

$router->get('/negocios', function() {
    $router -> render('negocios');
});

$router->get('/agregar-noticia', function() {
    $router -> render('agregar-noticia');
});



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

