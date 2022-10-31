@extends('layouts.app')
@section('content')
<div class="container mb-5">
  <div class="card">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
      <form class="form-inline mb-3">
        <label for="from_date" class="sr-only">From</label>
        <input type="date" class="form-control mb-2 mr-sm-2" id="from_date" name="from_date" value="{{request()->from_date ? request()->from_date : date('Y-m').'-01'}}" placeholder="From Date">
        <label for="to_date" class="sr-only">To</label>
        <input type="date" class="form-control mb-2 mr-sm-2" id="to_date" name="to_date" value="{{request()->to_date ? request()->to_date : date('Y-m-d')}}" placeholder="To Date">
        @if(auth()->user()->role_id == 1)
        <label for="tank_type" class="sr-only">Lokasi</label>
        <select class="form-control form-select  mb-2 mr-sm-2" name="location" id="location">
          <option value="">--Pilih Lokasi--</option>
          @foreach (Helper::getLocations() as $location)
          <option value="{{ $location->id }}" {{ request()->location == $location->id ? 'selected' : ''}}>{{ $location->name}}</option>
          @endforeach
        </select>
        @endif
        <button type="submit" class="btn btn-primary btn-md-block mb-2">Filter</button>
      </form>

      <div class="row row-cols-1 row-cols-md-3">
        <div class="col mb-4">
          <div class="card bg-light">
            <div class="card-body">
              <h5 class="card-title">Total Harga Deal</h5>
              <p class="card-text h4">{{number_format($totalDealPrice)}}</p>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card bg-light">
            <div class="card-body">
              <h5 class="card-title">Total Modal/Cost</h5>
              <p class="card-text h4">{{number_format($totalCapital)}}/{{number_format($totalCost)}}</p>
            </div>
          </div>
        </div>
        <div class="col mb-4">
          <div class="card bg-light">
            <div class="card-body">
              <h5 class="card-title">Total Profit</h5>
              <p class="card-text h4">{{number_format($totalProfit)}}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive ">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Kode</th>
              <th scope="col">Harga Deal</th>
              <th scope="col">Modal/Cost</th>
              <th scope="col">Profit</th>
              <th scope="col">Pembeli</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($fishes as $fish)
            @php
            $totalModalCost = $fish->capital + $fish->additional_costs->sum('nominal');
            $profit = $fish->deal_price - $totalModalCost
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $fish->date_out->format('d M Y') }}</td>
              <td>
                <a href="{{url('sales/'.$fish->id.'/show')}}" title="Detail">{{ $fish->code}}</a>

              </td>
              <td>{{number_format($fish->deal_price)}}</td>
              <td>{{number_format($fish->capital) }}/{{number_format( $fish->additional_costs->sum('nominal'))}}</td>
              <td>{{number_format($profit)}}</td>
              <td>{{ $fish->sell_to }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{$fishes->withQueryString()->links()}}
    </div>
  </div>
</div>

@endsection