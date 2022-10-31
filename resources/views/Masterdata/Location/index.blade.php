@extends('layouts.app')
@section('content')
<div class="container">
  @if (session()->has('success'))
  <div class="alert alert-success col-lg-12" role="alert">
    {{ session('success') }}
  </div>
  @endif
  <div class="card">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
      <div class="table-responsive">
        <a href="{{url('location/create')}}" class="btn primaryBtn text-white mb-3">+ Tambah</a>
        <table class="table table-striped ">
          <thead>
            <tr>
              <th>No</th>
              <th>Lokasi</th>
              <th>Latitude</th>
              <th>Longitude</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($location as $row)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $row->name }}</td>
              <td>{{ $row->latitude }}</td>
              <td>{{ $row->longitude }}</td>
              <td>
                    <a href="{{url('location/'.$row->id) }}/edit" class="btn-sm btn-warning mb-1"><i class="fa-solid fa-pen-to-square"></i></a>

                    <form action="{{url('location/'.$row->id)}}" method="post" class="d-inline">
                      @method('delete')
                      @csrf
                      <button class="btn-sm btn-danger border-0 mt-1" onclick="return confirm('Yakin ingin menghapus ?')"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection