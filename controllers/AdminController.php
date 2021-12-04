<?php

namespace Controllers;

use Model\AdminReservation;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        if(!$_SESSION)
            session_start();

        isAdmin();
        $date = $_GET['date'] ?? date ('Y-m-d', strtotime('-6 hours') );

        $date_check = explode('-', $date);

        if(!checkdate($date_check[1], $date_check[2], $date_check[0]))
            header('Location: /404');


        //Consultar a la DB
        $query = "SELECT reservations.id, reservations.time, CONCAT(users.name, ' ', users.last_name) as client_name,";
        $query .= " users.email, users.phone_number, services.name as service, services.price";
        $query .= " FROM reservations";
        $query .= " LEFT OUTER JOIN users";
        $query .= " ON reservations.userId=users.id";
        $query .= " LEFT OUTER JOIN reservations_services";
        $query .= " ON reservations_services.reservationId=reservations.id";
        $query .= " LEFT OUTER JOIN services";
        $query .= " ON services.id=reservations_services.serviceId";
        $query .= " WHERE date =  '${date}' ";

        $reservations = AdminReservation::SQL($query);

        $router->render('admin/index', [
            'name' => $_SESSION['name'],
            'reservations' => $reservations,
            'date' => $date
        ]);
    }
}