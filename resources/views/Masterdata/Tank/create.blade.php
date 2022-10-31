@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body d-flex justify-content-center">
                    <div class="col-lg-6 mb-3">
                        <form action="{{url('tank')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="no_tank" class="form-label">No Tank</label>
                                <input type="text" class="form-control @error('no_tank') is-invalid @enderror" id="no_tank" name="no_tank" autofocus value="{{ old ('no_tank')}}">
                                @error('no_tank')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tank_type" class="form-label">Jenis Tank</label>
                                <select class="form-control  form-select" name="tank_type_id">
                                <option value="">Select Jenis Tank</option>
                                  @foreach ($tank_type as $tank_type)
                                    <option value="{{ $tank_type->id }}" {{old('tank_type_id')==$tank_type->id ? 'selected' : ''}} >{{ $tank_type->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            <div class="mb-3">
                                @if ($user->role_id == 1)
                                <label for="location" class="form-label">Lokasi</label>
                                <select class="form-control form-select" name="location_id">
                                <option value="">Select Lokasi</option>
                                    @foreach ($location as $location)
                                        <option value="{{ $location->id }}" {{old('location_id')==$location->id ? 'selected' : ''}} >{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @else
                                <label for="location" class="form-label">Lokasi</label>
                                <select class="form-control form-select" name="location_id">
                                <option selected value="{{ auth()->user()->location_id }}">{{ auth()->user()->location->name }}</option>
                                </select>
                                @endif
                              </div>
                              <div class="mt-2 mb-3">
                                <a href="{{url('tank')}}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn primaryBtn text-white">Simpan</button>
                              </div>
                          </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
