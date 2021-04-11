<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AuxController;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Shared;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(!Auth::user()->tokenCan('tasks:read')){
            return response()->json(AuxController::deniedApi(),401);
        }

        $name = $request->has('name') ? $request->input('name') : '';

        $shared_with = Shared::where('project_id',$request->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$request->project_id)
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
        $tasks = Task::whereNull('completed_at')
            ->where(function($query) use ($shared_with){
                $query->where('user_id',Auth::user()->getAuthIdentifier())
                    ->orwherein('id',$shared_with);
            })
            ->where('name','like','%'.$name.'%')
            ->where('project_id',$project->id)->paginate(50);

        $data=[
            'project'=>$project,
            'tasks'=>$tasks,
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->tokenCan('tasks:create')){
            return response()->json(AuxController::deniedApi(),401);
        }
        $this->validate($request,[
            'name' => 'required|min:4',
        ]);

        $shared_with = Shared::where('project_id',$request->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$request->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->orwherein('id',$shared_with)
            ->first();
        if(empty($project)) {
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'permissions'=>"You don't have permission to access to this project",
                ],
            ], 404);
        }


        $task = new Task();
        $task->user_id = Auth::user()->getAuthIdentifier();
        $task->updated_by = Auth::user()->getAuthIdentifier();
        $task->name = $request->input('name');
        $task->project_id = $project->id;

        if($request->has('limit_date')){
            $task->limit_date = $request->input('limit_date');
        }
        if($request->has('priority')){
            $task->priority = $request->input('priority');
        }
        if($request->has('description')){
            $task->description = $request->input('description');
        }
        $task->save();

        return response()->json($task);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->tokenCan('tasks:read')){
            return response()->json(AuxController::deniedApi(),401);
        }

        $task = Task::find($id);
        if(empty($task)){
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'task'=>"The task doesn't exist",
                ],
            ], 404);
        }


        $shared_with = Shared::where('project_id',$task->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$task->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->orwherein('id',$shared_with)
            ->first();
        if(empty($project)) {
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'permissions'=>"You don't have permission to access to this project",
                ],
            ], 404);
        }

        $task->user;
        $task->lastUserUpdate;
        $task->project->user;

        return response()->json($task);
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
        if(!Auth::user()->tokenCan('tasks:update')){
            return response()->json(AuxController::deniedApi(),401);
        }
        $this->validate($request,[
            'name' => 'sometimes|min:4',
        ]);

        $task = Task::find($id);
        return response()->json([
            'error'=>true,
            'errors'=>[
                'task'=>"The task doesn't exist",
            ],
        ], 404);


        $shared_with = Shared::where('project_id',$task->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$task->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->orwherein('id',$shared_with)
            ->first();
        if(empty($project)) {
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'permissions'=>"You don't have permission to access to this project",
                ],
            ], 404);
        }

        if($request->has('name')){
            $task->name = $request->input('name');
        }
        if($request->has('limit_date')){
            $task->limit_date = $request->input('limit_date');
        }
        if($request->has('priority')){
            $task->priority = $request->input('priority');
        }
        if($request->has('description')){
            $task->description = $request->input('description');
        }
        $task->save();
        $task->user;
        $task->lastUserUpdate;
        $task->project->user;

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->tokenCan('tasks:update')){
            return response()->json(AuxController::deniedApi(),401);
        }

        $task = Task::find($id);
        return response()->json([
            'error'=>true,
            'errors'=>[
                'task'=>"The task doesn't exist",
            ],
        ], 404);

        $shared_with = Shared::where('project_id',$task->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->get(['project_id']);

        $project = Project::where('id',$task->project_id)
            ->where('user_id',Auth::user()->getAuthIdentifier())
            ->orwherein('id',$shared_with)
            ->first();
        if(empty($project)) {
            return response()->json([
                'error'=>true,
                'errors'=>[
                    'permissions'=>"You don't have permission to access to this project",
                ],
            ], 404);
        }
        $task->delete();

        return response()->json($task);

    }
}
