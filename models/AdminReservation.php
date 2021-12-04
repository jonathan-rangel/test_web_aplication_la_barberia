<?php

namespace Model;

class AdminReservation extends ActiveRecord {
    protected static $tabla = 'reservations_services';
    protected static $columnasDB = ['id', 'time', 'client_name', 'email', 'phone_number', 'service', 'price'];

    public $id;
    public $time;
    public $client_name;
    public $email;
    public $phone_number;
    public $service;
    public $price;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->time = $args['time'] ?? '';
        $this->client_name = $args['client_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone_number = $args['phone_number'] ?? '';
        $this->service = $args['service'] ?? '';
        $this->price = $args['price'] ?? '';
    }
}