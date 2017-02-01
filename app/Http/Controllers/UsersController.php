<?php

namespace App\Http\Controllers;

use App\User;
use App\Transformers\UserTransformer;
use League\Fractal\Manager;

class UsersController extends ApiController
{
    public function __construct(Manager $manager, User $users)
    {
        parent::__construct($manager);
        $this->users = $users;
    }

    public function index()
    {
        return $this->respondWithCollection(
            $this->users->paginate(10),
            new UserTransformer
        );
    }

    public function show($id)
    {
        return $this->respondWithItem(
            $this->users->findOrFail($id),
            new UserTransformer
        );
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name' => 'string|required',
                'last_name' => 'string|required',
                'email' => 'string|required|email|unique:users:email',
            ]
        );

        $user = $this->users->create($request->all());

        return $this->respondWithItem(
            $user,
            new UserTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'first_name' => 'string|required',
                'last_name' => 'string|required',
                'email' => 'string|required|email'.
                    Rule::unique('users')->ignore($user->id, 'user_id'),
            ]
        );

        $user = $this->users->findOrFail($id);
        $user->update($request->all());

        return $this->respondWithItem(
            $user,
            new UserTransformer
        );
    }

    public function destroy($id)
    {
        $this->users
            ->findOrFail($id)
            ->delete();
    }
}
