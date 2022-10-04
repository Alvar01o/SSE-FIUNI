<div>
    <pre>{{$user->getNombreCompleto() }}, Has sido agregado al sistema de seguimiento de la FIUNI</pre>
    <a href="{{url('/acceso?invitacion='.$user->token_invitacion.'')}}">Acceda aqui para crear una contrasena</a>
</div>
