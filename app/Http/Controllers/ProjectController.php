<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Tag;
use App\ProjectTag;
use Illuminate\Support\Facades\DB;

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
            'admin_email'   => 'required'
            ]);

        if ( Project::where('name', $request->get('name') )->first() ) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'name' => 'Ya existe un Proyecto con ese nombre'
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
        foreach ($request->get('tag') as $tag){
            
            if ( ! Tag::where('name', $tag['tag'] )->first() ) {
                // return redirect()->back()
                //     ->withInput()
                //     ->withErrors([
                //         'admin_email' => 'No existe ningún Tag con ese nombre'
                //         ]);
                $newTag= new Tag;
                $newTag -> name = $tag['tag'];
                $newTag->save();
            }
        }

        
        

        $project = new Project;
       
        $project->name          = $request->get('name');
        $project->description    = $request->get('description');
        $project->user_id       = User::where('email', $request->get('admin_email'))->first()->id;
        $project->limit_date = $request->get('limit_date');
     
      
        $project->save();
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
        $articles = $project->article()->paginate();
        return view('projects/project', compact('project','articles'));
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
}
