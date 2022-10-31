<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Tank_types;
use Illuminate\Http\Request;

class Tank_typesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Tank_types.index', [
            'title' => 'Tipe Tank',
            'tank_types' => Tank_types::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Tank_types.create', [
            'title' => 'Tambah Tank',
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


        Tank_types::create($validatedData);
        Helper::createLogs('Tambah data tipe tank dengan nama : ' . $validatedData['name']);
        return redirect('/tank_types')->with('success', 'Tank berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tank_types  $tank_type
     * @return \Illuminate\Http\Response
     */
    public function show(Tank_types $tank_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tank_types  $tank_type
     * @return \Illuminate\Http\Response
     */
    public function edit(Tank_types $tank_type)
    {

        return view('Masterdata.Tank_types.edit', [
            'title' => 'Edit Tank',
            'tank_types' => $tank_type
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tank_types  $tank_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tank_types $tank_type)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $datas = [
            'name' => $request->name != $tank_type->name  ? $tank_type->name . ' => ' . $request->name . ', ' : ''
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

        if ($activity != "") {
            Helper::createLogs('Ubah data tipe tank : ' . $activity);
        }
        Tank_types::where('id', $tank_type->id)->update($validatedData);
        return redirect('/tank_types')->with('success', 'Tank berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tank_types  $tank_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tank_types $tank_type)
    {

        Tank_types::destroy($tank_type->id);
        Helper::createLogs('Hapus data tipe tank dengan nama : ' . $tank_type->name);
        return redirect('/tank_types')->with('success', 'Tank berhasil di hapus');
    }
}
