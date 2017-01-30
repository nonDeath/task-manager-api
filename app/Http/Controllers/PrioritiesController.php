<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Priority;

class PrioritiesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Priority $priorities)
    {
        $this->priorities = $priorities;
    }

    //

    public function index()
    {
        return response()->json($this->priorities->all());
    }

    public function show($id)
    {
        return response()->json(
            $this->priorities->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'string|required'
            ]
        );

        $priority = $this->priorities->create($request->all());

        return response()->json($priority);
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'string|required'
            ]
        );

        $priority = $this->priorities->findOrFail($id);
        $priority->update($request->all());

        return response()->json($priority);
    }

    public function destroy($id)
    {
        $this->priorities
            ->findOrFail($id)
            ->delete();
    }
}
