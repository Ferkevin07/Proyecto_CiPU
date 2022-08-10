
@component('mail::message')
# Confirmacion de tu correo

Estimad@ 
{{$user->first_name}}.
Tiene su rol {{$user->role_id}}.
Haz clic en el siguiente boton para confirmar tu correo.

@component('mail::button', ['url' => 'https:///www.google.com', 'color'=>'success'])
Justo aqui
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
