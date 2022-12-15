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
use App\CommentArticleReport;
use App\Notifications\SupportCommentArticleNotification;
use App\Notifications\CommentArticleReportNotification;
use App\Notifications\DeleteCommentArticleNotification;

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
        Notification::send($user,new CommentArticleNotification(auth()->user()->name,$request->get('numero'),$article,$user));
        }
    }

    public function edit($id,$numero)
    {
        $comment = CommentArticle::findOrFail($id);

        if (Gate::denies('edit_comment_article', $comment)) {
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

        if (Gate::denies('edit_comment_article', $comment)) {
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
            Notification::send($owner,new SupportCommentArticleNotification(auth()->user()->name,$request->get('numero'),$comment->article_id,$owner));
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
        $article =Article::findOrFail($comment->article_id);
        $user = auth()->user();
        $i=1;
        foreach($comment->article->project->article as $article){
			if($article->id == $comment->article->id){
                break;
            }
            $i++;
        }
        $comment->delete();
        if($user->name != $comment->user_name){
            $owner=User::findOrFail($comment->user_id);
            Notification::send($owner,new DeleteCommentArticleNotification($article,$i,$owner));
        }
        return redirect()->route('article',[$comment->article->id,$i])
        ->with('alert', 'El comentario ha sido editado con éxito');
    }
    
    public function report($id,$numero)
    {
        $comment = CommentArticle::findOrFail($id);
        $comment->reported = $comment->reported + 1;

        if($comment->reported == 1){
            $article=Article::findOrFail($comment->article_id);
            $admin=User::findOrFail($article->project->user_id);
            Notification::send($admin,new CommentArticleReportNotification($comment->user->name,$comment,$numero,$admin));
        }


        $reported=$comment->report()->pluck('user_id')->toArray();
        $user = auth()->user();

        if ( in_array($user->id, $reported) ) {
            return redirect()->back()
                ->with('warning', 'Ya reportaste a este comentario');
        }
        

        $report= new CommentArticleReport;
        $report->comment_article_id = $comment->id;
        $report->user_id = $user->id;
        $report->save();

        $comment->save();

        return redirect()->back()
            ->with('alert', "El comentario ha sido denunciado");
    }
}
