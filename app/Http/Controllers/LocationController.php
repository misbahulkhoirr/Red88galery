<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Location.index', [
            'title' => 'Location',
            'location' => Location::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Location.create', [
            'title' => 'Tambah Lokasi',
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
            'latitude' => 'required',
            'longitude' => 'required'
        ]);


        Location::create($validatedData);
        Helper::createLogs('Tambah data lokasi dengan nama : ' . $validatedData['name']);
        return redirect('/location')->with('success', 'Lokasi berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {

        return view('Masterdata.Location.edit', [
            'title' => 'Edit Lokasi',
            'location' => $location
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $datas = [
            'name' => $request->name != $location->name  ? $location->name . ' => ' . $request->name . ', ' : '',
            'latitude' => $request->latitude != $location->latitude  ? $location->latitude . ' => ' . $request->latitude . ', ' : '',
            'longitude' => $request->longitude != $location->longitude  ? $location->longitude . ' => ' . $request->longitude . ', ' : ''
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
        if ($activity != "  ") {
            Helper::createLogs('Ubah lokasi data lokasi : ' . $activity);
        }
        Location::where('id', $location->id)->update($validatedData);

        return redirect('/location')->with('success', 'Lokasi berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        Location::destroy($location->id);
        Helper::createLogs('Hapus data lokasi dengan nama : ' . $location->name);
        return redirect('/location')->with('success', 'Lokasi berhasil di hapus');
    }
}
