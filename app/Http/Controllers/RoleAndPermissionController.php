<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::all();
        $permissions = Permission::all();

        return view("admin.permissions", ['roles' => $roles, 'permissions' => $permissions]);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function removePermissionFromRole(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission->name);
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Permission revoked from role.');
    }

    public function editRoleName(Role $role, $newName)
    {
        $role->name = $newName;
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Role name updated.');
    }

    public function editPermissionName(Permission $permission, $newName)
    {
        $permission->name = $newName;
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Permission name updated.');
    }

    public function addPermissionToRole(Permission $permission, Role $role)
    {
        $role->givePermissionTo($permission->name);
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Permission added to role.');
    }

    public function removePermission(Permission $permission)
    {
        $permission->delete();
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Permission removed.');
    }


    
}
