<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Tag;
use Gate;
use Validator;
use App\ProjectTag;
use App\Moderator;
use Illuminate\Support\Facades\DB;

use App\Notifications\NewModeratorNotification;
use Illuminate\Support\Facades\Notification;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index',[
            'projects'=>Project::latest()->paginate()
        ]);
    }


   public function create(){
        return view('projects.create');
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
            'name'         => 'required',
            'description'   => 'required',
            'moderator_email[0][moderator_email].*'   => 'required',
            'tag.*'=>'required'
            ]);

        if ( Project::where('name', $request->get('name') )->first() ) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'name' => 'Ya existe un Proyecto con ese nombre'
                    ]);
        }
       
        foreach ($request->get('tag') as $tag){
            
            if ( ! Tag::where('name', $tag['tag'] )->first() ) {
                $newTag= new Tag;
                $newTag -> name = $tag['tag'];
                $newTag->save();
            }
        }

        
        

        $project = new Project;
        $project->name          = $request->get('name');
        $project->description    = $request->get('description');
        $project->user_id       = auth()->user()->id;
        $project->limit_date = $request->get('limit_date');
        $project->save();

        
        foreach ($request->get('moderator_email') as $moderator){
            if ( ! User::where('email', $request->get('moderator_email') )->first() ) {
                $project->delete();
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'admin_email' => 'No existe ningún usuario con ese email'
                        ]);
            }
            $user = User::where('email', $moderator['moderator_email'] )->first();

            $newModerator= new Moderator;
            $newModerator -> user_id = $user->id;
            $newModerator->project_id = $project->id;
            $newModerator->save();
        }
        $moderators=Moderator::where('project_id',$project->id)->get();
        
        foreach ($moderators as $moderator){
         $userM = User::where('id', $moderator->user_id )->first(); 
         Notification::send($userM,new NewModeratorNotification($project));
        }
        foreach ($request->get('tag') as $tag){
            $ptag = Tag::where('name', $tag['tag'] )->first();
            $projectTag= new ProjectTag;
            $projectTag->project_id = $project->id;
            $projectTag->tag_id = $ptag->id;
            $projectTag->save();
        }
        // Avatar 
        
        return redirect(route('projects', $project->id))
            ->with('alert', 'El Proyecto ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          


        $project = Project::findOrFail($id);
        $comments   = $project->commentProject;
        $articles = $project->article()->paginate();
        return view('projects/project', compact('project','articles','comments'));
    }


    public function showTag($tag)
    {   
        // Consulta sql eloquent
        // $projects = DB::table('project_tags')
        // ->select('projects.*')
        // ->join('projects','project_tags.project_id','=','projects.id')
        // ->where('project_tags.tag_id','=',$tag)
        // ->get();
        
        // $results = DB::select('select projects.* from project_tags 
        // inner join projects on project_tags.project_id=projects.id
        // where project_tags.tag_id='$tag);
        // $tagName=Tag::findOrFail($tag);
        // $tagName=$tagName->name;
        $projects=Project::whereRelation('projectTag', 'tag_id', '=', $tag)->paginate();
        return view('projects.index',compact('projects'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        if (Gate::denies('edit_project', $project)) {
            abort(403, 'No autorizado');
        }

        return view('projects/edit', compact('project'));
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
        DB::beginTransaction();
        $validation = Validator::make($request->all(), [
            'description'      => 'required'
        ]);

        if ($validation->fails()) {
            $this->throwValidationException(
                $request, $validation
            );
        }

        $project = Project::findOrFail($id);

        if (Gate::denies('edit_project', $project)) {
            abort(403, 'No autorizado');
            DB::rollBack();
        }

        foreach ($request->get('tag') as $tag){
            
            if ( ! Tag::where('name', $tag['tag'] )->first() ) {
                $newTag= new Tag;
                $newTag -> name = $tag['tag'];
                $newTag->save();
            }
        }

        $project->name          = $request->get('name');
        $project->description    = $request->get('description');
        $project->limit_date = $request->get('limit_date');

        foreach($project->moderator as $moderator){
            $mod = Moderator::where('id', $moderator['id'] )->first();
            $mod->delete();
        }
        foreach($project->projectTag as $ptag){
            $pobj = ProjectTag::where('id', $ptag['id'] )->first();
            $pobj->delete();
        }

        foreach ($request->get('moderator_email') as $moderator){
            if ( ! User::where('email', $moderator['moderator_email'] )->first()) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'admin_email' => 'No existe ningún usuario con ese email'
                        ]);
            }
            $user = User::where('email', $moderator['moderator_email'] )->first();

            $newModerator= new Moderator;
            $newModerator -> user_id = $user->id;
            $newModerator->project_id = $project->id;
            $newModerator->save();
        }
        foreach ($request->get('tag') as $tag){
            $ptag = Tag::where('name', $tag['tag'] )->first();
            $projectTag= new ProjectTag;
            $projectTag->project_id = $project->id;
            $projectTag->tag_id = $ptag->id;
            $projectTag->save();
        }
        DB::commit();
        return redirect()->route('project', [$project->id])
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
        $project   = Project::findOrFail($request->get('project_id'));
        $title=$project->name;
        $project->delete();

        return redirect(route('projects'))
            ->with('alert', "El proyecto de ley '" . $title . "' ha sido eliminada con éxito.");
    }


    public function getCreateArticle($project_id){

        $project = Project::findOrFail($project_id);
        if (Gate::denies('moderator', $project)) {
            abort(403, 'No autorizado');
        }
        return view('articles.create_article', compact('project'));
    }

    public function postCreateArticle(Request $request){


        $this->validate($request,[
            'description'   => 'required'
            ]);

        app('App\Http\Controllers\ArticleController')->store($request);

        return redirect(route('project', $request->get('project_id')))
            ->with('alert', 'La propuesta ha sido creada con éxito');

    }
    public function postComment(Request $request) {
        
        $this->validate($request,[
            'comment'   => 'required'
            ]);

        app('App\Http\Controllers\CommentProjectController')->store($request);

        return redirect(route('project',[$request->get('project_id')]))
            ->with('alert', 'El comentario ha sido publicado con éxito');
    }

}
