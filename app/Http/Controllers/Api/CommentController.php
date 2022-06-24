<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::all();
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
        return Comment::find($id);
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
}
