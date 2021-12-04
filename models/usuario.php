<?php

namespace Model;

class Usuario extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'last_name', 'email', 'password', 'phone_number', 'admin', 'confirmed', 'token'];

    public $id;
    public $name;
    public $last_name;
    public $email;
    public $password;
    public $phone_number;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone_number = $args['phone_number'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmed = $args['confirmed'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    public function validateEmail() {
        if(!$this->email)
            self::$alertas['error'][] = 'Introduce un correo electrónico';
        
        return self::$alertas;
    }

    public function validateLogin() {
        if(!$this->email)
            self::$alertas['error'][] = 'Introduce un correo electrónico';

        if(!$this->password) 
            self::$alertas['error'][] = 'Introduce una contraseña';

        return self::$alertas;
    }

    //Mensajes de validación para la creación de una cuenta
    public function validateNewAccount() {
        if(!$this->name) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->last_name) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if(!$this->phone_number) {
            self::$alertas['error'][] = 'El número de teléfono es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El correo electrónico es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos a 8 caracteres';
        }

        return self::$alertas;
    }

    public function userExist() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 ";
        
        $result = self::$db->query($query);

        if($result->num_rows) {
            self::$alertas['error'][] = 'Esta cuenta ya se encuentra registrado';
        }

        return $result;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    }

    public function checkPasswordAndConfirmedAccount($password) {
        $result = password_verify($password, $this->password);

        if(!$result) {
            self::$alertas['error'][] = 'El correo electrónico y/o la contraseña son incorrectos';
        } else {
            if(!$this->confirmed) {
                self::$alertas['error'][] = 'Tu cuenta aún no ha sido confirmada';
            } else {
                return true;
            }
        }
    }

    public function validatePassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'Debes escribir una nueva contraseña';
        }
        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos a 8 caracteres';
        }

        return self::$alertas;
    }
}