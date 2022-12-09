<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;
use Validator;
use App\CommentProject;
use App\Notifications\CommentProjectNotification;
use Illuminate\Support\Facades\Notification;
use App\Project;
use App\Moderator;
use App\User;


class CommentProjectController extends Controller
{
    public function store(Request $request)
    {
        $comment = new CommentProject;

        $comment->comment       = $request->get('comment');
        $comment->project_id   = $request->get('project_id');
        
        $comment->user_name     = auth()->user()->name;
       
        auth()->user()->CommentProject()->save($comment);

        $project=Project::findOrFail($request->get('project_id'));
        $moderators=Moderator::where('project_id', $request->get('project_id'))->get();
        foreach ($moderators as $moderator){
         $user = User::where('id', $moderator->user_id )->first();   
         Notification::send($user,new CommentProjectNotification(auth()->user()->name,$project));
        }
    }

    public function edit($id)
    {
        $comment = CommentProject::findOrFail($id);

        if (Gate::denies('edit_comment', $comment)) {
            abort(403, 'No autorizado');
        }

        return view('commentsProject/edit', compact('comment'));
    }

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

        $comment = CommentProject::findOrFail($id);

        if (Gate::denies('edit_comment', $comment)) {
            abort(403, 'No autorizado');
        }

        $comment->comment = $request->get('comment');

        $comment->save();

        return redirect()->route('project',[$comment->project->id])
            ->with('alert', 'El comentario ha sido editado con éxito');
    }

    public function like(Request $request) {
        $user = auth()->user();
        $comment   = CommentProject::findOrFail($request->get('comment_id'));
        $likers = $comment->likers()->pluck('user_id')->toArray();

        
        if ( in_array($user->id, $likers) ) {
            return redirect()->back()
                ->with('warning', 'Ya diste me gusta a este comentario');
        }

        $user->likeCommentProject()->attach($comment->id);

        $data = [
            'comment_id'    => $comment->id,
            'n_likes'       => count($comment->likers)
        ];

        return response()->json($data);
    }

    public function unlike(Request $request) {

        $user = auth()->user();
        $comment   = CommentProject::findOrFail($request->get('comment_id'));
        $likers = $comment->likers()->pluck('user_id')->toArray();

        if ( ! in_array($user->id, $likers) ) {
            return redirect()->back()
                ->with('warning', 'No has dado me gusta a este comentario');
        }

        $user->likeCommentProject()->detach($comment->id);

        $data = [
            'comment_id'    => $comment->id,
            'n_likes'       => count($comment->likers)
        ];

        return response()->json($data);
    }

    public function destroy(Request $request){

        $comment   = CommentProject::findOrFail($request->get('comment_id'));
        $project_id  = $comment->project_id;
        $comment->delete();

        return redirect()->back()
            ->with('alert', "El comentario ha sido eliminado con éxito.");
    }
    
    public function report($id)
    {
        $comment = CommentProject::findOrFail($id);

        $comment->reported = $comment->reported + 1;

        $comment->save();

        return redirect()->back()
            ->with('alert', "El comentario ha sido denunciado");
    }
}
