@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
          <form action=" {{url('users/'. $user->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
              <label for="name" class="form-label">Nama</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror col-lg-6" id="name" name="name" autofocus value="{{ old ('name',$user->name)}}">
              @error('name')
              <div class="invalid-feedback">
                {{ $message}}
              </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control @error('username') is-invalid @enderror col-lg-6" id="username" name="username" value="{{ old ('username',$user->username)}}">
              @error('username')
              <div class="invalid-feedback">
                {{ $message}}
              </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror col-lg-6" id="password" name="password">
              @error('password')
              <div class="invalid-feedback">
                {{ $message}}
              </div>
              @enderror
            </div>

            @if(auth()->user()->role_id == 2)
            <div class="form-group">
              <label for="role" class="form-label">Role</label>
              <input type="text" class="form-control col-lg-6" value="Keeper" readonly>
            </div>
          @endif


            @if(auth()->user()->role_id == 1)
            <div class="form-group">
              <label for="size" class="form-label">Role</label>
              <select class="form-control form-select @error('role_id') is-invalid @enderror col-lg-6" name="role_id">
                <option value="">--Pilih--</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id',$user->role_id) == $role->id ? 'selected' : ''}}>{{ $role->name }}</option>
                @endforeach
              </select>
              @error('role_id')
              <div class="invalid-feedback">
                {{ $message}}
              </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="size" class="form-label">Lokasi</label>
              <select class="form-control form-select @error('location_id') is-invalid @enderror col-lg-6" name="location_id">
                <option value="">--Pilih--</option>
                @foreach ($locations as $location)
                <option value="{{ $location->id }}" {{ old('location_id',$user->location_id) == $location->id ? 'selected' : ''}}>{{ $location->name }}</option>
                @endforeach
              </select>
              @error('location_id')
              <div class="invalid-feedback">
                {{ $message}}
              </div>
              @enderror
            </div>
            @endif
            <div class="form-group">
              <label for="size" class="form-label">Status</label>
              <select class="form-control form-select @error('status_id') is-invalid @enderror col-lg-6" name="status_id">
                <option value="">--Pilih--</option>
                @foreach ($statuses as $status)
                <option value="{{ $status->id }}" {{ old('status_id',$user->status_id) == $status->id ? 'selected' : ''}}>{{ $status->name }}</option>
                @endforeach
              </select>
              @error('status_id')
              <div class="invalid-feedback">
                {{ $message}}
              </div>
              @enderror
            </div>
            <div class="mt-5">
              <a href="{{url('users')}}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn primaryBtn text-white">Simpan</button>
            </div>
          </form>
    </div>
  </div>
</div>

@endsection