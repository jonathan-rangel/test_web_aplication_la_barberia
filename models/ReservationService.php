<?php

namespace Model;

class ReservationService extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'reservations_services';
    protected static $columnasDB = ['id', 'reservationId', 'serviceId'];

    public $id;
    public $reservationId;
    public $serviceId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->reservationId = $args['reservationId'] ?? '';
        $this->serviceId = $args['serviceId'] ?? '';
    }
}