<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::latest()->paginate(10);
    }
    /**
     * Store a newly created re
source in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users',
                'password' => 'required|string|min:6'
            ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request,
            [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
                'password' => 'sometimes|string|min:6'
            ]);

        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return array
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return ['message' => 'user Deleted'];
    }

    public function search()
    {
        if ($search = \Request::get('q'))
        {
            $users= User::where(function ($query) use($search)
            {
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(10);
            return $users;
        }

        return $users=User::latest()->paginate(10);
    }
}
