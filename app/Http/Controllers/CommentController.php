<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use Gate;
use Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment;

        $comment->comment       = $request->get('comment');
        $comment->proposal_id   = $request->get('proposal_id');

        if($request->has('father_id')){
            $comment->father_id     = $request->get('father_id');
        }
        
        $comment->user_name     = auth()->user()->name;

        auth()->user()->comments()->save($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if (Gate::denies('edit_comment', $comment)) {
            abort(403, 'No autorizado');
        }

        return view('comments/edit', compact('comment'));
    }

    public function report($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->reported = $comment->reported + 1;

        $comment->save();

        return redirect()->back()
            ->with('alert', "El comentario ha sido denunciado");
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
        $validation = Validator::make($request->all(), [
            'comment'      => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $comment = Comment::findOrFail($id);

        if (Gate::denies('edit_comment', $comment)) {
            abort(403, 'No autorizado');
        }

        $comment->comment = $request->get('comment');

        $comment->save();

        return redirect()->route('proposal', $comment->proposal->id)
            ->with('alert', 'El comentario ha sido editado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){

        $comment   = Comment::findOrFail($request->get('comment_id'));
        $proposal_id  = $comment->proposal_id;
        $comment->delete();

        return redirect()->back()
            ->with('alert', "El comentario ha sido eliminado con éxito.");
    }

    public function like(Request $request) {

        $user = auth()->user();
        $comment   = Comment::findOrFail($request->get('comment_id'));
        $likers = $comment->likers()->pluck('user_id')->toArray();


        if ( in_array($user->id, $likers) ) {
            return redirect()->back()
                ->with('warning', 'Ya diste me gusta a este comentario');
        }

        $user->likeComment()->attach($comment->id);

        $data = [
            'comment_id'    => $comment->id,
            'n_likes'       => count($comment->likers)
        ];

        return response()->json($data);
    }

    public function unlike(Request $request) {

        $user = auth()->user();
        $comment   = Comment::findOrFail($request->get('comment_id'));
        $likers = $comment->likers()->pluck('user_id')->toArray();

        if ( ! in_array($user->id, $likers) ) {
            return redirect()->back()
                ->with('warning', 'No has dado me gusta a este comentario');
        }

        $user->likeComment()->detach($comment->id);

        $data = [
            'comment_id'    => $comment->id,
            'n_likes'       => count($comment->likers)
        ];

        return response()->json($data);
    }
}
