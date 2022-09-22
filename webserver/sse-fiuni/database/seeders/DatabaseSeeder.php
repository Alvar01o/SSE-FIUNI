<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Carreras;
use App\Models\Laboral;

use App\Models\Encuestas;
use App\Models\Preguntas;
use App\Models\OpcionesPregunta;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //creacion de Carreras
        $carrera1 = Carreras::create([
                'carrera' => 'Ingenieria Informatica'
        ]);

        $carrera2 = Carreras::create([
                'carrera' => 'Ingenieria Electromecanica'
        ]);

        $carrera3 = Carreras::create([
                'carrera' => 'Ingenieria Civil'
        ]);

        $role = Role::create(['name' => 'visitante']);

        // roles y permisos
        $role = Role::create(['name' => User::ROLE_ADMINISTRADOR]);
        $role->givePermissionTo(Permission::create(['name' => 'Generar Reportes']));
        $ver_empresa_permiso = Permission::create(['name' => 'Ver Empresas']);
        $role->givePermissionTo($ver_empresa_permiso);
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Administradores']));
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Empleador']));
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Egresados']));

        //        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => User::ROLE_EGRESADO]);
        $role->givePermissionTo($ver_empresa_permiso);
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Perfil de Egresados']));
        $role->givePermissionTo(Permission::create(['name' => 'Completar Encuesta de Egresados']));


        $role = Role::create(['name' => User::ROLE_EMPLEADOR]);
        $role->givePermissionTo(Permission::create(['name' => 'Completar Encuesta de Empleador']));

        //usuario - administrador para pruebas
        $user = User::create([
                'nombre' => 'Admin',
                'apellido' => '#1',
                'ci' => 0000001,
                'confirmado' => true,
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
        ]);

        $user->assignRole(User::ROLE_ADMINISTRADOR);

        //usuario - Egresado para pruebas
        $user = User::create([
                'nombre' => 'Egresado',
                'apellido' => '#1',
                'ci' => 0000002,
                'confirmado' => true,
                'carrera_id' => $carrera1->id,
                'email' => 'egresado@gmail.com',
                'password' => bcrypt('egresado'),
        ]);

        $user->assignRole(User::ROLE_EGRESADO);

        //usuario - Empleador para pruebas
        $user = User::create([
                'nombre' => 'Empleador',
                'apellido' => '#1',
                'ci' => 0000003,
                'confirmado' => true,
                'email' => 'empleador@gmail.com',
                'password' => bcrypt('empleador'),
        ]);
        $user->assignRole(User::ROLE_EMPLEADOR);
        //final de usuarios de prueba
        echo "Creando Egresados de prueba!!.. \n";
        for ($i=0; $i < 30; $i++) {
            $FourDigitRandomNumber = rand(1231,9999);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Informatica - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera1->id,
                    'egreso' => rand(2018, 2022),
                    'ci' => $FourDigitRandomNumber,
                    'email' => "egresado{$FourDigitRandomNumber}@informatica.com",
                    'token_invitacion' => base64_encode(bcrypt("egresado{$FourDigitRandomNumber}@informatica.com".time())),
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Electromecanica - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera2->id,
                    'egreso' => rand(2018, 2022),
                    'ci' => $FourDigitRandomNumber,
                    'email' => "egresado{$FourDigitRandomNumber}@electro.com",
                    'token_invitacion' => base64_encode(bcrypt("egresado{$FourDigitRandomNumber}@electro.com".time())),
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Civil - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera3->id,
                    'ci' => $FourDigitRandomNumber,
                    'egreso' => rand(2018, 2022),
                    'email' => "egresado{$FourDigitRandomNumber}@civil.com",
                    'token_invitacion' => base64_encode(bcrypt("egresado{$FourDigitRandomNumber}@civil.com".time())),
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);

            //usuario - Empleador para pruebas
            $user = User::create([
                    'nombre' => base64_encode($FourDigitRandomNumber),
                    'apellido' => base64_encode($FourDigitRandomNumber),
                    'ci' => $FourDigitRandomNumber,
                    'confirmado' => true,
                    'email' => 'empleador'.$FourDigitRandomNumber.'@gmail.com',
                    'password' => bcrypt('empleador'),
            ]);
            $user->assignRole(User::ROLE_EMPLEADOR);
        }
        Laboral::create(['empresa' => 'inventiva']);
        Laboral::create(['empresa' => 'Integradevs']);
        Laboral::create(['empresa' => 'Borealis']);
        Laboral::create(['empresa' => 'MoV']);

        $encuestaEmpleador = Encuestas::create([
            'nombre' => 'Encuesta Empelador 2022',
            'tipo' => 'empleador'
        ]);

        $encuestaEgresados = Encuestas::create([
            'nombre' => 'Encuesta Egresado 2022',
            'tipo' => 'egresado'
        ]);
        // tipo de preguntas disponibles  => 'pregunta','seleccion_multiple','seleccion_multiple_justificacion','seleccion','seleccion_justificacion'
        //si la pregunta no es de tipo pregunta simple incluir el valor 'opciones' => []
        $preguntas = [
                        [
                            'pregunta' => 'Pregunta simple',
                            'requerido' => 1,
                            'justificacion' => '',
                            'encuesta_id' => $encuestaEgresados->id,
                            'tipo_pregunta' => 'pregunta'
                        ],
                        [
                            'pregunta' => 'Pregunta seleccion multiple',
                            'requerido' => 1,
                            'justificacion' => '',
                            'encuesta_id' => $encuestaEgresados->id,
                            'tipo_pregunta' => 'seleccion_multiple',
                            'opciones' => [
                                'si',
                                'no'
                            ]
                        ]
                    ];
        foreach ($preguntas as $key => $pregunta) {
            if ($pregunta['tipo_pregunta'] !== 'pregunta') {
                    $datos_para_nueva_pregunta = [
                        'pregunta' => $pregunta['pregunta'],
                        'tipo_pregunta' => $pregunta['tipo_pregunta'],
                        'encuesta_id' => $pregunta['encuesta_id'],
                        'requerido' =>  $pregunta['requerido'] == 'on' ? 1 : 0
                    ];
                    $opciones = $pregunta['opciones'];
                    $pregunta = Preguntas::create($datos_para_nueva_pregunta);
                    foreach($opciones as $key => $opcion) {
                        OpcionesPregunta::create([
                            'pregunta_id' => $pregunta->id,
                            'encuesta_id' => $pregunta->encuesta_id,
                            'opcion' => $opcion
                        ]);
                    }
            } else {
                $pregunta = Preguntas::create([
                    'pregunta' => $pregunta['pregunta'],
                    'tipo_pregunta' => $pregunta['tipo_pregunta'],
                    'encuesta_id' => $pregunta['encuesta_id'],
                    'requerido' => $pregunta['requerido']
                ]);
            }
        }
    }
}
