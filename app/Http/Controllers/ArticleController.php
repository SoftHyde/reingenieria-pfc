<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use Gate;
use Validator;
use App\Notifications\SupportArticleNotification;
use Illuminate\Support\Facades\Notification;


use Illuminate\Http\Request;


class ArticleController extends Controller
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
        $article = new Article;

        $article->description        = $request->get('description');
        $article->project_id    = $request->get('project_id');

        auth()->user()->article()->save($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$numero)
    {

        $article   = Article::findOrFail($id);
        $project     = $article->project;
        $creator    = $article->user;
        $comments   = $article->commentArticle;
        $supporters = $article->supporters->pluck('user_id')->toArray();

    

        return view('articles/article', compact('article', 'creator', 'project','comments','supporters','numero'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$numero)
    {
        $article = Article::findOrFail($id);

        if (Gate::denies('edit_article', $article)) {
            abort(403, 'No autorizado');
        }

        return view('articles/edit', compact('article','numero'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$numero)
    {
        $validation = Validator::make($request->all(), [
            'description'      => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $article = Article::findOrFail($id);

        if (Gate::denies('edit_article', $article)) {
            abort(403, 'No autorizado');
        }

        $article->description = $request->get('description');

        $article->save();

        return redirect()->route('article', [$article->id,$numero])
            ->with('alert', 'La propuesta ha sido editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $article   = Article::findOrFail($request->get('article_id'));

        $project_id  = $article->project_id;
        $article->delete();

        return redirect(route('project', $project_id))
            ->with('alert', "El articulo  ha sido eliminada con éxito.");
    }


    public function postComment(Request $request) {
        
        $this->validate($request,[
            'comment'   => 'required'
            ]);

        app('App\Http\Controllers\CommentArticleController')->store($request);

        return redirect(route('article',[$request->get('article_id'),$request->get('numero')]))
            ->with('alert', 'El comentario ha sido publicado con éxito');
    }


    public function support(Request $request) {

        $user = auth()->user();
        $article   = Article::findOrFail($request->get('article_id'));
        $supporters = $article->supporters()->pluck('user_id')->toArray();


        if ( in_array($user->id, $supporters) ) {
            return redirect()->back()
                ->with('warning', 'Ya estás apoyando esta propuesta');
        }

        $user->supportArticle()->attach($article->id);
        $owner = User::where('id', $article->user_id )->first();   
        if(auth()->user()->name != $owner->name){ 
        Notification::send($owner,new SupportArticleNotification(auth()->user()->name,$request->get('numero'),$article));
        }
        return redirect()->back();
    }

    public function unsupport(Request $request) {

        $user = auth()->user();
        $article   = Article::findOrFail($request->get('article_id'));
        $supporters = $article->supporters()->pluck('user_id')->toArray();

        if ( ! in_array($user->id, $supporters) ) {
            return redirect()->back()
                ->with('warning', 'No estás apoyando esta propuesta');
        }

        $user->supportArticle()->detach($article->id);

        return redirect()->back();
    }


}
