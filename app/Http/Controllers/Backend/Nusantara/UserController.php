<?php

namespace App\Http\Controllers\Backend\Nusantara;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:users.index|users.create|users.edit|users.delete|users.trash']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('template.backend.nusantara.user.userindex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.backend.nusantara.user.usercreate', [
            'roles' => Role::orderBy('name', 'asc')->get(),
        ]);
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
        $this->validate($request, [
            'name'                  => 'required|min:2',
            'email'                 => 'required|email|unique:users,email',
            // 'username'              => 'required|unique:users,username',
            // 'celuller_no'           => 'required|unique:users,celuller_no',
            'password'              => 'confirmed|min:8',
            'password_confirmation' => 'required'
        ]);

        // Default data
        $data = [
            'name'        => $request->input('name'),
            'slug'        => Str::slug($request->input('name')),
            'email'       => $request->input('email'),
            'username'    => $request->input('username'),
            'celuller_no' => $request->input('celuller_no'),
            'password'    => bcrypt($request->input('password')),
        ];

        $user = User::create($data);

        //assign role to user
        $user->syncRoles($request->input('roles'));


        return redirect()->route('backend.users.index')->with(['success' => 'User ' . $user['name'] . ' Berhasil Ditambahkan!']);
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
        $roles = Role::orderBy('name', 'asc')->get();
        return view('template.backend.nusantara.user.useredit', compact('user', 'roles'));
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

        $validateData = [];

        $validateData = array_merge($validateData, [
            'name'                  => 'required|min:2',
            'email'                 => 'required|email',
            'username'              => 'required|min:6',
            'celuller_no'           => 'required|min:11|max:12',
        ]);


        // Default data
        $data = [
            'name'        => $request->input('name'),
            'slug'        => Str::slug($request->input('name')),
            'email'       => $request->input('email'),
            'username'    => $request->input('username'),
            'celuller_no' => $request->input('celuller_no'),
            'status'      => $request->input('status'),
        ];

        $user = User::findOrFail($user->id);
        $current_hashed_password = $user->password;

        if (!empty($request->input('password'))) {
            $validateData = array_merge($validateData, [
                'password'              => 'confirmed|min:8',
                'password_confirmation' => 'required'
            ]);

            if ($user->masterstatus == config('cms.default_masteruser')) {
                $validateData = array_merge($validateData, [
                    'current_password_for_password' => ['required', 'customPassCheckHashed:' . $current_hashed_password]
                ]);
            }

            $data = array_merge($data, [
                'password'  => bcrypt($request->input('password')),
            ]);
        }

        $this->validate($request, $validateData);

        $user->update($data);

        //assign role
        $user->syncRoles($request->input('roles'));

        return redirect()->route('backend.users.index')->with(['success' => 'Data User ' . $user['name'] . ' Berhasil Diupdate!']);
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userprofile()
    {
        return view('template.backend.nusantara.user.userprofile', [
            'title' => 'Dashboard'
        ]);
    }
}
