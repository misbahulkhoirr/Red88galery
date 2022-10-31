<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Fish_type;
use Illuminate\Http\Request;

class Fish_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Fish_type.index', [
            'title' => 'Tipe Ikan',
            'fish_types' => Fish_type::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Fish_type.create', [
            'title' => 'Tambah Tipe Ikan',
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


        Fish_type::create($validatedData);
        Helper::createLogs('Tambah jenis ikan dengan nama : ' . $validatedData['name']);
        return redirect('/fish_type')->with('success', 'Tipe Fish berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fish_type  $fish_type
     * @return \Illuminate\Http\Response
     */
    public function show(Fish_type $fish_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fish_type  $fish_type
     * @return \Illuminate\Http\Response
     */
    public function edit(Fish_type $fish_type)
    {

        return view('Masterdata.Fish_type.edit', [
            'title' => 'Edit Tipe Ikan',
            'fish_type' => $fish_type
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fish_type  $fish_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fish_type $fish_type)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $datas = [
            'name' => $request->name != $fish_type->name  ? $fish_type->name . ' => ' . $request->name . ', ' : ''
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
            Helper::createLogs('Ubah jenis ikan ; ' . $activity);
        }

        Fish_type::where('id', $fish_type->id)->update($validatedData);

        return redirect('/fish_type')->with('success', 'Tipe Fish berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fish_type  $fish_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fish_type $fish_type)
    {

        Fish_type::destroy($fish_type->id);
        Helper::createLogs('Hapus jenis ikan dengan nama : ' . $fish_type->name);
        return redirect('/fish_type')->with('success', 'Tipe Fish berhasil di hapus');
    }
}
