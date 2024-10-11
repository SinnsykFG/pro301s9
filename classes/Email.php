<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
        
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'api';
        $mail->Password = '********8141';

        $mail->setFrom('cuentas@elfaro.com');
        $mail->addAddress('cuentas@elfaro.com', 'El Faro');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p><Strong>Hola ' . $this->nombre . ',</strong> Has creado tu cuenta en "El Faro", solo debes confirmar tu cuenta presionando el siguiente enlace</p>';
        $contenido .= '<p>Presiona aquí<a href="http://localhost:3000/confirmar-cuenta?token=' . $this->token . '">Confirmar cuenta</a></p>';
        $contenido .= 'Si no has creado la cuenta, ignora este mensaje';
        $contenido .= '</html>';
        $mail->Body = $contenido;

        //Enviar
        $mail->send();

    }
}
