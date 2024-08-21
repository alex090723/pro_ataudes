<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestMail()
    {
        try {
            Mail::raw('Prueba de envío de correo', function ($message) {
                $message->to('gersonaguilar@gmail.com')
                        ->subject('Correo de prueba');
            });

            return "Correo enviado correctamente";
        } catch (\Exception $e) {
            return "Error al enviar el correo: " . $e->getMessage();
        }
    }
}
