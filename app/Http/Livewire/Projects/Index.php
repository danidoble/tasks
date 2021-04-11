<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\Shared;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $search;
    public $project_name;
    public $description;
    public $id_project;
    public function render()
    {
        $shared_with = Shared::where('user_id',Auth::user()->getAuthIdentifier())->get(['project_id']);
        $projects = Project::whereNull('completed_at')
            ->where(function($query) use ($shared_with){
            $query->where('user_id',Auth::user()->getAuthIdentifier())
                ->orwherein('id',$shared_with);
        })
            ->where('name','like','%'.$this->search.'%')
            ->paginate(50);

        return view('livewire.projects.index',[
            'projects'=>$projects
        ]);
    }

    public function updateProject($id,$param,$value){
        if($id !== null){
            //dd($id,$param,$value);
            $project = Project::find($id);
            if(!empty($project)){
                $project->{$param} = $value;
                $project->save();
            }
        }
        //$this->render();
    }
    public function reload(){
        $this->render();
    }
}
