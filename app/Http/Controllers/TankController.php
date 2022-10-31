<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Location;
use App\Models\Tank;
use App\Models\Fishes;
use App\Models\Fish_histories;
use App\Models\Tank_types;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Image;

class TankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $tanks = Tank::when(auth()->user()->role_id !== 1, function ($query) {
            return $query->where('location_id', auth()->user()->location_id);
        })
            ->when($request->keyword, function ($query) use ($request) {
                return $query->where('no_tank', 'ilike', '%' . $request->keyword . '%');
            })
            ->when(auth()->user()->role_id == 1 && $request->location_id, function ($query) use ($request) {
                return $query->where('location_id', $request->location_id);
            })
            ->when($request->tank_type_id, function ($query) use ($request) {
                return $query->where('tank_type_id', $request->tank_type_id);
            })
            ->paginate(15);

        return view('Masterdata.Tank.index', [
            'title' => 'Tank',
            'tanks' => $tanks,
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Tank.create', [
            'title' => 'Tambah Tank',
            'tank_type' => Tank_types::all(),
            'location' => Location::all(),
            'user' => Auth::user()
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
            'no_tank' => 'required|max:255',
            'tank_type_id' => 'required',
            'location_id' => 'required',
        ]);

        $tank = Tank::create($validatedData);

        $img = Image::make('blank.png');
        $img->text($request->no_tank, 75, 60, function ($font) {
            $font->file(public_path('Acme-Regular.ttf'));
            $font->size(45);
            $font->color('#FFFFFF');

            $font->align('center');
            $font->valign('middle');
        });
        $img->save(storage_path('app/public/no_tank.png'));

        $qrcode = QrCode::format('png')->merge(Storage::url('app/public/no_tank.png'), .2)->size(250)->generate(env('APP_URL') . '/tank-details/' . $tank->id);
        $filename = 'image/qr-' . $tank->id . '.png';

        Storage::disk('public')->put($filename, $qrcode);

        Tank::where('id', $tank->id)->update(['barcode' => $filename]);
        Helper::createLogs('Tambah data tank dengan nomor tank : ' . $validatedData['no_tank']);
        return redirect('/tank')->with('success', 'Tank berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function show(Tank $tank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function edit(Tank $tank)
    {

        return view('Masterdata.Tank.edit', [
            'title' => 'Edit Tank',
            'tank' => $tank,
            'tank_type' => Tank_types::all(),
            'location' => Location::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tank $tank)
    {
        $validatedData = $request->validate([
            'no_tank' => 'required|max:255',
            'tank_type_id' => 'required',
            'location_id' => 'required',
        ]);

        $tank_type = Tank_types::find($request->tank_type_id);
        $location = Location::find($request->location_id);
        $datas = [
            'no_tank' => $request->no_tank != $tank->no_tank  ? $tank->no_tank . ' => ' . $request->no_tank . ', ' : '',
            'tank_type_id' => $request->tank_type_id != $tank->tank_type_id  ? $tank->tank_type->name . ' => ' . $tank_type->name . ', ' : '',
            'location_id' => $request->location_id != $tank->location_id  ?  $tank->location->name . ' => ' . $location->name . ', ' : ''
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
            Helper::createLogs('Ubah data tank : ' . $activity);
        }
        Tank::where('id', $tank->id)->update($validatedData);

        return redirect('/tank')->with('success', 'Tank berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tank  $tank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tank $tank)
    {
        $tank->delete();
        Helper::createLogs('Hapus data tank dengan nomor tank : ' . $tank->no_tank);
        return redirect('/tank')->with('success', 'Tank berhasil di hapus');
    }

    public function tank_details(Request $request, $id)
    {
        $fishes = Fishes::where('tank_id', $id)->orderBy('id', 'desc')->get();
        $tank = Tank::where('id', $id)->first();

        if (Auth::check()) {
            return view('fish_tank_auth', compact('fishes', 'tank'));
        } else {
            return view('fish_tank', compact('fishes', 'tank'));
        }
    }

    public function tank_details_fish(Request $request, $id)
    {
        $fish = Fishes::find($id);
        $histori = Fish_histories::where('fish_id', $id)->get();

        return view('fish_tank_details', compact('fish', 'histori'));
    }
}
