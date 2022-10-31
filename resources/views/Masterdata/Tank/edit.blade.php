@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body d-flex justify-content-center">
                    <div class="col-lg-6 mb-3">
                        <form action="{{url('tank/'.$tank->id)}}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="no_tank" class="form-label">No Tank</label>
                                <input type="text" class="form-control @error('no_tank') is-invalid @enderror" id="no_tank" name="no_tank" autofocus value="{{ old ('no_tank', $tank->no_tank)}}">
                                @error('no_tank')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tank_type" class="form-label">Ukuran</label>
                                <select class="form-select" name="tank_type_id">
                                <option value="">-- Pilih Ukuran --</option>
                                  @foreach ($tank_type as $tank_type) 
                                  @if (old('tank_type_id',$tank->tank_type->id)==$tank_type->id)
                                  <option value="{{ $tank_type->id }}" selected>{{ $tank_type->name }}</option>
                                  @else
                                  <option value="{{ $tank_type->id }}">{{ $tank_type->name }}</option>
                                  @endif
                                  @endforeach
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="location" class="form-label">Lokasi</label>
                                <select class="form-select" name="location_id">
                                <option value="">-- Pilih Lokasi --</option>
                                  @foreach ($location as $location) 
                                  @if (old('location_id',$tank->location->id)==$location->id)
                                  <option value="{{ $location->id }}" selected>{{ $location->name }}</option>
                                  @else
                                  <option value="{{ $location->id }}">{{ $location->name }}</option>
                                  @endif
                                  @endforeach
                                </select>
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