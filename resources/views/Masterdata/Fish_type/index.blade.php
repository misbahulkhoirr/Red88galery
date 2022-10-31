@extends('layouts.app')
@section('content')
<div class="container">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                  {{ session('success') }}
                </div>
                @endif
               
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="{{url('fish_type/create')}}" class="btn primaryBtn text-white mb-3">+ Tambah</a>
                        <table class="table table-striped ">
                          <thead>
                            <tr>
                              <th scope="col">No</th>
                              <th scope="col">Ukuran</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($fish_types as $row)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $row->name }}</td>
                              <td>
                              
                                <a href="{{url('fish_type/'.$row->id.'/edit')}}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{('fish_type/'.$row->id)}}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-sm btn-danger border-0" onclick="return confirm('Yakin ingin menghapus ?')"><i class="fa-solid fa-trash-can"></i></button>
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