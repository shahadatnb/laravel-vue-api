<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollection;
use App\Http\Requests\ProjectRequest;

class ProjectsContoller extends Controller
{
    public function index()
    {
        //
        $projects = Project::where('user_id', auth()->user()->id)
            ->paginate();
        return new ProjectCollection($projects);
    }

    public function store(ProjectRequest $request)
    {
        //
        $project = auth()->user()->projects()->create($request->all());
        return new ProjectResource($project);
    }

    public function show(Project $project)
    {
        //
        return new ProjectResource($project);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        //
        $project->update($request->all());
        return new ProjectResource($project);
    }


    public function destroy(Project $project)
    {
        //
        $project->delete();
        return ['status' => 'OK'];
    }
}
