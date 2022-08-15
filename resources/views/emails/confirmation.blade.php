
@component('mail::message')
# Confirmacion de tu correo

Estimad@ <br>
{{$user->first_name}}. <br>
Tiene su rol {{$user->role_id}}. <br>
Haz clic en el siguiente boton para confirmar tu correo.

@component('mail::button', ['url' => 'https:///www.google.com', 'color'=>'success'])
Justo aqui
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
