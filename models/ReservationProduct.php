<?php

namespace Model;

class ReservationProduct extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'reservations_products';
    protected static $columnasDB = ['id', 'reservationId', 'productId'];

    public $id;
    public $reservationId;
    public $productId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->reservationId = $args['reservationId'] ?? '';
        $this->productId = $args['productId'] ?? '';
    }
}