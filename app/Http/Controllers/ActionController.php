<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;
use App\User;
use App\Proposal;
use App\Poll;
use Gate;
use App\Tag;
use App\ActionTag;
use Image;
use Illuminate\Support\Facades\File;
use Validator;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = Action::paginate();

        return view('actions/index', compact('actions'));
    }

    public function create(){
        return view('actions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'         => 'required',
            'description'   => 'required',
            'howto'         => 'required',
            'admin_email'   => 'required',
            'avatar'    => 'image|max:500'
            ]);

        if ( Action::where('title', $request->get('title') )->first() ) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'title' => 'Ya existe una acción participativa con ese nombre'
                    ]);
        }
        if ( ! User::where('email', $request->get('admin_email') )->first() ) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'admin_email' => 'No existe ningún usuario con ese email'
                    ]);
        }

        $user = User::where('email', $request->get('admin_email') )->first();

        if ($user->role == 'general'){
            $user->role = 'action_admin';
            $user->save();
        }

        $action = new Action;

        $action->title          = $request->get('title');
        $action->description    = $request->get('description');
        $action->howto          = $request->get('howto');
        $action->admin_id       = User::where('email', $request->get('admin_email'))->first()->id;
        $action->allow_works          = $request->get('allow_works');
        $action->allow_newvents       = $request->get('allow_newvents');
        $action->allow_proposals      = $request->get('allow_proposals');

        if ($action->allow_proposals == 1){

            $action->proposal_posters   = $request->get('proposal_posters');
            $action->allow_comments           = $request->get('allow_comments');
            $action->allow_polls              = $request->get('allow_polls');

        } else {

            $action->proposal_posters   = 'admin';
            $action->allow_comments           = 0;
            $action->allow_polls              = 0;
        }

        foreach ($request->get('tag') as $tag){
            
            if ( ! Tag::where('name', $tag['tag'] )->first() ) {
                $newTag= new Tag;
                $newTag -> name = $tag['tag'];
                $newTag->save();
            }
        }

        $action->save();

        foreach ($request->get('tag') as $tag){
            $ptag = Tag::where('name', $tag['tag'] )->first();
            $actionTag= new ActionTag;
            $actionTag->action_id = $action->id;
            $actionTag->tag_id = $ptag->id;
            $actionTag->save();
        }

        // Avatar 
        if($request->hasFile('avatar')){
            $avatar     = $request->file('avatar');
            $filename   = $action->id . '.' . $avatar->getClientOriginalExtension();
            $path       = '/uploads/actions/' . $filename;
            Image::make($avatar)->resize(600,450)->save( public_path($path));

            $action->avatar = $path;
        }

        $action->save();

        return redirect(route('action', $action->id))
            ->with('alert', 'La acción participativa ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $action = Action::findOrFail($id);
        $proposals = $action->proposals()->paginate();
        return view('actions/action', compact('action', 'proposals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $action = Action::findOrFail($id);

        if (Gate::denies('admin_action', $action->admin_id)) {
            abort(403, 'No autorizado');
        }

        return view('actions/edit', compact('action'));
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
        $this->validate($request,[
            'title'         => 'required',
            'description'   => 'required',
            'howto'         => 'required',
            'admin_email'   => 'required',
            'avatar'    => 'image|max:500'
            ]);

        $action = Action::findOrFail($id);

        if (Gate::denies('admin_action', $action->id)) {
            abort(403, 'No autorizado');
        }

        if ( Action::where('title', $request->get('title') )->first() and Action::where('title', $request->get('title') )->first() != $action) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'title' => 'Ya existe una acción participativa con ese nombre'
                    ]);
        }
        if ( ! User::where('email', $request->get('admin_email') )->first() ) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'admin_email' => 'No existe ningún usuario con ese email'
                    ]);
        }

        $user = User::where('email', $request->get('admin_email') )->first();

        if ($user->role == 'general'){
            $user->role = 'action_admin';
            $user->save();
        }

        $action->title          = $request->get('title');
        $action->description    = $request->get('description');
        $action->howto          = $request->get('howto');
        $action->admin_id       = User::where('email', $request->get('admin_email'))->first()->id;
        $action->allow_works          = $request->get('allow_works');
        $action->allow_newvents       = $request->get('allow_newvents');
        $action->allow_proposals      = $request->get('allow_proposals');

        if ($action->allow_proposals == 1){

            $action->proposal_posters   = $request->get('proposal_posters');
            $action->allow_comments           = $request->get('allow_comments');
            $action->allow_polls              = $request->get('allow_polls');

        } else {

            $action->proposal_posters   = 'admin';
            $action->allow_comments           = 0;
            $action->allow_polls              = 0;
        }


        $action->save();

        // Avatar 
        if($request->hasFile('avatar')){
            $avatar     = $request->file('avatar');
            $filename   = $action->id . '.' . $avatar->getClientOriginalExtension();
            $path       = '/uploads/actions/' . $filename;
            Image::make($avatar)->resize(600,450)->save( public_path($path));

            $action->avatar = $path;
        }

        $action->save();

        return redirect()->route('action', $action->id)
            ->with('alert', 'La acción participativa ha sido editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $action   = Action::findOrFail($request->get('action_id'));
        $title    = $action->title;
        $action->delete();

        return redirect(route('actions'))
            ->with('alert', "La acción participativa '" . $title . "' ha sido eliminada con éxito.");
    }

    public function getEditAction($id){

        $action = Action::findOrFail($id);

        if (Gate::denies('edit-action', $action)){
            return redirect()->route('home');
        }

        return $action->title;
    }

    public function getCreateProposal($action_id){

        $action = Action::findOrFail($action_id);

        return view('proposals.create_proposal', compact('action'));
    }

    public function postCreateProposal(Request $request){


        $this->validate($request,[
            'title'         => 'required',
            'content'   => 'required'
            ]);

        app('App\Http\Controllers\ProposalController')->store($request);

        return redirect(route('action', $request->get('action_id')))
            ->with('alert', 'La propuesta ha sido creada con éxito');

    }

    public function showTag($tag)
    {   
        $actions=Action::whereRelation('actionTag', 'tag_id', '=', $tag)->paginate();
        return view('actions.index',compact('actions'));
    }
}
