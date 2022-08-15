<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-manage-resources');
    }

    public function index()
    {
        return Provider::all();
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
            'name'=> ['required'],
            'first_name'=> ['required'],
            'last_name' => ['required'],
            'direction' => ['required'],
            'description' => ['required'],
        ]);

        return Provider::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Provider::find($id);
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
            'name'=> ['required'],
            'first_name' => ['required'],        
            'last_name' => ['required'],
            'direction' => ['required'],
            'description' => ['required'],
        ]);

        $provider= Provider::find($id);

        $provider->update([
            "name" => $request['name'],
            "first_name" => $request['first_name'],
            "last_name" => $request['last_name'],
            "direction" => $request['direction'],
            "description" => $request['description']
        ]);

        return $provider;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider= Provider::find($id);
        $state= $provider->state;
        $provider->state=!$state;
        $provider->save();
        return $provider;
    }
}
