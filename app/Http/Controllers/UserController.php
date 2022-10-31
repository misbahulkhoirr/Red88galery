<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Role;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use App\Models\Status;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::when(auth()->user()->role_id !== 1, function ($query) {
            return $query->where('location_id', auth()->user()->location_id);
        })
            ->orderBy('id', 'DESC')->paginate();

        return view('users.index', [
            'title' => 'Data User',
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::where('group', 'users')->get();
        $roles = Role::get();
        $locations = Location::get();

        return view('users.create', [
            'title' => 'Tambah User',
            'statuses' => $statuses,
            'roles' => $roles,
            'locations' => $locations
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
        $validates = [
            'name' => 'required|max:150',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'status_id' => 'required',
        ];

        if (auth()->user()->role_id == 1) {
            $validates = Arr::add($validates, 'role_id', 'required');
            $validates = Arr::add($validates, 'location_id', 'required');
        }

        $request->validate($validates);

        $attributes = [
            'name' => $request->name,
            'username' => $request->username,
            'password' =>  Hash::make($request->password),
            'status_id' => $request->status_id,
            'role_id' => auth()->user()->role_id == 1 ? $request->role_id : 3,
            'location_id' => auth()->user()->role_id == 1 ? $request->location_id : auth()->user()->location_id
        ];

        Helper::createLogs('Tambah data user dengan nama : ' . $attributes['name'] . ', username : ' . $attributes['username']);
        User::create($attributes);
        return redirect('users')->with('success', 'Data berhasil di tambah');
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
        $statuses = Status::where('group', 'users')->get();
        $roles = Role::get();
        $locations = Location::get();

        return view('users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'statuses' => $statuses,
            'roles' => $roles,
            'locations' => $locations
        ]);
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

        $validates = [
            'name' => 'required|max:150',
            'username' => 'required|unique:users,username,' . $user->id,
            'status_id' => 'required',
        ];

        if ($request->password) {
            $validates = Arr::add($validates, 'password', 'string|min:5');
        }

        if (auth()->user()->role_id == 1) {
            $validates = Arr::add($validates, 'role_id', 'required');
            $validates = Arr::add($validates, 'location_id', 'required');
        }

        $request->validate($validates);

        $attributes = [
            'name' => $request->name,
            'username' => $request->username,
            'status_id' => $request->status_id,
            'location_id' => auth()->user()->role_id == 1 ? $request->location_id : auth()->user()->location_id
        ];

        if (auth()->user()->role_id == 1) {
            $attributes = Arr::add($attributes, 'role_id', $request->role_id);
        }

        if ($request->password) {
            $attributes = Arr::add($attributes, 'password', Hash::make($request->password));
        }

        $role = Role::find($request->role_id);
        $status = Status::find($request->status_id);
        $datas = [
            'name' => $request->name != $user->name  ? $user->name . ' => ' . $request->name . ', ' : '',
            'username' => $request->username != $user->username  ? $user->username . ' => ' . $request->username . ', ' : '',
            'role_id' => $request->role_id != $user->role_id  ? $user->role->name . ' => ' . $role->name . ', ' : '',
            'status' => $request->status_id != $user->status_id  ?  $user->status->name . ' => ' . $status->name . ', ' : ''
        ];

        $activity = implode(' ', array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    return $k . '[]=' . implode('&' . $k . '[]=', $v);
                } else {
                    if ($v != null) {
                        return $k . ' = ' . $v;
                    }
                }
            },
            $datas,
            array_keys($datas)
        ));
        if ($activity != " ") {
            Helper::createLogs('Ubah data user : ' . $activity);
        }
        $user->update($attributes);
        return redirect('users')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::where('id', $user->id)->delete();
        Helper::createLogs('Hapus data user dengan nama : ' . $user->name . ', username : ' . $user->username);
        return back()->with('success', 'Data berhasil di hapus');
    }
}
