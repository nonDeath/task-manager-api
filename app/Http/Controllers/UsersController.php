<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    //

    public function index()
    {
        return response()->json($this->users->all());
    }

    public function show($id)
    {
        return response()->json(
            $this->users->findOrFail($id)
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

        return response()->json($user);
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

        return response()->json($user);
    }

    public function destroy($id)
    {
        $this->users
            ->findOrFail($id)
            ->delete();
    }
}
