@extends('layouts.app')
@section('content')
<div class="container">
  @if (session()->has('success'))
  <div class="alert alert-success col-lg-12" role="alert">
    {{ session('success') }}
  </div>
  @endif
  <div class="card mb-3">
    <div class="card-header">{{ $title }}</div>

    <div class="card-body">
      <div class="row">

        <h1 class="mb-3">{{ $fish->fish_type->name }}</h1>
        <div class="col-12 col-md-6 mb-3">
          <img src="{{ $fish->photo ? asset('storage/'.$fish->photo) : 'https://via.placeholder.com/300x200.png?text=No+Image'}}" class="img-fluid mt-3 fish-detail">
        </div>
        <div class="col-12 col-md-6 mb-3">
          <iframe width="100%" height="" src="{{ 'https://www.youtube.com/embed/'.$fish->video }}" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="d-flex justify-content-between">
          <h2 class="mt-3">{{$fish->tank->no_tank}}</h2>
          <h2 class="mt-3">-</h2>
          <h2 class="mt-3 textPrimary">{{$fish->code}}</h2>
        </div>
        <h5>{{$fish->tank->location->name}}</h5>
        <div class="mb-5">
          @if ($fish->class)
            <div class="col mb-2" style="text-align: left">
                @for ($i=0; $i<5; $i++)
                    @if ($i < $fish->class)
                        <span class="fa fa-star checked"></span>
                    @else
                        <span class="fa fa-star"></span>
                    @endif
                @endfor
            </div>
        @endif
      </div>
        <div class="row">
          <div class="col-lg-6">
            <p>Tanggal Masuk : {{date('d M Y', strtotime($fish->date_in))}}</p>
            <p>Ukuran awal : {!! $fish->first_size !!} cm</p>
            @if(Auth::user()->role_id !== 3)
            <p>Modal : Rp. {!! number_format($fish->capital) !!}</p>
            @if($fish->sell_price)
            <p>Harga Jual : Rp. {!! number_format ($fish->sell_price) !!}</p>
            @else
            <p>Harga Jual :</p>
            @endif
            {{-- @if($fish->deal_price)
            <p>Kesepakatan Harga : Rp. {!! number_format($fish->deal_price) !!}</p>
            @else
            <p>Kesepakatan Harga :</p>
            @endif --}}
            @if($cost)
            <p>Biaya Tambahan : Rp. {!! number_format($cost) !!} </p>
            @else
            <p>Biaya Tambahan : </p>
            @endif

          </div>
          <div class="col-lg-6">
            {{-- <p>Tanggal Keluar : {!! $fish->date_out !!}</p> --}}
            <p>Supplier : {!! $fish->supplier->supplier_name !!}</p>
            {{-- <p>Pembeli : {!! $fish->sell_to !!}</p> --}}
            {{-- <p>Ukuran Keluar : {!! $fish->size_out !!}</p> --}}
            <p>Status : {!! $fish->status->name !!}</p>
            {{-- @if ($fish->isAvailable == true)
            <p>isAvailable? : Tersedia</p>
            @else
            <p>isAvailable? : Terjual</p>
            @endif --}}
            <p>Catatan : {!! $fish->notes !!}</p>
          </div>

        </div>
        <div class="mt-3">
          <a href="{{url('tank-details/'.$fish->tank_id)}}" class="btn btn-success mr-4"><span data-feather="arrow-left"></span> Kembali </a>

          <form action="{{url('fish/'.$fish->id) }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus ?')"><span data-feather="x-circle"></span> Hapus</button>
          </form>
        </div>
        @endif
      </div>
    </div>
  </div>
  <div class="card mb-5 mt-3">
    <div class="card-header">{{ $title2 }}</div>
    <div class="card-body">
      <div class="table-responsive">
        @if($fish->status->id !== 4 && $fish->status->id !== 2)
        <a href="{{url('fish_histori/create_histori/'.$fish->id)}}" class="btn primaryBtn text-white mb-3">Tambah Histori</a>
        @endif
        <table class="table table-striped ">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              {{-- <th scope="col">Size</th> --}}
              <th scope="col">Status</th>
              <th scope="col">Catatan</th>
              {{-- <th scope="col">Action</th> --}}
            </tr>
          </thead>
          <tbody>

            @foreach ($histori as $row)
            {{-- @dd($row) --}}
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{date('d M Y', strtotime($row->date))}}</td>
              {{-- <td>{{ $row->size->name }}</td> --}}
              <td>{{ $row->status->name }}</td>
              <td>{{ $row->note }}</td>
              {{-- <td>
                            <a href="/fish_type/{{ $row->id }}/edit" class="btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
              <form action="/fish_type/{{ $row->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn-sm btn-danger border-0" onclick="return confirm('Yakin ingin menghapus ?')"><i class="fa-solid fa-trash-can"></i></button>
              </form>
              </td> --}}
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
