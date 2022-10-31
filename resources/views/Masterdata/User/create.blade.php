@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body d-flex justify-content-center">
                    <div class="col-lg-6 mb-3">
                        <form action="{{url('user')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old ('name')}}">
                                @error('name')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" username="username" autofocus value="{{ old ('username')}}">
                                @error('username')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" email="email" autofocus value="{{ old ('email')}}">
                                @error('email')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                    id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('password') }}">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="exampleInputEmail1" aria-describedby="emailHelp">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tank_type" class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>-- Pilih Status --</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                    {{ $message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn primaryBtn text-white mt-2 mb-3">Save</button>
                          </form>
                        </div>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection