<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;
use App\User;
use App\Proposal;
use App\Poll;
use App\Option;
use Gate;
use Carbon\Carbon;

class PollController extends Controller
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
    public function getCreate($action_id){
        $action = Action::findOrFail($action_id);

        if ( $action->poll ) {
            return redirect()->back()
                ->with('warning', 'Ya existe una votación entre propuestas, debes eliminarla para crear una nueva.');
        }

        $proposals = Proposal::where('action_id', $action_id)->get()->all();

        if ( count($proposals) < 2 ) {
            return redirect()->back()
                ->with('warning', 'Debe haber al menos 2 propuestas para que puedas crear una votación');
        }

        return view('polls.create_poll', compact('action', 'proposals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreate(Request $request){

        $this->validate($request,[
            'question'         => 'required'
            ]);

        // Validate: min 2 options selected
        $counts = array_count_values($request->all());
        if (!array_key_exists('on', $counts) or $counts['on'] < 2){
            return redirect()->back()
                ->withInput()
                ->withErrors(['Selecciona al menos 2 opciones']);
        }

        //Create poll
        $poll = new Poll;
        $poll->question  = $request->get('question');
        $poll->action_id = $request->get('action_id');
        $poll->ending_date = date('Y-m-d', strtotime($request->get('date')));
        $poll->save();

        //Store options
        $proposal_ids = array_keys($request->all(), 'on');
        foreach($proposal_ids as $proposal_id){
            $option = new Option;
            $option->proposal_id = $proposal_id;
            $option->poll_id = $poll->id;
            $option->save();
        }

        return redirect(route('action', $request->get('action_id')))
            ->with('alert', 'La votación ha sido creada con éxito');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poll   = Poll::findOrFail($id);

        $action_id  = $poll->action_id;
        $poll->delete();

        return redirect(route('action', $action_id))
            ->with('alert', "La votación ha sido eliminada con éxito.");
    }

    public function end($id)
    {
        $poll   = Poll::findOrFail($id);

        $action_id  = $poll->action_id;
        $poll->ongoing = false;
        $poll->ending_date = Carbon::today();

        $poll->save();

        return redirect(route('action', $action_id))
            ->with('alert', "Se ha cambiado el estado de la votación a «finalizada».");
    }

    public function vote(Request $request)
    {
        if (!array_key_exists('selected_option', $request->all())){
            return redirect()->back()
                ->with('warning', 'Selecciona una opción');
        }

        $option_id  =   $request->get('selected_option');
        $poll_id    =   Option::findOrFail($option_id)->poll_id;
        $user       =   auth()->user();
        
        if (Gate::denies('vote', $poll_id)){
            return redirect()->back()
                ->with('warning', 'Ya has participado en esta votación');
        }

        $user->votes()->attach($option_id);

        $poll = Poll::findOrFail($poll_id);
        $options = $poll->options;
        $results = [];
        foreach($options as $option){
            array_push($results, ['name' => $option->proposal->title, 'perc' => round(100*count($option->voters)/$poll->num_votes(), 2)]);
        }

        return response()->json($results);
    }
}