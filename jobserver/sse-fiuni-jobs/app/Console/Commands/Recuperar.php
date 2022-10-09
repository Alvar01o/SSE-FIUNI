<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperarContrasena;
class Recuperar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:recuperar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recuperar contrasena';

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
        $usuario = User::role('egresado')->where('recuperar', '=', 1)->get()->first();
        if ($usuario) {
            Mail::to($usuario->email)->send(new RecuperarContrasena($usuario));
            $usuario->recuperar = 0;
            $usuario->save();
            $this->info("Se envio correo de recuperacion al usuario: {$usuario}!");
        }
        return 0;
    }
}
