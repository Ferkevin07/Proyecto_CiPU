<?php

namespace App\Http\Controllers\Api\assistent;

use App\Http\Controllers\Controller;
use App\Mail\DebtMailable;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DebtController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:assistant-manage-resources');
    }

    public function index()
    {
        $user=Auth::user();
        $user_id=$user->id;
        $debts=Debt::where('user_id',$user_id)
                            ->Where('state', false)->get();

        return $debts;
    }

    public function store(Request $request)
    {
        $user=Auth::user();
        $id=$user->id;
        //$request->user_id=$user->id;
        //$request->input('user_id',$id);

        $request->validate([
            'to_pay'=> ['required'],
            'to_collect' => ['required'],        
            'price' => ['required'],
            'details' => ['required'],
            //'state'=> 0,
            //'user_id' => $id,
        ]);

        $debt=Debt::create([
            'to_pay'=> $request->to_pay,
            'to_collect' => $request->to_collect,        
            'price' => $request->price,
            'details' => $request->details,
            'state'=> 0,
            'user_id' => $id,
        ]);

        Mail::to('ferkevin@gmail.com')->send(new DebtMailable($user));

        return $debt;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $debt=Debt::find($id);
        $this->authorize('isAuthor',$debt);
        return $debt;
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
        $debt=Debt::find($id);
        $this->authorize('isAuthor',$debt);
        $request->validate([
            'to_pay'=> ['required'],
            'to_collect' => ['required'],        
            'price' => ['required'],
            'details' => ['required'], 
            'user_id' => ['required']
        ]);

        $debt->update([
            "to_pay"=> $request['to_pay'],
            "to_collect" => $request['to_collect'],        
            "price" => $request['price'],
            "details" => $request['details'], 
            "user_id" => $request['user_id']
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
        //Politica de verificacion de autoria del comentario
        $this->authorize('isAuthor', $debt);

        $state= $debt->state;
        $debt->state=!$state;
        $debt->save();

        return $debt;
    }
}
