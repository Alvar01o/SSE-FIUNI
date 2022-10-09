<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Encuestas;
use App\Models\User;
class InvitacionEncuesta extends Mailable
{
    use Queueable, SerializesModels;
    protected $encuesta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Encuestas $encuesta)
    {
        $this->encuesta = $encuesta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->encuesta->tipo == 'empleador') {
        return $this->view('invitacion_empleador', ['encuesta' => $this->encuesta])->subject('Sistema de Seguimiento de Egresados - Invitacion a Encuesta de Empleador.');
        } else {
        return $this->view('invitaciones', ['encuesta' => $this->encuesta])->subject('Sistema de Seguimiento de Egresados - Invitacion a Encuesta.');
        }

    }
}
