@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">
            <form action="{{url('fish_type/'.$fish_type->id)}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Tipe Ikan</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror col-lg-6" id="name" name="name" autofocus value="{{ old ('name',$fish_type->name)}}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <div class="mt-5">
                    <a href="{{url('fish_type')}}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn primaryBtn text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection