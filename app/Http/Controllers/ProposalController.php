<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proposal;
use App\User;
use App\Action;
use App\Comment;
use Gate;
use Validator;

use App\Notifications\SupportProposalNotification;
use Illuminate\Support\Facades\Notification;

class ProposalController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proposal = new Proposal;

        $proposal->title        = $request->get('title');
        $proposal->content      = $request->get('content');
        $proposal->action_id    = $request->get('action_id');

        auth()->user()->proposals()->save($proposal);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposal   = Proposal::findOrFail($id);
        $action     = $proposal->action;
        $creator    = $proposal->user;
        $comments   = $proposal->comments()->paginate();
        $supporters = $proposal->supporters->pluck('user_id')->toArray();

        return view('proposals/proposal', compact('proposal', 'creator', 'action', 'comments', 'supporters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);

        if (Gate::denies('edit_proposal', $proposal)) {
            abort(403, 'No autorizado');
        }

        return view('proposals/edit', compact('proposal'));
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
            'title'        => 'required|max:255',
            'content'      => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $proposal = Proposal::findOrFail($id);

        if (Gate::denies('edit_proposal', $proposal)) {
            abort(403, 'No autorizado');
        }

        $proposal->title   = $request->get('title');
        $proposal->content = $request->get('content');

        $proposal->save();

        return redirect()->route('proposal', $proposal->id)
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
        $proposal   = Proposal::findOrFail($request->get('proposal_id'));

        if(count($proposal->options)>0){
            return redirect()->back()->with('warning', 'Esta propuesta está involucrada en una votación. Debes eliminar la votación primero.');
        }

        $title      = $proposal->title;
        $action_id  = $proposal->action_id;
        $proposal->delete();

        return redirect(route('action', $action_id))
            ->with('alert', "La propuesta '" . $title . "' ha sido eliminada con éxito.");
    }

    public function postComment(Request $request) {
        
        $this->validate($request,[
            'comment'   => 'required'
            ]);

        app('App\Http\Controllers\CommentController')->store($request);


        return redirect(route('proposal', $request->get('proposal_id')))
            ->with('alert', 'El comentario ha sido publicado con éxito');
    }

    public function support(Request $request) {

        $user = auth()->user();
        $proposal   = Proposal::findOrFail($request->get('proposal_id'));
        $supporters = $proposal->supporters()->pluck('user_id')->toArray();


        if ( in_array($user->id, $supporters) ) {
            return redirect()->back()
                ->with('warning', 'Ya estás apoyando esta propuesta');
        }

        $user->supportProposal()->attach($proposal->id);

        $owner = User::where('id', $proposal->user_id )->first();
        if(auth()->user()->name != $owner->name){   
        Notification::send($owner,new SupportProposalNotification(auth()->user()->name,$proposal,$owner));
        }

        return redirect(route('proposal', $proposal->id));
    }

    public function unsupport(Request $request) {

        $user = auth()->user();
        $proposal   = Proposal::findOrFail($request->get('proposal_id'));
        $supporters = $proposal->supporters()->pluck('user_id')->toArray();

        if ( ! in_array($user->id, $supporters) ) {
            return redirect()->back()
                ->with('warning', 'No estás apoyando esta propuesta');
        }

        $user->supportProposal()->detach($proposal->id);

        return redirect(route('proposal', $proposal->id));
    }

    public function getClose($id){
        $proposal = Proposal::findOrFail($id);

        if (Gate::denies('edit_proposal', $proposal)) {
            abort(403, 'No autorizado');
        }

        return view('proposals/close', compact('proposal'));
    }

    public function putClose(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'closing_message' => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $proposal = Proposal::findOrFail($id);

        if (Gate::denies('edit_proposal', $proposal)) {
            abort(403, 'No autorizado');
        }

        $proposal->closing_message = $request->get('closing_message');
        $proposal->save();

        return redirect(route('proposal', $id));
    }

    public function reOpen($id){

        $proposal = Proposal::findOrFail($id);

        if (Gate::denies('edit_proposal', $proposal)) {
            abort(403, 'No autorizado');
        }

        $proposal->closing_message = null;
        $proposal->save();

        return redirect(route('proposal', $id));
    }
}
