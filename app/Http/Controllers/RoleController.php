<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Role.index', [
            'title' => 'Role',
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Role.create', [
            'title' => 'Tambah Role',
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

        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);


        Role::create($validatedData);
        Helper::createLogs('Tambah role keeper');
        return redirect('/roles')->with('success', 'Data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Role $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        return view('Masterdata.Role.edit', [
            'title' => 'Edit Status',
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        Role::where('id', $role->id)->update($validatedData);
        Helper::createLogs('Ubah role keeper');
        return redirect('/roles')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {

        Role::destroy($role->id);
        Helper::createLogs('Hapus role keeper');
        return redirect('/roles')->with('success', 'Data berhasil di hapus');
    }
}
