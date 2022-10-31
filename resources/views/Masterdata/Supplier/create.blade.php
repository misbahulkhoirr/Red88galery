@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
        <form action="{{url('supplier')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="supplier_name" class="form-label">Nama</label>
            <input type="text" class="form-control @error('supplier_name') is-invalid @enderror col-lg-6" id="supplier_name" name="supplier_name" value="{{ old ('supplier_name')}}">
            @error('supplier_name')
            <div class="invalid-feedback">
              {{ $message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="tlp" class="form-label">Telepon</label>
            <input type="text" class="form-control @error('tlp') is-invalid @enderror col-lg-6" id="tlp" name="tlp" value="{{ old ('tlp')}}" maxlength="13">
            @error('tlp')
            <div class="invalid-feedback">
              {{ $message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="address" class="form-label">Alamat</label>
            <textarea class="form-control @error('address') is-invalid @enderror col-lg-6" id="address" name="address" rows="5">{{ old ('address')}}</textarea>
            @error('address')
            <div class="invalid-feedback">
              {{ $message}}
            </div>
            @enderror
          </div>
          <div class="mt-2 mb-3">
            <a href="{{url('supplier')}}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn primaryBtn text-white">Simpan</button>
          </div>
        </form>
    </div>
  </div>
</div>

@endsection