<?php

namespace Model;

class Product extends ActiveRecord {
     //Base de datos
     protected static $tabla = 'products';
     protected static $columnasDB = ['id', 'name', 'price', 'description', 'image'];
 
     public $id;
     public $name;
     public $price;
     public $description;
     public $image;
 
     public function __construct($args = []) {
         $this->id = $args['id'] ?? null;
         $this->name = $args['name'] ?? '';
         $this->price = $args['price'] ?? null;
         $this->description = $args['description'] ?? '';
         $this->image = $args['image'] ?? '';
     }
}