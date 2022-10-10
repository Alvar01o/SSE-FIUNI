<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Encuestas;
use App\Models\EncuestaUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitacionEncuesta;

class Invitaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:invitacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia Invitaciones a Encuesta si es que existe alguna';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $invitaciones = Encuestas::select(['users.*', 'encuestas.nombre as nombre_encuesta', 'encuestas.id as encuesta_id', 'encuestas.tipo as tipo', 'encuesta_users.invitacion_empleadores'])->where('bloqueado', '=', 1)
        ->join('encuesta_users', 'encuesta_users.encuesta_id', '=', 'encuestas.id')
        ->join('users', 'encuesta_users.user_id', '=', 'users.id')
        ->where('encuesta_users.notificado', '=', 0)->limit(20)->get();
        $receptores = [];
        $usuarios = [];
        $tipo_encuesta = null;
        $nombre_encuesta = null;
        $encaso_que_sea_de_empleadores = [];
        foreach ($invitaciones as $key => $usuarios_encuesta) {
            $receptores[] = $usuarios_encuesta->email;
            $usr = EncuestaUsers::where('user_id', '=', $usuarios_encuesta->id)->where('encuesta_id', '=', $usuarios_encuesta->encuesta_id)->first();
            $usr->notificado = 1;
            $usuarios[] = $usr;
            if (is_null($tipo_encuesta)) {
                $tipo_encuesta = $usuarios_encuesta->tipo;
                $nombre_encuesta = $usuarios_encuesta->nombre_encuesta;
            }
            $encaso_que_sea_de_empleadores[$usuarios_encuesta->id] = $usuarios_encuesta;
        }
        if ($receptores) {
            if ($tipo_encuesta == 'egresado') {
                Mail::to($receptores)->send(new InvitacionEncuesta($usuarios_encuesta));
                foreach ($usuarios as $key => $usr) {
                    $usr->save();
                    $this->info("Se envio correo de invitacion a :". $usr->email);
                }
            } else {
                foreach ($usuarios as $key => $usr) {
                    if (array_key_exists($usr->user_id, $encaso_que_sea_de_empleadores)) {
                        $encuesta_user_obj = $encaso_que_sea_de_empleadores[$usr->user_id];
                        Mail::to($encuesta_user_obj->email)->send(new InvitacionEncuesta($encuesta_user_obj));
                        $this->info("Se envio correo de invitacion a :". $encuesta_user_obj->email);
                        $usr->save();
                    }
                }
            }
        }
        return 0;
    }
}
