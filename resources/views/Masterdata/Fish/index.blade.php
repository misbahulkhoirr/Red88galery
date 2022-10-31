@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        @if (auth()->user()->role_id != 3)
        <div class="col-6 d-flex justify-content-end">
            <a href="{{ url('fish/create') }}" class="btn primaryBtn text-white">+ Tambah Ikan</a>
        </div>
        @endif

    </div>

    <form>
        <div class="row mb-3">
            <div class="col-lg-2 mb-3">
                <input name="search" value="{{request()->search}}" type="search" class="form-control search" placeholder="Cari Kode Ikan...">
            </div>
            @if(auth()->user()->role_id == 1)
            <div class="col-lg-2 mb-3">
                <select class="form-control form-select" name="location">
                    <option value="">--Pilih Lokasi--</option>
                    @foreach ($location as $row)
                    <option value="{{ $row->id }}" {{ $row->id == request()->location ? 'selected' : '' }}>{{ $row->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-lg-2 mb-3">
                <select class="form-control form-select" name="no_tank" value="{{request()->no_tank }}">
                    <option value="">--Pilih No Tank--</option>
                    @foreach ($tanks as $tank)
                    <option value="{{ $tank->id }}" {{ $tank->id == request()->no_tank ? 'selected' : '' }}>
                        {{ $tank->no_tank }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-3">
                <select class="form-control form-select" name="fish_type_id" value="{{request()->fish_type_id }}">
                    <option value="">--Pilih Jenis Ikan--</option>
                    @foreach ($fish_types as $fish_type)
                    <option value="{{ $fish_type->id }}" {{ $fish_type->id == request()->fish_type_id ? 'selected' : '' }}>
                        {{ $fish_type->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-3">
                <select class="form-control form-select" name="class">
                    <option value="">--Pilih Kelas--</option>
                    <option value="1" {{ 1 == request()->class ? 'selected' : '' }}>1</option>
                    <option value="2" {{ 2 == request()->class ? 'selected' : '' }}>2</option>
                    <option value="3" {{ 3 == request()->class ? 'selected' : '' }}>3</option>
                    <option value="4" {{ 4 == request()->class ? 'selected' : '' }}>4</option>
                    <option value="5" {{ 5 == request()->class ? 'selected' : '' }}>5</option>
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn primaryBtn text-white btn-block mb-3">Cari</button>
            </div>
        </div>
    </form>

        <div class="row row-cols-1 row-cols-md-3">
            @foreach ($fishes as $row)
            <div class="col mb-4">
                <a href="{{ url('fish/' . $row->id) }} " style="text-decoration: none; color:rgb(29, 28, 28)">
                    <div class="card h-100">
                        @if ($row->photo)
                        <img src="{{ Storage::disk('public')->url($row->photo) }}" class="card-img-top ikan" alt="...">
                        @else
                        <img src="https://via.placeholder.com/300x200.png?text=No+Image" class="card-img-top ikan" alt="...">
                        @endif
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
                                        <td class="pl-0">No Tank : {{ $row->tank->no_tank }}</td>
                                    </tr>

                                    <tr>
                                        <td class="pl-0">Lokasi : {{ $row->tank->location->name }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="pl-0">Status : {{$row->status->name}}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                            @if (auth()->user()->role_id != 3)
                            <div class="row">
                                <div class="col mb-2">
                                    <a href="{{url('fish/'.$row->id.'/edit')}}" class="btn btn-sm primaryBtn text-white d-block"><i class="fa-solid fa-pen-to-square"></i></a>
                                </div>
                                <div class="col mb-2">
                                    <a href="{{ url('fish/' . $row->id . '/edit-tank') }}" class="btn btn-sm btn-secondary d-block"><i class="fa-solid fa-arrow-right-arrow-left"></i></a>
                                </div>
                                <div class="col">
                                    @if($row->status_id !== 4)
                                    <a href="{{ url('fish/' . $row->id . '/sell-fish') }}" class="btn btn-sm btn-danger d-block"><i class="fa-solid fa-dollar-sign"></i></a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{ $fishes->links() }}
</div>

@endsection
