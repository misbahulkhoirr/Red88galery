<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Monthly_cost;
use App\Models\Size;
use Illuminate\Http\Request;

class Monthly_costController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Monthly_cost.index', [
            'title' => 'Data Monthly Cost',
            'costs' => Monthly_cost::all(),
            'size'  => Size::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Monthly_cost.create', [
            'title'     => 'Tambah Cost',
            'size'  => Size::all()
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
        $validateData = $request->validate([
            'size_id'          => 'required|max:255',
            'cost'         => 'required|not_in:0',
        ]);
        if ($request->cost) {
            $validateData['cost'] ? $validateData['cost'] = str_replace([',', '.'], '', $request->cost) : null;
        }

        $size = Size::find($request->size_id);
        Monthly_cost::create($validateData);
        Helper::createLogs('Tambah biaya bulanan dengan ukuran : ' . $size->name . ', Biaya : ' . $validateData['cost']);
        return redirect('/monthly_cost')->with('success', 'Data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monthly_cost  $monthly_cost
     * @return \Illuminate\Http\Response
     */
    public function show(Monthly_cost $monthly_cost)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monthly_cost  $monthly_cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Monthly_cost $monthly_cost)
    {
        return view('Masterdata.Monthly_cost.edit', [
            'title'     => 'Edit Monthly Cost',
            'cost'      => $monthly_cost,
            'size'  => Size::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monthly_cost  $monthly_cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monthly_cost $monthly_cost)
    {

        $validatedData = $request->validate([
            'size_id'          => 'required|max:255',
            'cost'         => 'required|not_in:0',
        ]);
        if ($request->cost) {
            $validatedData['cost'] ? $validatedData['cost'] = str_replace([',', '.'], '', $request->cost) : null;
        }

        $size = Size::find($request->size_id);
        $datas = [
            'ukuran' => $request->size_id != $monthly_cost->size_id  ? $monthly_cost->size->name . ' => ' . $size->name . ', ' : '',
            'biaya' => str_replace([',', '.'], '', $request->cost)  != $monthly_cost->cost  ? number_format($monthly_cost->cost) . ' => ' . $request->cost . ', ' : ''
        ];
        if ($datas['biaya'] != '' && $datas['ukuran'] == '') {
            $datas = [
                'ukuran' => $monthly_cost->size->name . ', ',
                'biaya' => number_format($monthly_cost->cost) . ' => ' . $request->cost . ', '
            ];
        }
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
            Helper::createLogs('Ubah biaya bulanan : ' . $activity);
        }
        Monthly_cost::where('id', $monthly_cost->id)->update($validatedData);
        return redirect('/monthly_cost')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monthly_cost  $monthly_cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monthly_cost $monthly_cost)
    {
        $size = Size::find($monthly_cost->size_id);

        Monthly_cost::destroy($monthly_cost->id);
        Helper::createLogs('Hapus biaya bulanan dengan ukuran : ' . $size->name . ', Biaya : ' . number_format($monthly_cost->cost));
        return redirect('/monthly_cost')->with('success', 'Data berhasil di hapus');
    }
}
