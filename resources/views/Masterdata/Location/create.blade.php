@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">
            <form action="{{url('location')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Lokasi</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror col-lg-6" id="name" name="name" autofocus value="{{ old ('name')}}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" class="form-control @error('latitude') is-invalid @enderror col-lg-6" id="latitude" name="latitude" autofocus value="{{ old ('latitude')}}">
                    @error('latitude')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" class="form-control @error('longitude') is-invalid @enderror col-lg-6" id="longitude" name="longitude" autofocus value="{{ old ('longitude')}}">
                    @error('longitude')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <div class="mt-2 mb-3">
                    <a href="{{url('location')}}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn primaryBtn text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection