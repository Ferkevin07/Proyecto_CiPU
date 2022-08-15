<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manager-manage-resources');
    }
    
    public function index()
    {
        return Order::all();
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
            'details'=> ['required'],
            'state'=> ['required'],
            'details' => ['required'],
            'user_id' => ['required'],
        ]);

        return Order::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::find($id);
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
            'state' => ['required'],        
            'details' => ['required'],
            'user_id' => ['required'],
        ]);

        $order= Order::find($id);

        $order->update([
            "name" => $request['name'],
            "state" => $request['state'],
            "details" => $request['details'],
            "user_id" => $request['user_id'],
        ]);

        return $order;   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order= Order::find($id);
        $state= $order->state;
        $order->state=!$state;
        $order->save();
        return $order;
    }
}
