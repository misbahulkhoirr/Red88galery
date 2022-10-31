@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body d-flex justify-content-center">
                    <div class="col-lg-6 mb-3">
                        <form action="{{url('statuses/'.$status->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Status</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old ('name',$status->name)}}">
                                @error('name')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            <div class="mt-2 mb-3">
                                <a href="{{url('statuses')}}" class="btn btn-secondary">Batal</a>
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