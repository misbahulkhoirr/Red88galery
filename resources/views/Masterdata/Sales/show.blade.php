@extends('layouts.app')
@section('content')
<div class="container mb-5">
  <div class="card">
    @if ($fish->photo)
    <img src="{{asset('storage/'.$fish->photo)}}" class="img-fluid" style="width: 100%; max-height:400px">
    @else
    <img src="{{asset('placeholder/placeholde-image.jpg')}}" class="img-fluid" style="width: 100%; max-height:400px">
    @endif

    <div class="card-body">
          <h2 class="mt-3">{{$fish->code}}</h2>
          <h5 class="mb-5 ">{{$fish->fish_type->name }}</h5>
          <div class="row">
            <div class="col-lg-6">
              <p>Tanggal Masuk : {!! $fish->date_in !!}</p>
              <p>Ukuran awal : {!! $fish->first_size !!}</p>
              <p>Modal : Rp. {!! number_format($fish->capital) !!}</p>
              @if($fish->sell_price)
              <p>Harga Jual : Rp. {!! number_format ($fish->sell_price) !!}</p>
              @else
              <p>Harga Jual :</p>
              @endif
              @if($fish->deal_price)
              <p>Harga Kesepakatan : Rp. {!! number_format($fish->deal_price) !!}</p>
              @else
              <p>Harga Kesepakatan :</p>
              @endif
            </div>
            <div class="col-lg-6">
              <p>Tanggal Keluar : {{ $fish->date_out->format('d M Y') }}</p>
              <p>Pembeli : {!! $fish->sell_to !!}</p>
              <p>Ukuran keluar : {!! $fish->size_out !!}</p>
              <p>Status : {!! $fish->status->name !!}</p>
              <p>Catatan : {!! $fish->notes !!}</p>
            </div>
          </div>
          <a href="javascript:history.back()" class="btn btn-success mr-4" title="Kembali"><span data-feather="arrow-left"></span> Kembali </a>
    </div>
  </div>
</div>

@endsection