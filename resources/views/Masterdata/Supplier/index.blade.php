@extends('layouts.app')
@section('content')
<div class="container">
  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  <div class="card">
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
      <div class="table-responsive">
        <a href="{{url('supplier/create')}}" class="btn primaryBtn text-white mb-3" title="Tambah supplier">+ Tambah</a>
        <table class="table table-striped ">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Telepon</th>
              <th scope="col">Alamat</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($suppliers as $row)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $row->supplier_name }}</td>
              <td>{{ $row->tlp }}</td>
              <td>{{ $row->address }}</td>
              <td>
                <a href="{{url('supplier/'. $row->id.'/edit')}}" class="btn btn-sm btn-warning" title="Edit supplier"><i class="fa-solid fa-pen-to-square"></i></a>
                @if(auth()->user()->role_id == 1)
                <form action="{{url('supplier/'.$row->id)}}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="btn btn-sm btn-danger border-0" onclick="return confirm('Yakin ingin menghapus ?')" title="Delete supplier"><i class="fa-solid fa-trash-can"></i></button>
                </form>
                @endif
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