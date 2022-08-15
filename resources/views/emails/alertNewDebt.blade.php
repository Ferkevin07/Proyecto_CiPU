@component('mail::message')
# Nueva Deuda

El {{$user->role->name}}, <br>
{{$user->first_name}} {{$user->last_name}} <br>
Ha creado una nueva deuda.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
