<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-manage-resources');
    }
    
    public function index()
    {
        $assistants=User::where('role_id', 2)
                        ->orWhere('role_id', 3)
                        ->get();
        return $assistants;
    }

    public function store(Request $request)
    {
        $request->validate([            
            'username'=> ['required'],
            'last_name'=> ['required'],
            'first_name'=> ['required'],
            //Rol ID por default #2 = Seller
            //'role_id'=> ['required'],
            'email'=> ['required'],
            'password'=> ['required'],
        ]);

        $assistant = User::create([
            'details'=>$request['username'],
            'last_name'=>$request['last_name'],
            'first_name'=>$request['first_name'],
            'email'=>$request['email'],
            'password'=>$request['password'],
            'role_id'=> 2,            
        ]);
        
        return $assistant;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assistant=User::find($id);
        //$this->authorize('isClient',$client);
        if($assistant->role_id===2 || $assistant->role_id===3){
            return $assistant;
        }else{
            return 'no es vendedor ni pasante';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username'=> ['required'],
            'last_name'=> ['required'],
            'first_name'=> ['required'],
            //Rol ID por default #2 = Vendedor
            //'role_id'=> ['required'],
            'email'=> ['required'],
            'password'=> ['required'],
        ]);

        $assistant= User::find($id);

        $assistant->update([
            'details'=>$request['username'],
            'last_name'=>$request['last_name'],
            'first_name'=>$request['first_name'],
            'email'=>$request['email'],
            'password'=>$request['password'],
            'role_id'=> 2, 
        ]);

        return $assistant;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assistant=User::find($id);
        $state= $assistant->state;
        $assistant->state=!$state;
        $assistant->save();
        return $assistant;
    }
}
