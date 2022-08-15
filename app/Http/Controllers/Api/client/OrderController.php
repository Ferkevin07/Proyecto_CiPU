<?php

namespace App\Http\Controllers\Api\client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:client-manage-resources');
    }
    
    public function index()
    {
        $user=Auth::user();
        $user_id=$user->id;
        $orders=Order::where('user_id',$user_id)
                            ->where('state', true)->get();

        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $user_id=$user->id;

        $request->user_id=$user_id;
        //$request->input('user_id',$user_id);
        $request->validate([
            'details'=> ['required'],
            'name'=> ['required'],
            //'state' => ['required'],
            //'user_id'=> ['required']
        ]);
        $order = Order::create([
            'details'=>$request['details'],
            'user_id'=> $user_id,
            'state'=> 1,
            'name'=>$request['name']
        ]);
        return $order;
    }

    public function show($id)
    {
        $order=Order::find($id);
        $this->authorize('isAuthorOrder',$order);
        return $order;
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
        $order= Order::find($id);
        //Politica de verificacion de autoria del comentario
        $this->authorize('isAuthorOrder', $order);

        $request->validate([
            'details'=> ['required'],
            'name'=> ['required'],
            //'state' => ['required'],
            //'user_id'=> ['required']
        ]);

        $order->update([
            'details'=>$request['details'],
            /* 'user_id'=> $user_id,
            'state'=> 1, */
            'name'=>$request['name']
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
        //Politica de verificacion de autoria del comentario
        $this->authorize('isAuthorOrder', $order);

        $state= $order->state;
        $order->state=!$state;
        $order->save();

        return $order;
    }
}
