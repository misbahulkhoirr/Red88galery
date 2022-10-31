@extends('layouts.app')
@section('content')
<div class="container mb-5">
    @if (session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if (session()->has('fail'))
    <div class="alert alert-danger" role="alert">
        {{ session('fail') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">
            <form action="{{ url('fish/' . $fish->id . '/sell-fish') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="code" class="form-label">Jenis Ikan</label>
                    <input type="text" class="form-control col-lg-6" id="code" name="code" value="{{$fish->fish_type->name . ' - '. $fish->code}}" disabled>
                </div>
                <div class="form-group">
                    <label for="tankLabel" class="form-label">Tank | Kode</label>
                    <div class="input-group col-lg-6 p-0">
                        <div class="input-group-prepend">
                            <input type="text" class="form-control" id="tankLabel" value="{{$fish->tank->tank_type->name}}" disabled>
                        </div>
                        <input type="text" class="form-control" id="tankLabel" value="{{$fish->tank->no_tank}}" disabled>

                    </div>
                </div>
                <div class="form-group">
                    <label for="cost" class="form-label">Cost | Modal</label>
                    <div class="input-group col-lg-6 p-0">
                        <div class="input-group-prepend">
                        <input type="text" class="form-control" id="cost" name="cost" value="{{$fish->additional_costs ? number_format($fish->additional_costs->sum('nominal')) : ''}}" disabled>
                        </div>
                        <input type="text" class="form-control" id="cost" name="cost" value="{{number_format($fish->capital)}}" disabled>

                    </div>
                </div>

                <div class="form-group">
                    <label for="cost" class="form-label">Harga Jual</label>
                    <input type="text" class="form-control col-lg-6" id="cost" name="cost" value="{{number_format($fish->sell_price)}}" disabled>
                </div>
                <div class="form-group">
                    <label for="sell_price" class="form-label">Ukuran Awal</label>
                    <div class="input-group col-lg-6 p-0">
                        <input type="number" class="form-control" id="size_out" value="{{number_format($fish->first_size)}}" name="size_out" max="100" disabled>
                        <div class="input-group-prepend">
                            <div class="input-group-text">CM</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror col-lg-6" id="date" name="date" value="{{ old('date') }}">
                    @error('date')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="deal_price" class="form-label">Harga Deal</label>
                    <input type="text" class="form-control @error('deal_price') is-invalid @enderror formatNumber col-lg-6" value="{{ str_replace([',','.'],'',old('deal_price')) }}" id="deal_price" name="deal_price" maxlength="13">
                    @error('deal_price')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="size_out" class="form-label">Ukuran Keluar</label>
                    <div class="input-group col-lg-6 p-0">
                        <input type="text" class="form-control @error('size_out') is-invalid @enderror" id="size_out" value="{{old('size_out')}}" name="size_out" max="100">
                        <div class="input-group-prepend">
                            <div class="input-group-text">CM</div>
                        </div>
                    </div>

                    @error('size_out')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="customer_name" class="form-label">Nama Pembeli</label>
                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror col-lg-6" id="customer_name" value="{{old('customer_name')}}" name="customer_name">
                    @error('customer_name')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn primaryBtn text-white mt-2 mb-3 btn-sm-block">Simpan</button>
                    <a href="javascript:history.back()" class="btn btn-secondary mt-2 mb-3" title="Kembali">Kembali </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection