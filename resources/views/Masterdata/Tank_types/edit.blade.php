@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">
            <form action="{{url('tank_types/'.$tank_types->id)}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Tipe Tank</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror col-lg-6" id="name" name="name" autofocus value="{{ old ('name',$tank_types->name)}}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <a href="{{url('tank_types')}}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn primaryBtn text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection