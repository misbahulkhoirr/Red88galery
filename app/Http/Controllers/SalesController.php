<?php

namespace App\Http\Controllers;

use App\Models\Fish_histories;
use App\Models\Fishes;
use App\Models\Tank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $from = $request->form_date ? $request->form_date : date('Y-m').'-01';
        $to =  $request->to_date ? $request->to_date : date('Y-m-d');

        $totalFishes = Fishes::where('isAvailable', '=', false)
        ->when($request->from_date && $request->to_date, function ($query) use ($from,$to)
        {
            return $query->whereBetween('date_out', [$from, $to]);
        })
        ->when(auth()->user()->role_id !== 1, function ($query)
        {
            $query->whereHas('tank', function ($qry) {
                return $qry->where('location_id', auth()->user()->location_id);
            });
        })
        ->when(auth()->user()->role_id == 1 && $request->location, function ($query) use ($request)
        {
            $query->whereHas('tank', function ($qry) use ($request){
                return $qry->where('location_id', $request->location);
            });
        })
        ->get();

        $totalDealPrice = 0;
        $totalCost = 0;
        $totalCapital = 0;

        foreach ($totalFishes as $totalFish) {
            
            $totalDealPrice += $totalFish->deal_price;
            $totalCapital += $totalFish->capital;
            $totalCost += $totalFish->additional_costs->sum('nominal');
        }

        $fishes = Fishes::where('isAvailable', '=', false)
                        ->when($request->from_date && $request->to_date, function ($query) use ($from,$to)
                        {
                            return $query->whereBetween('date_out', [$from, $to]);
                        })
                        ->when(auth()->user()->role_id !== 1, function ($query)
                        {
                            $query->whereHas('tank', function ($qry) {
                                return $qry->where('location_id', auth()->user()->location_id);
                            });
                        })
                        ->when(auth()->user()->role_id == 1 && $request->location, function ($query) use ($request)
                        {
                            $query->whereHas('tank', function ($qry) use ($request){
                                return $qry->where('location_id', $request->location);
                            });
                        })
                        ->paginate();

        $totalCapitalCost = $totalCapital + $totalCost;
        $totalProfit = $totalDealPrice - $totalCapitalCost;

        return view('Masterdata.Sales.index', [
            'title' => 'Data Penjualan',
            'totalDealPrice' => $totalDealPrice,
            'totalCapital' => $totalCapital,
            'totalCost' => $totalCost,
            'totalProfit' => $totalProfit,
            'fishes' => $fishes

        ]);
    }

    public function show(Request $request)
    {
        $fish = Fishes::where('id', $request->id)->first();
        $title = 'Detail Laporan Penjualan';
        // dd($fish);
        return view('Masterdata.Sales.show', compact('fish','title'));
    }
}
