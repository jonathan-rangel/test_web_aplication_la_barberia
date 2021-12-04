<?php
namespace Controllers;

use Model\Service;
use Model\Product;
use Model\Reservation;
use Model\ReservationProduct;
use Model\ReservationService;

class APIController {
    public static function getServices() {
        $services = Service::all();
        echo json_encode($services);
    }

    public static function getProducts() {
        $products = Product::all();
        echo json_encode($products);
    }

    public static function save() {
        //Almacena la reservación
        $reservation = new Reservation($_POST);
        $result = $reservation->guardar();

        $id = $result['id'];

        //Almacena la reservación, el producto y el servicio
        $servicesId = explode(",", $_POST['services']);
        $productsId = explode(",", $_POST['products']);

        foreach($servicesId as $serviceId) {
            $args = [
                'reservationId' => $id,
                'serviceId' => $serviceId
            ];
            $res_ser = new ReservationService($args);
            $res_ser->guardar();
        }

        foreach($productsId as $productId) {
            $args = [
                'reservationId' => $id,
                'productId' => $productId
            ];
            $res_pro = new ReservationProduct($args);
            $res_pro->guardar();
        }
        
        echo json_encode(['result' => $result]);
    }
        
    public static function delete() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $reservation = Reservation::find($id);
            $reservation->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);

            debuguear($reservation);
        }
    }
}