@component('mail::message')
# Nuevo Producto

El  {{$user->role->name}}, <br>
{{$user->first_name}} <br>
ha creado un nuevo producto. <br>


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
