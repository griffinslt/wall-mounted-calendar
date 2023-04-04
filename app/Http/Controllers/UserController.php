<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(30);

        return view('admin.users.users', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $roles_to_show = array();
        foreach ($roles as $role) {
            if (!$user->roles->contains($role)) {
                array_push($roles_to_show, $role);
            }
        }
        $roles_to_show = collect(array_unique($roles_to_show));
        return view('admin.users.edit', ['user' => $user, 'roles' => $roles_to_show]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required'
        ]);

        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->save();

        

        return redirect()->route('users.index')->with('message','User ('.$user->name.') updated');
    }

    public function removeRoleFromUser(User $user, Role $role)
    {
        $user->removeRole($role->name);
        return redirect()->route('users.edit', ['user' => $user->id])->with('message', 'Role was removed');
    }

    public function addRoleToUser(User $user, Role $role)
    {
        $user->assignRole($role->name);
        return redirect()->route('users.edit', ['user' => $user->id])->with('message', 'Role was added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {


        $user->delete();
        return redirect()
                ->route('users.index')
                ->with('message', 'User was Deleted.');
        
    }
}
