<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Status.index', [
            'title' => 'Status',
            'Status' => Status::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Status.create', [
            'title' => 'Tambah Status',
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


        Status::create($validatedData);
        Helper::createLogs('Tambah data status');
        return redirect('/Status')->with('success', 'Status berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $Status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $Status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $Status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {

        return view('Masterdata.Status.edit', [
            'title' => 'Edit Status',
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $Status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        Status::where('id', $status->id)->update($validatedData);
        Helper::createLogs('Ubah data status');
        return redirect('/Status')->with('success', 'Status berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $Status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {

        Status::destroy($status->id);
        Helper::createLogs('Hapus data status');
        return redirect('/Status')->with('success', 'Status berhasil di hapus');
    }
}
