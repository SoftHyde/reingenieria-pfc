<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;
use App\Work;
use App\Rating;

class WorkController extends Controller
{
    public function show($id){
        $work = Work::findOrFail($id);

        return view('works/show', compact('work'));
    }

    public function getCreate($action_id){

        $action = Action::findOrFail($action_id);
        
        return view('works/create', compact('action'));
    }

    public function postCreate(Request $request){
        
        $this->validate($request,[
            'title'         => 'required',
            'content'   => 'required'
            ]);

        $work = new Work;
        $work->title = $request->get('title');
        $work->content = $request->get('content');
        $work->action_id = $request->get('action_id');

        if($request->has('location')){
            $work->location = $request->get('location');
        }

        $work->save();

        return redirect(route('action', $request->get('action_id')))
            ->with('alert', 'La obra ha sido publicada con éxito');
    }

    public function destroy(Request $request){

        $work   = Work::findOrFail($request->get('work_id'));
        $title      = $work->title;
        $action_id  = $work->action_id;
        $work->delete();

        return redirect(route('action', $action_id))
            ->with('alert', "La obra '" . $title . "' ha sido eliminada con éxito.");
    }

    public function rate(Request $request){
        
        $this->validate($request, [
            'comment'   => 'required'
            ]);
        
        if($request->get('n_stars')<1){
            return redirect()->back()->withErrors('Selecciona entre 1 y 5 estrellas');
        }

        $rating = new Rating;
        $rating->stars      = $request->get('n_stars');
        $rating->comment    = $request->get('comment');
        $rating->work_id    = $request->get('work_id');
        $rating->user_id    = auth()->user()->id;
        $rating->save();

        return redirect(route('works', $request->get('work_id')))
            ->with('alert', 'Tu calificación ha sido publcada con éxito');
    }
}