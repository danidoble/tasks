<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AuxController;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(!Auth::user()->tokenCan('projects:read')){
            return response()->json(AuxController::deniedApi(),401);
        }

        $name = $request->has('name') ? $request->input('name') : '';

        $shared_with = Shared::where('user_id',Auth::user()->getAuthIdentifier())->get(['project_id']);
        $projects = Project::whereNull('completed_at')
            ->where(function($query) use ($shared_with){
                $query->where('user_id',Auth::user()->getAuthIdentifier())
                    ->orwherein('id',$shared_with);
            })
            ->where('name','like','%'.$name.'%')
            ->paginate(50);

        foreach ($projects as $project){
            $project->user;
        }

        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->tokenCan('projects:create')){
            return response()->json(AuxController::deniedApi(),401);
        }

        $this->validate($request,[
            'name' => 'required|min:4',
            'description' => 'sometimes|string|min:6',
        ]);

        $project = new Project();
        $project->name = $request->input('name');
        $project->user_id = Auth::user()->getAuthIdentifier();
        $project->updated_by = Auth::user()->getAuthIdentifier();
        if($request->has('description')){
            $project->description = $request->input('description');
        }
        $project->save();

        return response()->json($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->tokenCan('projects:read')){
            return response()->json(AuxController::deniedApi(),401);
        }


        $shared_with = Shared::where('project_id',$id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->orwherein('id',$shared_with)
            ->first();
        if(empty($project)) {
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'project'=>"The project doesn't exist",
                ],
            ], 404);
        }
        $project->user;
        $project->lastUserUpdate;

        return response()->json($project);
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
        if(!Auth::user()->tokenCan('projects:update')){
            return response()->json(AuxController::deniedApi(),401);
        }

        $this->validate($request,[
            'name' => 'sometimes|min:4',
            'description' => 'sometimes|string|min:6',
        ]);

        $shared_with = Shared::where('project_id',$id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->orwherein('id',$shared_with)
            ->first();
        if(empty($project)) {
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'project'=>"The project doesn't exist",
                ],
            ], 404);
        }

        $project->updated_by = Auth::user()->getAuthIdentifier();

        if($request->has('name')) {
            $project->name = $request->input('name');
        }
        if($request->has('description')){
            $project->description = $request->input('description');
        }
        if($request->has('completed_at')){
            $project->completed_at = date('Y-m-d H:i:s');
            $project->completed_by = Auth::user()->getAuthIdentifier();
        }

        $project->save();
        $project->user;
        $project->lastUserUpdate;

        return response()->json($project);
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
        if(!Auth::user()->tokenCan('projects:delete')){
            return response()->json(AuxController::deniedApi(),401);
        }

        $shared_with = Shared::where('project_id',$id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->orwherein('id',$shared_with)
            ->first();
        if(empty($project)) {
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'project'=>"The project doesn't exist",
                ],
            ], 404);
        }

        $project->updated_by = Auth::user()->getAuthIdentifier();
        $project->delete();

        return response()->json($project);
    }
}
