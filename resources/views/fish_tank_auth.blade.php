@extends('layouts.app')
@section('content')
<div class="container" id="show-data" class="d-none">
    <div class="d-flex justify-content-between mt-5 mb-5">
        <h4>Kode Tank : {{ $tank->no_tank}}</h4>
        <h4>Lokasi Tank : {{ $tank->location->name}}</h4>
    </div>
    @if(count($fishes) > 0)
    <div class="row row-cols-1 row-cols-md-3 mb-5">
       
    @foreach ($fishes as $row)
        @if ($row->isAvailable == true)
        <div class="col mb-4">
            <a href="{{ url('fish/' . $row->id) }} " style="text-decoration: none; color:rgb(29, 28, 28)">
            <div class="card h-100">
                <img src="{{ $row->photo ? Storage::disk('public')->url($row->photo) : 'https://via.placeholder.com/300x200.png?text=No+Image' }}" class="card-img-top ikan" alt="...">
                <div class="card-body">
                    <div class="row">
                        <div class="col mb-2" style="text-align: left">
                            <h5 class="card-title">{{ $row->fish_type->name }}</h5>
                        </div>
                        @if ($row->class)
                            <div class="col mb-2" style="text-align: right">
                                @for ($i=0; $i<5; $i++)
                                    @if ($i < $row->class)
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa fa-star"></span>
                                    @endif
                                @endfor
                            </div>
                        @endif
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="pl-0">Kode Ikan : {{ $row->code }}</td>
                            </tr>
                            <tr>
                                <td class="pl-0">Tgl Masuk : {{ date('d M Y', strtotime($row->date_in)) }}</td>
                            </tr>
                            <tr>
                                <td class="pl-0">Jenis Ikan : {{ $row->fish_type->name }}</td>
                            </tr>

                            <tr>
                                <td class="pl-0">Ukuran : {{ $row->size->name }} ( {{ $row->first_size }} ) cm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </a>
        </div>
        @endif
    @endforeach
       
    </div>
    @else
    <div class="alert alert-warning">
        Tidak ada Data
    </div>
    @endif
</div>
@endsection
