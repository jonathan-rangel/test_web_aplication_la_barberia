<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\LoginController;
use Controllers\ReservationController;
use Controllers\ServiceController;
use MVC\Router;

$router = new Router();

//Página principal
$router->get('/', [LoginController::class, 'home']);
$router->post('/', [LoginController::class, 'home']);

//Iniciar sesión
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);

//Cerrar sesióm
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar contraseña
$router->get('/forgot_password', [LoginController::class, 'forgot_password']);
$router->post('/forgot_password', [LoginController::class, 'forgot_password']);
$router->get('/recover_password', [LoginController::class, 'recover_password']);
$router->post('/recover_password', [LoginController::class, 'recover_password']);

//Crear cuenta
$router->get('/create_account', [LoginController::class, 'create_account']);
$router->post('/create_account', [LoginController::class, 'create_account']);

//Confirmar cuenta
$router->get('/confirm_account', [LoginController::class, 'confirm_account']);
$router->get('/message', [LoginController::class, 'message']);

//Area de usuarios
$router->get('/reservation', [ReservationController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//API de citas
$router->get('/api/services', [APIController::class, 'getServices']);
$router->get('/api/products', [APIController::class, 'getProducts']);
$router->post('/api/reservations', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

//CRUD de servicios
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/add', [ServiceController::class, 'add_service']);
$router->post('/services/add', [ServiceController::class, 'add_service']);
$router->get('/services/edit', [ServiceController::class, 'edit_service']);
$router->post('/services/edit', [ServiceController::class, 'edit_service']);
$router->post('/services/delete', [ServiceController::class, 'delete_service']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();