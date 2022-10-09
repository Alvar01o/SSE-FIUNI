<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
class RecuperarContrasena extends Mailable
{
    use Queueable, SerializesModels;
    protected $usuario = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('recuperar', ['user' => $this->usuario])->subject('Sistema de Seguimiento de Egresados - Re-establecer Contraseña.');
    }
}
