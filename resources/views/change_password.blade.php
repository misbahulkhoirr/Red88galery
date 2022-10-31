@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('success'))
            <div class="alert alert-success col-lg-12" role="alert">
                {{ session('success') }}
            </div>
            @endif

            @if (session()->has('fail'))
            <div class="alert alert-danger col-lg-12" role="alert">
                {{ session('fail') }}
            </div>
            @endif

            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form action=" {{url('change-password') }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="old_password" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password">
                                    @error('old_password')
                                    <div class="invalid-feedback">
                                        {{ $message}}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                    @error('new_password')
                                    <div class="invalid-feedback">
                                        {{ $message}}
                                    </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn primaryBtn text-white mt-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection