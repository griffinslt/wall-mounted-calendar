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

        return view("admin.permissions.permissions", ['roles' => $roles, 'permissions' => $permissions]);
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
    public function editRole(Role $role)
    {
        return view('admin.permissions.edit-role', ['role' => $role]);
    }

    public function editPermission(Permission $permission)
    {
        return view('admin.permissions.edit-permission', ['permission' => $permission,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $role->name = $validatedData['name'];
        $role->save();

        return redirect()->route("permissions.edit-role", ['role'=>$role])->with('message', "Role Updated");
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $permission->name = $validatedData['name'];
        $permission->save();

        return redirect()->route("permissions.edit-permission", ['permission'=>$permission])->with('message', "Permission Updated");
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

    public function editRolePermissions(Permission $permission)
    {
        $roles = Role::all();
        return view('admin.permissions.add-permission-to-role', ['permission'=>$permission, 'roles'=>$roles]);
    }
    public function addPermissionToRole(Permission $permission, Role $role)
    {
        // dd($role, $permission);
        $role->givePermissionTo($permission->name);
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Permission ('.$permission->name. ') added to role.');
    }

    public function removePermission(Permission $permission)
    {
        $permission->delete();
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Permission removed.');
    }

    public function removeRole(Role $role)
    {
        $role->delete();
        return redirect()
                ->route('permissions.index')
                ->with('message', 'Role removed.');
    }


    
}
