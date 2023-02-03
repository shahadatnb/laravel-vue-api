<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\Task as TaskResource;

class TasksController extends Controller
{

    public function store(TaskRequest $request)
    {
        //return $request->all();
        $this->authorize('create', [Task::class, $request->project_id]);
        $task = Task::create($request->all());
        return new TaskResource( $task);
    }

    public function update(TaskRequest $request, Task $task)
    {
        //
        $this->authorize('update', $task);
        $task->update($request->all());
        return new TaskResource( $task);
    }

    public function destroy(Task $task)
    {
        //
        $this->authorize('delete', $task);
        $task->delete();
        return ['status' => 'OK'];
    }
}
