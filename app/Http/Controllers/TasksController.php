<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Task $tasks)
    {
        $this->tasks = $tasks;
    }

    //

    public function index()
    {
        return response()->json(
            $this->tasks
                ->with([
                    'priority',
                    'createdBy',
                    'assignedTo'
                ])
                ->get()
        );
    }

    public function show($id)
    {
        return response()->json(
            $this->tasks
                ->with([
                    'priority',
                    'createdBy',
                    'assignedTo'
                ])
                ->findOrFail($id)
        );
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

        return response()->json($task);
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

        return response()->json($task);
    }

    public function destroy($id)
    {
        $this->tasks
            ->findOrFail($id)
            ->delete();
    }
}
