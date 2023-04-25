<?php

namespace App\Http\Controllers\Backend\Nusantara;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:roles.index|roles.create|roles.edit|roles.delete|roles.trash']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('template.backend.nusantara.role.roleindex', [
            'title' => 'Roles'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.backend.nusantara.role.rolecreate', [
            'permissions' => Permission::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:roles'
        ]);

        // Default data
        $data = [
            'name'        => Str::lower($request->input('name')),
            'description' => $request->input('description')
        ];

        $role = Role::create($data);

        //assign permission to role
        $role->syncPermissions($request->input('permissions'));

        if ($role) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.roles.index')->with(['success' => 'Role ' . $role['name'] . ' Berhasil Ditambahkan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.roles.index')->with(['error' => 'Role Gagal Diupdate!']);
        }
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
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('template.backend.nusantara.role.roleedit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:roles,name,' . $role->id
        ]);

        $role = Role::findOrFail($role->id);

        $role->update([
            'name' => Str::lower($request->input('name')),
            'description' => $request->input('description')
        ]);

        //assign permission to role
        $role->syncPermissions($request->input('permissions'));

        if ($role) {
            //redirect dengan pesan sukses
            return redirect()->route('backend.roles.index')->with(['success' => 'Role ' . $role['name'] . ' Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('backend.roles.index')->with(['error' => 'Role Gagal Diupdate!']);
        }
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
}
