@extends('layouts.app')
@section('content')
<div class="container">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body">
                    <div class="row">
                <div class="col-lg-8">
                  <form action="{{url('fish_histori/tambah_histori/'. request()->id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" autofocus value="{{ old ('date')}}">
                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_id" class="form-label">Status</label>
                        <select class="form-control form-select @error('status_id') is-invalid @enderror" name="status_id" autofocus>
                        <option value="">-- Pilih Ikan --</option>
                          @foreach ($status as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                          @error('status_id')
                        <div class="invalid-feedback">
                          {{ $message}}
                        </div>
                        @enderror
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea type="text" class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="5">{{ old ('note')}}</textarea>
                        @error('note')
                        <div class="invalid-feedback">
                          {{ $message}}
                        </div>
                        @enderror
                    </div>
                  <button type="submit" class="btn primaryBtn text-white mt-2 mb-3">Simpan</button>
            </form>
        </div>
                </div>

            </div>
        </div>
    </div>

@endsection