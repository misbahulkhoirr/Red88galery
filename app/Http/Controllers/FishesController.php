<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Support\Arr;
use App\Models\AdditionalCost;
use App\Models\Fish_histories;
use App\Models\Fish_type;
use App\Models\Fishes;
use App\Models\Location;
use App\Models\Size;
use App\Models\Status;
use App\Models\Tank;
use App\Models\Tank_types;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Image;
use File;

class FishesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        $fishes = Fishes::when(auth()->user()->role_id == 1 && $request->location, function ($query) use ($request) {
            $query->whereHas('tank', function ($qry) use ($request) {
                return $qry->where('location_id', $request->location);
            });
        })
            ->when(auth()->user()->role_id !== 1, function ($query) {
                $query->whereHas('tank', function ($qry) {
                    return $qry->where('location_id', auth()->user()->location_id);
                });
            })
            ->when($request->fish_type_id, function ($query) use ($request) {
                $query->whereHas('fish_type', function ($qry) use ($request) {
                    return $qry->where('id', $request->fish_type_id);
                });
            })
            ->when($request->no_tank, function ($query) use ($request) {
                $query->whereHas('tank', function ($qry) use ($request) {
                    return $qry->where('id', $request->no_tank);
                });
            })
            ->when($request->class, function ($query) use ($request) {
                return $query->where('class', $request->class);
            })
            ->when($request->search, function ($query) use ($request) {
                return $query->where('code', 'ilike', '%' . $request->search . '%');
            })
            ->where('isAvailable', true)
            ->latest()
            ->paginate(15);

        $codeTanks = Tank::when(auth()->user()->role_id !== 1, function ($query) {
            return $query->where('location_id', auth()->user()->location_id);
        })
            ->orderBy('location_id', 'ASC')
            ->orderBy('no_tank', 'ASC')
            ->get();

        return view('Masterdata.Fish.index', [
            'title'     => 'DATA IKAN ',
            'fishes'    => $fishes,
            'tanks'     => $codeTanks,
            'location'  => Location::orderBy('name', 'ASC')->get(),
            'fish_types'  => Fish_type::orderBy('name', 'ASC')->get(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if ($request->id) {
            $tank = Tank::where("tank_type_id", $request->id)
                ->when(auth()->user()->role_id !== 1, function ($query) {
                    return $query->where('location_id', auth()->user()->location_id);
                })
                ->get();
            return response()->json($tank);
        }

        // $kodeIkan = Fishes::max('code');
        // $urutan = (int) substr($kodeIkan, 5, 5);

        // $urutan++;
        // $huruf = "AR";
        // $kodeIkan = $huruf . sprintf("%05s", $urutan);


        return view('Masterdata.Fish.create', [
            'title'     => 'Tambah Data',
            'tank'      => Tank::all(),
            'tank_type' => Tank_types::all(),
            'status'    => Status::where('group', 'fishes')->get(),
            'fish_type' => Fish_type::all(),
            'size'      => Size::all(),
            'suppliers'  => Supplier::all(),
            // 'kode'      => $kodeIkan,
            'user'      => Auth::user()
        ]);
    }

    public function getTypeTanksBylocation($id)
    {
        $tankTypes = Tank::select('tank_types.name AS name', 'tank_types.id')
            ->where('tanks.location_id', $id)
            ->leftJoin('tank_types', 'tanks.tank_type_id', 'tank_types.id')
            ->groupBy('tank_types.name', 'tank_types.id')
            ->orderBy('tank_types.name', 'ASC')
            ->get();

        return response()->json($tankTypes);
    }

    public function getTanksByLocation(Request $request, $id)
    {

        $locationId = auth()->user()->role_id == 1 ? $request->locationId : auth()->user()->location_id;

        $tank = Tank::where("tank_type_id", $id)->where('location_id', $locationId)->get();

        return response()->json($tank);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'fish_type_id'          => 'required',
            'size_id'               => 'required',
            'date_in'               => 'required|date',
            'tank_id'               => 'required',
            'class'                 => 'required',
            'supplier_id'           => 'required',
            'tank_type_id'          => 'required',
            'first_size'            => 'required',
            'photo'                 => 'required',
            'video'                 => 'nullable',
            'capital'               => 'required|not_in:0',
            'notes'                 => 'max:255',

        ]);

        if ($request->photo) {
            $path = 'storage/fish-photos/';
            $image = $request->photo;
            $data = explode(',', $request->photo);
            $image = str_replace(' ', '+', $data[1]);
            $imageName = rand(11111, 99999) . '_' . time() . '.jpg';
            $path = $path . $imageName;
            $savedb = 'fish-photos/' . $imageName;
            $input = File::put($path, base64_decode($image));
            $image = Image::make($path);
            $result = $image->save($path);

            $validateData['photo'] = $savedb;
        }



        if ($request->capital || $request->sell_price) {
            $validateData['capital'] ? $validateData['capital'] = str_replace([',', '.'], '', $request->capital) : null;
            // $validateData['sell_price'] ? $validateData['sell_price'] = str_replace('.', '', $request->sell_price) : null;
            $validateData['user_id'] = $request->user()->id;
        }


        if ($request->jumlah_ikan) {

            $dataikan = [];

            for ($i = 0; $i < $request->jumlah_ikan; $i++) {

                $id = IdGenerator::generate(['table' => 'fishes', 'field' => 'code', 'length' => 6, 'prefix' => 'AR']);
                $data = [
                    'code'          => $id,
                    'fish_type_id'  => $validateData['fish_type_id'],
                    'size_id'       => $validateData['size_id'],
                    'date_in'       => $validateData['date_in'],
                    'tank_id'       => $validateData['tank_id'],
                    'class'         => $validateData['class'],
                    'supplier_id'   => $validateData['supplier_id'],
                    'first_size'    => $validateData['first_size'],
                    'photo'         => $request->photo ? $validateData['photo'] : null,
                    'video'         => $request->video ? $validateData['video'] : null,
                    'capital'       => $validateData['capital'] ? $validateData['capital'] : null,
                    'notes'         => $validateData['notes'],
                    'status_id'     => 1,
                    'user_id'       => $request->user()->id,
                    'isAvailable'   => true,
                ];
                // Fishes::create($data); codesama

                // array_push($dataikan, $data);

                // dd($dataikan);
                Fishes::create($data);
            }


            // for ($a = 0; $a < count($dataikan); $a++) {

            // }
        } else {
            // $validateData['status_id'] = 1;
            // Fishes::create($validateData);

            $id = IdGenerator::generate(['table' => 'fishes', 'field' => 'code', 'length' => 6, 'prefix' => 'AR']);

            $data = [
                'code'          => $id,
                'fish_type_id'  => $validateData['fish_type_id'],
                'size_id'       => $validateData['size_id'],
                'date_in'       => $validateData['date_in'],
                'tank_id'       => $validateData['tank_id'],
                'class'         => $validateData['class'],
                'supplier_id'   => $validateData['supplier_id'],
                'first_size'    => $validateData['first_size'],
                'photo'         => $request->photo ? $validateData['photo'] : null,
                'video'         => $request->video ? $validateData['video'] : null,
                'capital'       => $validateData['capital'] ? $validateData['capital'] : null,
                'notes'         => $validateData['notes'],
                'status_id'     => 1,
                'user_id'       => $request->user()->id,
                'isAvailable'   => true,
            ];
            // Fishes::create($data); codesama

            // array_push($dataikan, $data);

            // dd($dataikan);
            Fishes::create($data);
        }

        Helper::createLogs('Tambah data ikan dengan kode ikan : ' . $data['code']);
        return redirect('/fish')->with('success', 'Data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fishes  $fish
     * @return \Illuminate\Http\Response
     */
    public function show(Fishes $fish, Request $request)
    {
        $cost = AdditionalCost::where('fish_id', $fish->id)->sum('nominal');
        $history = Fish_histories::where('fish_id', $request->fish->id)->orderBy('id', 'DESC')->get();
        session(['data' => $fish]);
        return view('Masterdata.Fish.show', [
            'title' => 'Detail Data Ikan',
            'title2' => 'Detail Riwayat Ikan',
            'fish' => $fish,
            'histori' => $history,
            'cost' => $cost
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fishes  $fish
     * @return \Illuminate\Http\Response
     */
    public function edit(Fishes $fish)
    {
        return view('Masterdata.Fish.edit', [
            'title'     => 'Edit Ikan',
            'fish'      => $fish,
            'tank'  => Tank::all(),
            'status'  => Status::where('group', 'fishes')->get(),
            'fish_type'  => Fish_type::all(),
            'size'  => Size::all(),
            'suppliers'  => Supplier::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fishes  $fish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fishes $fish)
    {


        $rules = [
            // 'code'          => 'required|max:255',
            'fish_type_id'  => 'required|nullable',
            'size_id'       => 'required|nullable',
            'date_in'       => 'required|date',
            'tank_id'       => 'required',
            'class'         => 'required',
            'first_size'    => 'required',
            // 'photo'         => 'nullable',
            'video'         => 'nullable',
            'capital'       => 'required|not_in:0',
            'sell_price'    => 'not_in:0|nullable',
            'date_out'      => 'date|nullable',
            'notes'         => 'max:255|nullable',
            'status_id'     => 'required'
        ];

        $validateData = $request->validate($rules);

        if ($request->photo) {
            if ($request->photolama) {
                Storage::delete($request->photolama);
            }

            $path = 'storage/fish-photos/';
            $image = $request->photo;
            $data = explode(',', $request->photo);
            $image = str_replace(' ', '+', $data[1]);
            $imageName = rand(11111, 99999) . '_' . time() . '.jpg';
            $path = $path . $imageName;
            $savedb = 'fish-photos/' . $imageName;
            $input = File::put($path, base64_decode($image));
            $image = Image::make($path);
            $result = $image->save($path);
            $validateData['photo'] = $savedb;
        } else {
            $validateData['photo'] = $fish->photo;
        }



        if ($request->capital || $request->sell_price || $request->deal_price) {
            $validateData['capital'] ? $validateData['capital'] = str_replace([',', '.'], '', $request->capital) : null;
            $validateData['sell_price'] ? $validateData['sell_price'] = str_replace([',', '.'], '', $request->sell_price) : null;
            $validateData['user_id'] = $request->user()->id;
        }

        // dd($request->photolama, $validateData['photo']);
        Fishes::where('id', $fish->id)->update($validateData);
        $size = Size::find($request->size_id);
        $status = Status::find($request->status_id);
        $fish_type = Fish_type::find($request->fish_type_id);
        $status = Status::find($request->status_id);
        $tank = Tank::find($request->tank_id);

        $notes = [
            'size' => $request->size_id != $fish->size_id  ? $fish->size->name . ' => ' . $size->name . ', ' : null,
            'status' => $request->status_id != $fish->status_id  ? $fish->status->name . ' => ' . $status->name . ', ' : null,
            'jenis ikan' => $request->fish_type_id != $fish->fish_type_id  ? $fish->fish_type->name . ' => ' . $fish_type->name . ', ' : null,
            'tgl masuk' => $request->date_in != $fish->date_in  ? $fish->date_in . ' => ' . $request->date_in . ', ' : null,
            'no tank' => $request->tank_id != $fish->tank_id  ? $fish->tank->no_tank . ' => ' . $tank->no_tank . ', ' : null,
            'kelas' => $request->class != $fish->class  ? $fish->class . ' => ' . $request->class . ', ' : null,
            'ukuran awal' => $request->first_size != $fish->first_size  ? $fish->first_size . ' => ' . $request->first_size . ', ' : null,
            // 'modal' => str_replace([',', '.'], '', $request->capital) != $fish->capital  ? number_format($fish->capital) . ' => ' . $request->capital . ', ' : null,
            // 'harga jual' => str_replace([',', '.'], '', $request->sell_price) != $fish->sell_price  ? number_format($fish->sell_price) . ' => ' . $request->sell_price . ', ' : null,
            // 'ganti photo' => $validateData['photo'] != $fish->photo  ? $fish->photo . ' => ' . $validateData['photo'] . ', ' : null,
            // 'video' => $request->video != $fish->video  ? $fish->video . ' => ' . $request->video . ', ' : null,
            'tgl keluar' => $request->date_out != $fish->date_out  ? $fish->date_out . ' => ' . $request->date_out . ', ' : null,
            'notes' => $request->notes != $fish->notes  ? $fish->notes . ' => ' . $request->notes . ', ' : null,
        ];


        $datanote = implode('', array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    return $k . '[]=' . implode('&' . $k . '[]=', $v);
                } else {
                    if ($v != null) {
                        return $k . ' = ' . $v;
                    }
                }
            },
            $notes,
            array_keys($notes)
        ));

        $data = session('data');
        $data = [
            'date' => date('Y-m-d'),
            'fish_id' => $request->fish->id,
            'user_id' => $request->user()->id,
            'size_id' => $request->size_id,
            'status_id' => $request->status_id,
            'note' => $datanote
        ];

        if ($datanote != "") {
            Fish_histories::create($data);
            session(['data' => $data]);
        }
        if ($datanote != "") {
            Helper::createLogs('Ubah data ikan kode ' . $request->code . ' : ' . $datanote);
        }

        return redirect('/fish')->with('success', 'Fish berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fishes  $fish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fishes $fish)
    {

        $data = Fishes::where('photo', $fish->photo)->get();

        $jumlah = count($data);

        if ($jumlah == 1) {
            Storage::delete($fish->photo);
        }

        Fish_histories::where('fish_id', $fish->id)->delete();
        // Fishes::destroy($fish->id);
        Fishes::where('id', $fish->id)->first()->update(['deleted_at' => date('Y-m-d H:i:s')]);
        Helper::createLogs('Hapus data ikan dengan kode ikan : ' . $fish->code);
        return redirect('/fish')->with('success', 'Fish berhasil di hapus');
    }

    public function create_histori()
    {
        $status = Status::where('group', 'fishes')->get();
        return view('Masterdata.Fish_histori.create', [
            'title'     => 'Tambah Data Histori',
            'status'    => $status,
        ]);
    }

    public function tambah_histori(Request $request, $id)
    {

        $validateData = $request->validate([
            'date'      => 'required|date',
            'note'      => 'required|max:255',
            'status_id' => 'required'
        ]);

        $dataHistory = [
            'fish_id' => $id,
            'user_id' => Auth::user()->id,
            'date' => $request->date,
            'note' => $request->note,
            'status_id' => $request->status_id,
            // 'size_id' => $data->size_id
        ];

        // $changeStatus = [
        //     'status_id' => $request->status_id,
        // ];
        // dd($dataHistory);
        Fish_histories::create($dataHistory);
        Fishes::where('id', $id)->update(['status_id' => $request->status_id]);
        Helper::createLogs('Tambah data history ikan.');
        return redirect('/fish/' . $id)->with('success', 'Histori berhasil di di tambah');
    }

    public function show_update_tank(Request $request, $id)
    {
        // dd($id);
        // $tanks = Tank::when(auth()->user()->role_id !== 1, function ($query) {
        //     return $query->where('location_id', auth()->user()->location_id);
        // })->get();

        $tank_types = Tank_types::get();
        $fish = Fishes::where('id', $request->id)->first();

        return view('Masterdata.Fish.update-tank', [
            'title' => 'PINDAH TANK',
            'fish' => $fish,
            // 'tanks' => $tanks,
            'tank_types' => $tank_types,
        ]);
    }


    public function update_tank(Request $request, $id)
    {

        $validates = [
            'tank_type_id' => 'required',
            'tank_id' => 'required',
        ];

        if (auth()->user()->role_id == 1) {
            $validates = Arr::add($validates, 'location', 'required');
        }

        $request->validate($validates);

        $fish = Fishes::where('id', $id)->first();
        $lastHistory = Fish_histories::where('fish_id', $id)->orderBy('id', 'DESC')->limit(1)->first();
        $tank = Tank::where('id', $request->tank_id)->first();

        Fish_histories::create([
            'fish_id' => $id,
            'user_id' => auth()->user()->id,
            'date' => Carbon::now(),
            'note' => 'Pindah Tank dari dari ' . $fish->tank->no_tank . ' ke ' . $tank->no_tank,
            'status_id' => $lastHistory->status_id
        ]);

        $fish->update([
            'tank_id' => $tank->id
        ]);
        Helper::createLogs('Update ikan pindah tank.');
        return redirect()->back()->with('success', 'Tank berhasil di ubah');
    }

    public function sell_fish(Request $request, $id)
    {
        $fish = Fishes::where('id', $id)->first();

        return view('Masterdata.Fish.sell-fish', [
            'title' => 'FORM JUAL IKAN',
            'fish' => $fish
        ]);
    }

    public function update_sell_fish(Request $request, $id)
    {

        $request->validate([
            'date' => 'required|date',
            'deal_price' => 'required',
            'customer_name' => 'required|string',
            'size_out' => 'required'
        ]);

        $fish = Fishes::where('id', $id)->first();

        if ($fish->tank->location_id == auth()->user()->location_id && auth()->user()->role_id !== 1) {
            $attributes = [
                'date_out' => $request->date,
                'deal_price' => str_replace(',', '', $request->deal_price),
                'sell_to'    => $request->customer_name,
                'size_out' => $request->size_out,
                'isAvailable'  => false,
            ];

            Fishes::where('id', $fish->id)->update($attributes);
            Helper::createLogs('Jual ikan.');
            return redirect('fish')->with('success', 'Data behasil disimpan.');
        } else if (auth()->user()->role_id == 1) {
            $attributes = [
                'date_out' => $request->date,
                'deal_price' => str_replace(',', '', $request->deal_price),
                'sell_to'    => $request->customer_name,
                'size_out' => $request->size_out,
                'isAvailable'  => false,
            ];

            Helper::createLogs('Jual ikan.');
            Fishes::where('id', $fish->id)->update($attributes);

            return redirect('fish')->with('success', 'Data behasil disimpan.');
        } else {

            return back()->with('fail', 'Data gagal disimpan.');
        }
    }
}
