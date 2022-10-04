<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\cuentaNueva;
class Activacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:activacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activacion de cuenta para nuevos egresados';

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
        $usuarios = User::role('egresado')->where('notificado', '=', 0)->limit(20)->get();
        foreach ($usuarios as $key => $usuario_nuevo) {
            Mail::to($usuario_nuevo->email)->send(new cuentaNueva($usuario_nuevo));
            $usuario_nuevo->notificado = 1;
            $usuario_nuevo->save();
        }
        return 0;
    }
}
