<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Manager::all();
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
            'first_name'=> ['required'],
            'last_name'=> ['required'],
            'username' => ['required'],
            'email' => ['required'],
            'personal_phone' => ['required'],
            'home_phone' => ['required'],
            'address' => ['required'],
            'birthdate' => ['nullable'],
            'state' => ['required'],
            'role_id' => ['required'],
            'password' => ['required']
        ]);

        return Manager::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Manager::find($id);
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
            'first_name'=> ['required'],
            'last_name' => ['required'],        
            'username' => ['required'],
            'email' => ['required'],
            'personal_phone' => ['required'],
            'home_phone' => ['required'],
            'address' => ['required'],
            'birthdate' => ['nullable'],
            'state' => ['required'],
            'role_id' => ['required'],
            'password' => ['nullable'],
        ]);

        $manager= Manager::find($id);

        $manager->update([
            "firts_name" => $request['first_name'],
            "last_name" => $request['last_name'],
            "username" => $request['username'],
            "email" => $request['email'],
            "personal_phone" => $request['personal_phone'],
            "home_phone" => $request['home_phone'],
            "address" => $request['address'],
            "birthdate" => $request['birthdate'],
            "state" => $request['state'],
            "role_id" => $request['role_id'],
            "password" => $request['password'],
        ]);

        return $manager;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manager= Manager::find($id);
        $state= $manager->state;
        $manager->state=!$state;
        $manager->save();
        return $manager;
    }
}
