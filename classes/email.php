<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $name;
    public $token;
    public function __construct($email, $name, $token){
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation() {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'ac46b35294b8d6';
        $mail->Password = '2861d6adff401c';

        $mail->setFrom('Labarberia@LaBarberia.com');
        $mail->addAddress('Labarberia@LaBarberia.com', 'LaBarbería.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $this->name . "</strong> Has creado tu cuenta en La barbería.
        Debes confirmar tu cuenta presionando el siguiente enlace.</p>";
        $content .= "<p>Presiona aquí: <a href='http://localhost:3000/confirm_account?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $content .= "<p>Si no solicitaste esta confirmación puedes ignorar este correo.</p>";
        $content .= "<p>La barbería</p>";
        $content .= "</html>";
        $mail->Body = $content;

        //Enviar email
        $mail->send();


    }

    public function sendInstructions() {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'ac46b35294b8d6';
        $mail->Password = '2861d6adff401c';

        $mail->setFrom('Labarberia@LaBarberia.com');
        $mail->addAddress('Labarberia@LaBarberia.com', 'LaBarbería.com');
        $mail->Subject = 'Restablecer contraseña';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $this->name . "</strong> Se ha solicitado restablecer
        la contraseña. Da clic en el siguiente enlace para restablecerla</p>";
        $content .= "<p>Presiona aquí: <a href='http://localhost:3000/recover_password?token=" . $this->token . "'>Restablecer la contraseña</a></p>";
        $content .= "<p>Si no solicitaste restablecer la contraseña puedes ignorar este correo.</p>";
        $content .= "<p>La barbería</p>";
        $content .= "</html>";
        $mail->Body = $content;

        //Enviar email
        $mail->send();
    }
}