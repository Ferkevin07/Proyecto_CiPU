<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-manage-resources');
    }   

    public function index()
    {
        $client=User::where('role_id',4)->get();
        return $client;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([            
            'username'=> ['required'],
            'last_name'=> ['required'],
            'first_name'=> ['required'],
            //Rol ID por default #4 = Client
            //'role_id'=> ['required'],
            'email'=> ['required'],
            'password'=> ['required'],
        ]);

        $client = User::create([
            'details'=>$request['username'],
            'last_name'=>$request['last_name'],
            'first_name'=>$request['first_name'],
            'email'=>$request['email'],
            'password'=>$request['password'],
            'role_id'=> 4,            
        ]);
        
        return $client;
    }

    public function show($id)
    {
        $client=User::find($id);
        $this->authorize('isClient', $client);
        //$this->middleware('can:isClient');
        /* if($client->role_id===4){
            return $client;
        }else{
            return 'no es cliente';
        }  */
        /* $user=Auth::user();*/
        /* if (Gate::allows('isClient', $client)) {
            echo "si es cliente";
          } else {
            echo 'Not Authorized.';
        }  */
        return $client->role_id;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username'=> ['required'],
            'last_name'=> ['required'],
            'first_name'=> ['required'],
            //Rol ID por default #4 = Client
            //'role_id'=> ['required'],
            'email'=> ['required'],
            'password'=> ['required'],
        ]);

        $client= User::find($id);

        $client->update([
            'details'=>$request['username'],
            'last_name'=>$request['last_name'],
            'first_name'=>$request['first_name'],
            'email'=>$request['email'],
            'password'=>$request['password'],
            'role_id'=> 4, 
        ]);

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client=User::find($id);
        $state= $client->state;
        $client->state=!$state;
        $client->save();
        return $client;
    }
}
