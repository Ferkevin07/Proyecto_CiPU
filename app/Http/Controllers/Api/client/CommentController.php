<?php

namespace App\Http\Controllers\Api\client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('can:client-manage-resources');
    }

    public function index()
    {
        $comments=Comment::where('state', true)->get();
        return $comments;
    }

    public function indexOwn()
    {
        $user=Auth::user();
        $user_id=$user->id;
        /* $comments=Comment::all();
        $commentsOwn=[];
        foreach ($comments as $comment) {
            //if()
        } */
        //$article = Comment::with('user')->find($user_id);
        $comments=Comment::where('user_id',$user_id)
                            ->where('state', true)->get();

        return $comments;
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
        $request->input('user_id',$user_id);

        

        $request->validate([
            'details'=> ['required'],
            /* 'state'=> 1,*/
            
            //'user_id' => ['required'], 
        ]);
        //$details=$request;

        $comment = Comment::create([
            'details'=>$request->details,
            'user_id'=> 7,
            'state'=> 1,
            'ranking'=>1]);
        //$comp=$request->user_id;
        //$request->mergeIfMissing(['user_id' => $user_id]);
        //return $request->details;
        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        //Politica de verificacion de autoria del comentario
        $this->authorize('isAuthor',$comment);
        return $comment;
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
        $comment= Comment::find($id);
        //Politica de verificacion de autoria del comentario
        $this->authorize('isAuthor', $comment);

        $request->validate([
            'details'=> ['required'],
            /* 'state' => ['required'],        
            'ranking' => ['required'],
            'user_id' => ['required'], */
        ]);

        $comment->update([
            "details" => $request['details'],
            /* "state" => $request['state'],
            "ranking" => $request['ranking'],
            "user_id" => $request['user_id'], */
        ]);

        return $comment; 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment= Comment::find($id);
        //Politica de verificacion de autoria del comentario
        $this->authorize('isAuthor', $comment);

        $state= $comment->state;
        $comment->state=!$state;
        $comment->save();

        return $comment;
    }
}
