<div>
    <pre>{{$user->getNombreCompleto() }}, Has solicitado la recuperacion de contraseña en el sistema de seguimiento de Egresados</pre>
    <a href="{{url('/actualizar_contrasena?solicitud='.$user->token_invitacion.'')}}">Acceda aqui para actualizar tu contrasena</a>
</div>
