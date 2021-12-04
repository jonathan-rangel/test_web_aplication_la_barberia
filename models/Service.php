<?php

namespace Model;

class Service extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'services';
    protected static $columnasDB = ['id', 'name', 'price', 'description'];

    public $id;
    public $name;
    public $price;
    public $description;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->price = $args['price'] ?? null;
        $this->description = $args['description'] ?? '';
    }

    public function validateService() {
        if(!$this->name)
            self::$alertas['error'][] = 'Debes agregar un nombre al servicio';
        if(!$this->price)
            self::$alertas['error'][] = 'Debes agregar un precio al servicio';
        if(!$this->description)
            self::$alertas['error'][] = 'Debes agregar una descripción al servicio al servicio';

        return self::$alertas;
    }
}