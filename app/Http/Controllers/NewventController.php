<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Action;
use App\Newvent;
use Gate;
use Validator;


class NewventController extends Controller
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
    public function publishEvent($action_id)
    {
        $action = Action::findOrFail($action_id);

        if (Gate::denies('admin_action', $action->admin_id)) {
            abort(403, 'No autorizado');
        }

        return view('newvents/publish_event', compact('action'));
    }

    public function publishNew($action_id)
    {
        $action = Action::findOrFail($action_id);

        if (Gate::denies('admin_action', $action->admin_id)) {
            abort(403, 'No autorizado');
        }

        return view('newvents/publish_new', compact('action'));
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
            'title' => 'required',
            'date'  => 'required',
            'link'  => 'required',
            'type'  => 'required',
            'action_id' => 'required'
            ]);

        $newvent = new Newvent;
        $newvent->title = $request->get('title');
        $newvent->link = $request->get('link');
        $newvent->type = $request->get('type');
        $newvent->date = $request->get('date');
        $newvent->action_id = $request->get('action_id');

        $newvent->save();

        return redirect(route('action', $request->get('action_id')))
            ->with('alert', 'Se ha publicado con éxito');
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
        $newvent = Newvent::findOrFail($id);

        if (Gate::denies('admin_action', $newvent->action->admin_id)) {
            abort(403, 'No autorizado');
        }

        return view('newvents/edit', compact('newvent'));
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
            'link'      => 'required',
            'date'      => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $newvent = newvent::findOrFail($id);

        if (Gate::denies('admin_action', $newvent->action->admin_id)) {
            abort(403, 'No autorizado');
        }

        $newvent->title     = $request->get('title');
        $newvent->link      = $request->get('link');
        $newvent->date      = $request->get('date');

        $newvent->save();

        return redirect()->route('action', $newvent->action->id)
            ->with('alert', 'La edición ha finalizado con con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $newvent   = Newvent::findOrFail($request->get('newvent_id'));

        $type      = $newvent->type;
        
        if($type == 'new'){
            $message = "La noticia ha sido eliminada con éxito";
        } else {
            $message = "El evento ha sido eliminado con éxito";
        }

        $action_id  = $newvent->action_id;
        
        $newvent->delete();

        return redirect(route('action', $action_id))
            ->with('alert', $message);
    }
}
