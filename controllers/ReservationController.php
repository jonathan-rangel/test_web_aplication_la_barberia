<?php

namespace Controllers;

use MVC\Router;

class ReservationController {
    public static function index(Router $router) {
        if(!$_SESSION)
            session_start();
        
        isAuth();

        $router->render('reservation/index', [
            'name_last' => $_SESSION['name_last'],
            'id' => $_SESSION['id']
        ]);
    }
}

