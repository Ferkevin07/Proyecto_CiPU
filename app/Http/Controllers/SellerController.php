<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Manager;
use App\Notifications\RegisteredManagerNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Resources\Seller as SellerResource;

class SellerController extends Controller
{


    public function __construct()
    {
        /* $this->middleware('can:manage-directors');

        $this->middleware('active.user')->only('edit', 'update');
        
        $this->middleware('verify.user.role:director')->except('index', 'create', 'store', 'search'); */
    }




    // Función para mostrar la vista principal de todo los directores
    public function index()
    {
        /* // Traer el rol director
        $seller_role = Role::where('name', 'seller')->first();
        // Obtener todos los usuarios que sean directores
        $sellers = $seller_role->managers();

        if (request('search'))
        {
           $sellers = $sellers->where('username', 'like', '%' . request('search') . '%');
        }

        $sellers = $sellers->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->paginate(5);


        // Mandar a la vista los usuarios que sean directores
        //return view('seller.index', compact('sellers'));
        //return response()->json($sellers);

        return SellerResource::collection(Manager::where('role_id',2)->get()); */
        return response()->json('hola',200);
    }




    // Función para mostrar la vista del formulario
    public function create()
    {
        return view('seller.create');
    }


    // Función para tomar los datos del formulario y guardar en la BDD
    public function store(Request $request)
    {

        // Validación de datos respectivos
        $request->validate([
        'first_name' => ['required', 'string', 'min:3', 'max:35'],
        'last_name' => ['required', 'string', 'min:3', 'max:35'],
        'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        // Validar que la fecha de cumplaeños sea mayor de 18 y menor a 70 años
        'birthdate' => ['required', 'string', 'date_format:d/m/Y',
            'after_or_equal:' . date('Y-m-d', strtotime('-70 years')),
            'before_or_equal:' . date('Y-m-d', strtotime('-18 years')),
        ],
        'personal_phone' => ['required', 'numeric', 'digits:10'],
        'home_phone' => ['required', 'numeric', 'digits:9'],
        'address' => ['required', 'string', 'min:5', 'max:50']
    ]);

        // Invocar a la función para generar una contraseña
        $password_generated = $this->generatePassword();
        // Traer el rol director
        $seller_role = Role::where('name', 'seller')->first();

        $seller = $seller_role->managers()->create([
            'first_name' => $request['first_name'],

            'last_name' => $request['last_name'],

            'username' => $request['username'],

            'email' => $request['email'],

            'birthdate' => $this->changeDateFormat($request['birthdate']),

            'personal_phone' => $request['personal_phone'],

            'home_phone' => $request['home_phone'],

            'address' => $request['address'],

            'password' => Hash::make($password_generated),
        ]);

        // Se crear el avatar y se almacena en la BDD por medio de ELOQUENT y su relación
        //$seller->image()->create(['path' => $seller->generateAvatarUrl()]);

        // Se procede a enviar una notificación al correo
        $seller->notify(
            new RegisteredManagerNotification(
                $seller->getFullName(),
                $seller_role->name,
                $password_generated
            )
        );
        // Se imprime el mensaje de exito
        return back()->with('status', 'Seller created successfully');
    }


   // Función para mostrar la vista y los datos de un solo director
    public function show(Manager $manager)
    {
        //dd($manager);
        return view('seller.show', ['seller' => $manager]);
    }



    // Función para mostrar la vista y los datos de un solo director a través de un formulario
    public function edit(Manager $manager)
    {
        return view('seller.update', ['seller' => $manager]);
    }



    // Función para tomar los datos del formulario y actualizar en la BDD
    public function update(Request $request, Manager $manager)
    {

        // Obtener el model del usuario
        $managerRequest = $request->manager;

        // Validación de datos respectivos
        $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:35'],
            'last_name' => ['required', 'string', 'min:3', 'max:35'],

            'username' => ['required', 'string', 'min:5', 'max:20',
                Rule::unique('managers')->ignore($managerRequest),
            ],


            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('managers')->ignore($managerRequest),
            ],

            // Validar que la fecha de cumplaeños sea mayor de 18 y menor a 70 años
            'birthdate' => ['nullable', 'string', 'date_format:d/m/Y',
                'after_or_equal:' . date('Y-m-d', strtotime('-70 years')),
                'before_or_equal:' . date('Y-m-d', strtotime('-18 years')),
            ],
            'personal_phone' => ['required', 'numeric', 'digits:10'],
            'home_phone' => ['required', 'numeric', 'digits:9'],
            'address' => ['required', 'string', 'min:5', 'max:50'],
        ]);

        // Se obtiene el email antiguo del usuario
        $old_email = $manager->email;
        // Se obtiene el modelo del usuario
        $seller = $manager;


        $seller->update([
        'first_name' => $request['first_name'],
        'last_name' => $request['last_name'],
        'username' => $request['username'],
        'email' => $request['email'],
        'birthdate' => $this->changeDateFormat($request['birthdate']),
        'personal_phone' => $request['personal_phone'],
        'home_phone' => $request['home_phone'],
        'address' => $request['address'],
        ]);

        // Se procede con la actualización del avatar del usuario
        //$seller->updateUIAvatar($seller->generateAvatarUrl());

        // Función para verificar si el usuario cambio el email
        $this->verifyEmailChange($seller, $old_email);
        // Se imprime el mensaje de exito
        return back()->with('status', 'Seller updated successfully');
    }

    // Función para dar de baja a un director en la BDD
    public function destroy(Manager $manager)
    {
        // Tomar el modelo del usuario
        $seller = $manager;
        // Tomar el estado del director
        $state = $seller->state;
        // Almacenar un mensaje para el estado
        $message = $state ? 'inactivated' : 'activated';
        // Cambiar el estado del usuario
        $seller->state = !$state;
        // Guardar los cambios
        $seller->save();
        // Se imprime el mensaje de exito
        return back()->with('status', "Seller $message successfully");
    }



    // Función para generar una contraseña
    public function generatePassword()
    {
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $length = 8;
        $count = mb_strlen($characters);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($characters, $index, 1);
        }
        return $result;
    }



    public function changeDateFormat(string $date, string $date_format='d/m/Y', string $expected_format = 'Y-m-d')
    {
        return Carbon::createFromFormat($date_format, $date)->format($expected_format);
    }



    private function verifyEmailChange(Manager $seller, string $old_email)
    {
        if ($seller->email !== $old_email)
        {
            $password_generated = $this->generatePassword();

            $seller->password = Hash::make($password_generated);

            $seller->save();

            $seller->notify(
                new RegisteredManagerNotification(
                    $seller->getFullName(),
                    $seller->role->name,
                    $password_generated
                )
            );
        }
    }


}