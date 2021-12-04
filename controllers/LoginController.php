<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function home(Router $router) {
        $router->render('auth/home');
    }

    public static function login(Router $router) {
        $alerts = [];

        $auth = new Usuario;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alerts = $auth->validateLogin();

            if(empty($alerts)) {
                //Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    //Verficar el password
                    if($usuario->checkPasswordAndConfirmedAccount($auth->password)) {
                        //Autenticar el usuario
                        //Redireccionamiento
                        if($usuario->admin === '1') {
                            session_id("admin");
                            session_start();
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['name'] = $usuario->name;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            session_id("user" . rand());
                            session_start();
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['name_last'] = $usuario->name . ' ' . $usuario->last_name;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;
                            header('Location: /reservation');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El correo electrónico y/o la contraseña son incorrectos');
                }
            }
        }

        $alerts = Usuario::getAlertas();
        
        $router->render('auth/login', [
            'alerts' => $alerts,
            'auth' => $auth
        ]);
        
    }

    public static function logout() {
        session_start();
        $_SESSION = [];

        header('Location: /');
    }

    public static function forgot_password(Router $router) {
        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alerts = $auth->validateEmail();

            if(empty($alerts)) {
                $user = Usuario::where('email', $auth->email);
                if($user && $user->confirmed === '1') {
                    //Generar un token
                    $user->createToken();
                    $user->guardar();
                    
                    //Enviar el email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstructions();


                    //Alerta de éxito
                    Usuario::setAlerta('success', 'Hemos enviado instrucciones a tu correo electrónico');
                } else 
                    Usuario::setAlerta('error', 'No hay cuenta asociada a este correo electrónico o no está confirmada');
            }
        }

        $alerts = Usuario::getAlertas();

        $router->render('auth/forgot_password', [
            'alerts' => $alerts
        ]);
    }

    public static function recover_password(Router $router) {
        $alerts = [];
        $error = false;

        $token = s($_GET['token']);
        
        //Buscar usuario por su token

        $user = Usuario::where('token', $token);

        if(empty($user)) {
            Usuario::setAlerta('error', 'El token no es válido o ya expiró');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Obtener la nueva contraseña y guardarlo
            $password = new Usuario($_POST);
            $alerts = $password->validatePassword();

            if(!$alerts) {
                $user->password = NULL;
                $user->password = $password->password;
                $user->hashPassword();
                $user->token = NULL;

                $result = $user->guardar();
                if($result) {
                    header('Location: /login');
                }
            }
        }

        $alerts = Usuario::getAlertas();

        $router->render('auth/recover_password', [
            'alerts' => $alerts,
            'error' => $error
        ]);
    }

    public static function create_account(Router $router) {
        $usuario = new Usuario;
        
        //Alertas vacias
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alerts = $usuario->validateNewAccount();
        
            //Revisar que alert este vacio
            if (empty($alerts)) {
                //Verificar que el usuario no esté registrado
                $result = $usuario->userExist();
                
                if($result->num_rows) {
                    $alerts = Usuario::getAlertas();
                } else {
                    //Hashear el password
                    $usuario->hashPassword();
                    //Generar token único

                    $usuario->createToken();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->name, $usuario->token);
                    $email->sendConfirmation();

                    //Crear el usuario
                    $result = $usuario->guardar();
                    if($result) {
                        header('Location: /message');
                    }   
                }
            }
        } 
        
        $router->render('auth/crear_cuenta', [
            'usuario' => $usuario,
            'alerts' => $alerts
        ]);
    }

    public static function message(Router $router) {
        $router->render('auth/message');
    }
    
    public static function confirm_account(Router $router) {
        $alerts = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'El token ya no es válido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirmed = '1';
            $usuario->token = NULL;
            $usuario->guardar();
            Usuario::setAlerta('success', 'La cuenta se confirmó correctamente');
        }
        //Obtner las alertas
        $alerts = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirm_account', [
            'alerts' => $alerts
        ]);
    }
}