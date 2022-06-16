<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Response\json;
use Illuminate\Http\JsonResponse;

class ProfileInformationController extends Controller
{
    // Avatar para guardar la imagen del usuario
    // https://ui-avatars.com/
    private string $ui_avatar_api = "https://ui-avatars.com/api/?name=*+*&size=128";


    // Función para presentar la vista, el cual permite actualizar los datos del perfil
    // Se pasa como datos a la vista el usuario actual
    public function edit()
    {
        /* return response()->json([
            'name'=>'profile',
            'code'=>'400'
        ]); */
        return view('profile.show', ['user' => Auth::user()]);
    }


    // Función para actualizar los datos del perfil
    public function update(Request $request)
    {

        // Validar los datos de la petición
        $request->validate([

            'first_name' => ['required', 'string', 'alpha','min:3', 'max:35'],
            'last_name' => ['required', 'string', 'min:3', 'max:35'],
            'username' => ['required', 'string', 'min:3', 'max:20'],
            // Validar que la fecha de nacimiento sea mayor de 18 y menor a 70 años
            'birthdate' => ['nullable', 'string', 'date_format:d/m/Y',
                'after_or_equal:' . date('Y-m-d', strtotime('-70 years')),
                'before_or_equal:' . date('Y-m-d', strtotime('-18 years'))],
            'personal_phone' => ['required', 'numeric', 'digits:10'],
            'home_phone' => ['required', 'numeric', 'digits:9'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ]);

        // Se obtiene el usuario desde la petición
        $user = $request->user();


        // Se actualiza los datos por medio de Eloquent
        $user->first_name = $request['first_name'];

        $user->last_name = $request['last_name'];

        $user->username = $request['username'];

        $user->birthdate = $this->verifyDateFormat($request['birthdate']);

        $user->personal_phone = $request['personal_phone'];

        $user->home_phone = $request['home_phone'];

        $user->address = $request['address'];

        $user->save();

        // LLamar a la funcion para guardar la imagen
        //$this->updateUIAvatar($user);
        // Se imprime el mensaje de exito
        return back()->with('status', 'Profile update successfully');
    }


    // Función que permite actualizar el avatar en base al nombre y apellido
    /* private function updateUIAvatar(User $user)
    {
        // Usar la relación polimórfica
        $user_image = $user->image;

        $image_path = $user_image->path;

        // Determina si una cadena dada comienza con una subcadena dada.
        if (Str::startsWith($image_path, 'https://'))
        {

            $user_image->path = Str::replaceArray(
                '*',
                [
                    $user->first_name,
                    $user->last_name
                ],
                $this->ui_avatar_api
            );
            $user_image->save();
        }
    } */

    // Función para validar el formato de la fecha de nacimiento
    private function verifyDateFormat(?string $date)
    {
        return isset($date)
            ? $this->changeDateFormat($date, 'd/m/Y')
            : null;
    }

    // Cambiar el formato para almacenar en la BDD
    public static function changeDateFormat(string $date, string $date_format, string $expected_format = 'Y-m-d')
    {
        return Carbon::createFromFormat($date_format, $date)->format($expected_format);
    }


}