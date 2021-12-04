<?php

namespace Controllers;

use Model\Service;
use MVC\Router;

class ServiceController {
    public static function index(Router $router) {
        if(!isset($_SESSION)) 
            session_start();
        isAdmin();

        $services = Service::all();

        $router->render('services/index', [
            'name' => $_SESSION['name'],
            'services' => $services
        ]);
    }

    public static function add_service(Router $router) {
        if(!isset($_SESSION)) 
            session_start();

        isAdmin();

        $service = new Service;
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->sincronizar($_POST);
            $alerts = $service->validateService();

            if(empty($alerts)) {
                $service->guardar();
                header('Location: /services');
            }
        }
        $router->render('services/add_service', [
            'name' => $_SESSION['name'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function edit_service(Router $router) {
        if(!isset($_SESSION)) 
            session_start();

        isAdmin();

        $service = Service::find($_GET['id']);
        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->sincronizar($_POST);

            $alerts = $service->validateService();

            if(empty($alerts)) {
                $service->guardar();
                header('Location: /services');
            }
        }
        $router->render('services/edit_service', [
            'name' => $_SESSION['name'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function delete_service(Router $router) {
        if(!isset($_SESSION)) 
            session_start();

        isAdmin();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $service = Service::find($id);
            $service->eliminar();
            header('Location: /services');
        }
    }
}