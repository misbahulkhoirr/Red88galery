<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Size.index', [
            'title' => 'Size',
            'sizes' => Size::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Size.create', [
            'title' => 'Tambah Size',
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


        Size::create($validatedData);
        Helper::createLogs('Tambah data ukuran dengan nama : ' . $validatedData['name']);
        return redirect('/size')->with('success', 'Size berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {

        return view('Masterdata.Size.edit', [
            'title' => 'Edit Size',
            'size' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Size $size)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $datas = [
            'name' => $request->name != $size->name  ? $size->name . ' => ' . $request->name . ', ' : ''
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
            Helper::createLogs('Ubah data ukuran : ' . $activity);
        }
        Size::where('id', $size->id)->update($validatedData);

        return redirect('/size')->with('success', 'Size berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {

        Size::destroy($size->id);
        Helper::createLogs('Hapus data ukuran : ' . $size->name);
        return redirect('/size')->with('success', 'Size berhasil di hapus');
    }
}
