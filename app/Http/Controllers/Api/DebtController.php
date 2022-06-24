<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Debt::all();
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
            'to_pay'=> ['nullable'],
            'to_collect'=> ['nullable'],
            'price' => ['required'],
            'details' => ['required'],
            'user_id' => ['nullable'],
            'manager_id' => ['nullable'],
        ]);

        return Debt::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Debt::find($id);
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
            'to_pay'=> ['nullable'],
            'to_collect' => ['nullable'],        
            'price' => ['required'],
            'details' => ['required'],
            'user_id' => ['nullable'],
            'manager_id' => ['nullable'],
        ]);

        $debt= Debt::find($id);

        $debt->update([
            "to_pay" => $request['to_pay'],
            "to_collect" => $request['to_collect'],
            "price" => $request['price'],
            "details" => $request['details'],
            "user_id" => $request['user_id'],
            "manager_id" => $request['manager_id'],
        ]);

        return $debt; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $debt= Debt::find($id);
        $state= $debt->state;
        $debt->state=!$state;
        $debt->save();
        return $debt;
    }
}
