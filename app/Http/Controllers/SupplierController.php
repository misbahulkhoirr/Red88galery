<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Masterdata.Supplier.index', [
            'title' => 'Supplier',
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Masterdata.Supplier.create', [
            'title' => 'Tambah Supplier',
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
            'supplier_name' => 'required|max:255',
            'tlp' => 'required',
            'address' => 'required',
        ]);


        Supplier::create($validatedData);
        Helper::createLogs('Tambah data supplier dengan nama : ' . $validatedData['supplier_name']);
        return redirect('/supplier')->with('success', 'Supplier berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {

        return view('Masterdata.Supplier.edit', [
            'title' => 'Edit Supplier',
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            'supplier_name' => 'required|max:255',
            'tlp' => 'required',
            'address' => 'required',
        ]);

        $datas = [
            'supplier_name' => $request->supplier_name != $supplier->supplier_name  ? $supplier->supplier_name . ' => ' . $request->supplier_name . ', ' : '',
            'tlp' => $request->tlp != $supplier->tlp  ? $supplier->tlp . ' => ' . $request->tlp . ', ' : '',
            'address' => $request->address != $supplier->address  ?  $supplier->address . ' => ' . $request->address . ', ' : ''
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
            Helper::createLogs('Ubah data supplier : ' . $activity);
        }
        Supplier::where('id', $supplier->id)->update($validatedData);

        return redirect('/supplier')->with('success', 'Supplier berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {

        Supplier::destroy($supplier->id);
        Helper::createLogs('Hapus data supplier dengan nama supplier : ' . $supplier->supplier_name);
        return redirect('/supplier')->with('success', 'Supplier berhasil di hapus');
    }
}
