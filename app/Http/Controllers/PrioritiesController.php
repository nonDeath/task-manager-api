<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Transformers\PriorityTransformer;
use League\Fractal\Manager;

class PrioritiesController extends ApiController
{
    public function __construct(Manager $manager, Priority $priorities)
    {
        parent::__construct($manager);
        $this->priorities = $priorities;
    }

    public function index()
    {
        return $this->respondWithCollection(
            $this->priorities->all(),
            new PriorityTransformer
        );
    }

    public function show($id)
    {
        return $this->respondWithItem(
            $this->priorities->findOrFail($id),
            new PriorityTransformer
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

        return $this->respondWithItem($priority, new PriorityTransformer);
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

        return $this->respondWithItem($priority, new PriorityTransformer);
    }

    public function destroy($id)
    {
        $this->priorities
            ->findOrFail($id)
            ->delete();
    }
}
