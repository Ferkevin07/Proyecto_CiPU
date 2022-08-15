@component('mail::message')
# Nuevo Comentario

Un cliente a posteado un comentario. <br>
{{$user->first_name}} <br>

@component('mail::button', ['url' => '', 'color' => 'success'])
Ok
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
