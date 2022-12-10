<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use Validator;
use App\CommentArticle;
use App\Notifications\CommentArticleNotification;
use Illuminate\Support\Facades\Notification;
use App\Article;
use App\User;
use App\Notifications\SupportCommentArticleNotification;

class CommentArticleController extends Controller
{
    public function store(Request $request)
    {
        $comment = new CommentArticle;

        $comment->comment       = $request->get('comment');
        $comment->article_id   = $request->get('article_id');
        
        $comment->user_name     = auth()->user()->name;
        auth()->user()->commentArticle()->save($comment);

        $article=Article::findOrFail($request->get('article_id'));
        $user = User::where('id', $article->user_id )->first();   
        if(auth()->user()->name != $user->name){
        Notification::send($user,new CommentArticleNotification(auth()->user()->name,$request->get('numero'),$article));
        }
    }

    public function edit($id,$numero)
    {
        $comment = CommentArticle::findOrFail($id);

        if (Gate::denies('edit_comment', $comment)) {
            abort(403, 'No autorizado');
        }

        return view('commentsArticles/edit', compact('comment','numero'));
    }

    public function update(Request $request, $id,$numero)
    {
        $validation = Validator::make($request->all(), [
            'comment'      => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $comment = CommentArticle::findOrFail($id);

        if (Gate::denies('edit_comment', $comment)) {
            abort(403, 'No autorizado');
        }

        $comment->comment = $request->get('comment');

        $comment->save();

        return redirect()->route('article',[$comment->article->id,$request->get('numero')])
            ->with('alert', 'El comentario ha sido editado con éxito');
    }

    public function like(Request $request) {
        $user = auth()->user();
        $comment   = CommentArticle::findOrFail($request->get('comment_id'));
        $likers = $comment->likers()->pluck('user_id')->toArray();

        
        if ( in_array($user->id, $likers) ) {
            return redirect()->back()
                ->with('warning', 'Ya diste me gusta a este comentario');
        }

        $user->likeCommentArticle()->attach($comment->id);
        $owner = User::findOrFail($comment->user_id);
        if(auth()->user()->name != $owner->name){
            Notification::send($owner,new SupportCommentArticleNotification(auth()->user()->name,$request->get('numero'),$comment->article_id));
        }
        $data = [
            'comment_id'    => $comment->id,
            'n_likes'       => count($comment->likers)
        ];

        return response()->json($data);
    }

    public function unlike(Request $request) {

        $user = auth()->user();
        $comment   = CommentArticle::findOrFail($request->get('comment_id'));
        $likers = $comment->likers()->pluck('user_id')->toArray();

        if ( ! in_array($user->id, $likers) ) {
            return redirect()->back()
                ->with('warning', 'No has dado me gusta a este comentario');
        }

        $user->likeCommentArticle()->detach($comment->id);

        $data = [
            'comment_id'    => $comment->id,
            'n_likes'       => count($comment->likers)
        ];

        return response()->json($data);
    }

    public function destroy(Request $request){

        $comment   = CommentArticle::findOrFail($request->get('comment_id'));
        $article_id  = $comment->article_id;
        $comment->delete();

        return redirect()->back()
            ->with('alert', "El comentario ha sido eliminado con éxito.");
    }
    
    public function report($id)
    {
        $comment = CommentArticle::findOrFail($id);

        $comment->reported = $comment->reported + 1;

        $comment->save();

        return redirect()->back()
            ->with('alert', "El comentario ha sido denunciado");
    }
}
