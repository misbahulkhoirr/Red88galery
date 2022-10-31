@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
      <form action="{{url('monthly_cost')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="size" class="form-label">Ukuran</label>
          <select class="from-control form-select @error('size_id') is-invalid @enderror col-lg-6" name="size_id">
            <option value="">-- Pilih Ukuran --</option>
            @foreach ($size as $size)
            @if (old('size_id')==$size->id)
            <option value="{{ $size->id }}" selected>{{ $size->name }}</option>
            @else
            <option value="{{ $size->id }}">{{ $size->name }}</option>
            @endif
            @endforeach
          </select>
          @error('size_id')
          <div class="invalid-feedback">
            {{ $message}}
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label for="cost" class="form-label">Biaya</label>
          <input type="text" class="form-control @error('cost') is-invalid @enderror col-lg-6 formatNumber" id="cost" name="cost" autofocus value="{{ str_replace([',','.'],'',old('cost')) }}">
          @error('cost')
          <div class="invalid-feedback">
            {{ $message}}
          </div>
          @enderror
        </div>
        <div class="mt-5">
          <a href="{{url('monthly_cost')}}" class="btn btn-secondary">Batal</a>
          <button type="submit" class="btn primaryBtn text-white">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection