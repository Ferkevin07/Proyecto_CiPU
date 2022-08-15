<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:manager-manage-resources');
    }

    public function index()
    {
        $comments= Comment::all();
        return response()->json($comments);
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
            'ranking' => ['required'],
            'user_id' => ['required'],
        ]);

        return Comment::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$client=Auth::user();
        $comment= Comment::find($id);
        /* if(Gate::allows('client-manage-comments', $comment)){
            return 'permitido';
        }else{
            return response()->json('message: This action is unauthorized');
        } */
        $this->authorize('isClient', $comment);

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
        $request->validate([
            'details'=> ['required'],
            'state' => ['required'],        
            'ranking' => ['required'],
            'user_id' => ['required'],
        ]);

        $comment= Comment::find($id);

        $comment->update([
            "details" => $request['details'],
            "state" => $request['state'],
            "ranking" => $request['ranking'],
            "user_id" => $request['user_id'],
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
        $state= $comment->state;
        $comment->state=!$state;
        $comment->save();
        return $comment;
    }

    /* public function indexClient(){
        $user=Auth::user();
        $user_id=$user->id;
        $comments=Comment::where('user_id',$user_id)->get();
        return response()->json($comments);
    }

    public function showClient($id){
        $user=Auth::user();
        $user_id=$user->id;
        $comment=Comment::find($id);
        if($user_id===$comment->user_id){
            return response()->json($comment);
        }else{
            return response()->json('This action is NO');
        }   
    } */
}
