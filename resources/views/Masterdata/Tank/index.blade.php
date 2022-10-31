@extends('layouts.app')
@section('content')
<div class="container">

    @if (session()->has('success'))
    <div class="alert alert-success col-lg-12" role="alert">
        {{ session('success') }}
    </div>
    @endif
            <div class="row mb-3 mt-3">
                <div class="col-6">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <a href="{{url('tank/create')}}" class="btn primaryBtn text-white">+ Tambah Tank</a>
                </div>
            </div>

            <form method="GET">
                <div class="row mb-3">
                    @if(auth()->user()->role_id == 1)
                    <div class="col-lg-3 mb-3">
                        <select class="form-control form-select" name="location_id" id="">
                            <option value="">--Pilih Lokasi--</option>

                            @foreach(\DB::table('locations')->get() as $location)
                            <option value="{{$location->id}}" {{request()->location_id == $location->id ? 'selected' : ''}}>{{$location->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-lg-3 mb-3">
                        <select class="form-control form-select" name="tank_type_id" id="">
                            <option value="">--Pilih Jenis Tank--</option>

                            @foreach(\DB::table('tank_types')->get() as $tank_type)
                            <option value="{{$tank_type->id}}" {{request()->tank_type_id == $tank_type->id ? 'selected' : ''}}>{{$tank_type->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 mb-3">
                        <input name="keyword" value="{{request()->keyword}}" type="search" class="form-control" placeholder="Cari No. Tank">
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn primaryBtn text-white btn-block mb-2">Cari</button>
                    </div>
                </div>
            </form>

                <div class="row row-cols-1 row-cols-md-3">
                    @foreach ($tanks as $row)
                    <div class="col mb-4">
                        <a href="{{ url('tank-details/' . $row->id) }} " style="text-decoration: none; color:rgb(29, 28, 28)">
                        <div class="card h-100">
                            <img src="{{ Storage::disk('public')->url($row->barcode) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $row->no_tank }}</h5>
                                <p class="card-text mb-3">Tank Tipe : {{ $row->tank_type->name }}
                                    </br>
                                    Lokasi : {{ $row->location ? $row->location->name : '-'}}
                                </p>
                                @if (auth()->user()->role_id != 3)
                                    <a href="{{url('tank/'.$row->id) }}/edit" class="btn btn-sm btn-warning ">Ubah</a>
                                    <a href="{{ Storage::disk('public')->url($row->barcode) }}" class="btn btn-sm primaryBtn text-white" download="Barcode-{{ $row->no_tank }}">Download</a>
                                    @if (auth()->user()->role_id == 1)
                                    <form action="{{url('tank/'.$row->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger float-right" onclick="return confirm('Yakin ingin menghapus ?')"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>                                    
                                    @endif
                                @endif
                            </div>
                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                {{ $tanks->links() }}
</div>

@endsection
