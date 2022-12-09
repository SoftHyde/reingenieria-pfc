<p>
	Hola {{ $user->name }}, te informamos que has sido suspendido de la plataforma por {{$time}} dias debido a las siguientes razones:
	<br>
	<strong>{{$user->ban_reason}}</strong>
	<br>
	No podrás iniciar sesión hasta que se levante la suspensión. Te informaremos cuando eso suceda.
</p>