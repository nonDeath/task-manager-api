<?php

namespace App\Http\Controllers;

use App\Task;
use League\Fractal\Manager;

class TasksController extends ApiController
{
    use \App\Traits\FractableTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Manager $manager, Task $tasks)
    {
        parent::__construct($manager);
        $this->tasks = $tasks;
    }

    //

    public function index()
    {
        $tasks = $this->tasks
            ->with([
                'priority',
                'createdBy',
                'assignedTo'
            ])
            ->paginate(10);

        return $this->respondWithCollection(
            $tasks,
            new \App\Transformers\TaskTransformer
        );
    }

    public function show($id)
    {
        $task = $this->tasks
            ->with([
                'priority',
                'createdBy',
                'assignedTo'
            ])
            ->findOrFail($id);

        return $this->respondWithItem($task, new \App\Transformers\TaskTransformer);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'string|required',
                'description' => 'string|required',
                'due_date' => 'required|date',
                'created_by' => 'required|exists:users,id',
                'assigned_to' => 'exists:users,id',
                'priority_id' => 'required|exists:priorities,id'
            ]
        );

        $task = $this->tasks->create($request->all());

        return $this->respondWithItem($task, new \App\Transformers\TaskTransformer);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'title' => 'string|required',
                'description' => 'string|required',
                'due_date' => 'required|date',
                'created_by' => 'required|exists:users',
                'assigned_to' => 'exists:users',
                'priority_id' => 'required|exists:priorities'
            ]
        );

        $task = $this->tasks->findOrFail($id);
        $task->update($request->all());

        return $this->respondWithItem($task, new \App\Transformers\TaskTransformer);
    }

    public function destroy($id)
    {
        $this->tasks
            ->findOrFail($id)
            ->delete();
    }
}
