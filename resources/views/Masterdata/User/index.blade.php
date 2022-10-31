@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                @if (session()->has('success'))
                <div class="alert alert-success col-lg-12" role="alert">
                  {{ session('success') }}
                </div>
                @endif
               
                <div class="card-body d-flex justify-content-center">
                    <div class="table-responsive col-lg-12">
                        <a href="{{url('user/create')}}" class="btn primaryBtn text-white mb-3">Tambah Akun</a>
                        <table class="table table-striped ">
                          <thead>
                            <tr>
                              <th scope="col">No</th>
                              <th scope="col">Nama</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($users as $row)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $row->name }}</td>
                              <td>
                                @if ($row->status == '1')
                                        <span class="badge badge-success">Aktif</span>
                                @elseif( $row->status == "2" )
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                              </td>
                              <td>
                                <a href="{{url('user/'.$row->id.'/edit')}}" class="btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{url('user/'.$row->id) }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn-sm btn-danger border-0" onclick="return confirm('Yakin ingin menghapus ?')"><i class="fa-solid fa-trash-can"></i></button>
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
    </div>
</div>

@endsection