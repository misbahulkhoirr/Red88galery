@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session()->has('success'))
            <div class="alert alert-success col-lg-12" role="alert">
              {{ session('success') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body ">
                    <a href="{{url('users/create')}}" class="btn primaryBtn text-white mb-3">+ Tambah</a>
                    <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Username</th>
                              <th>Role</th>
                              <th>Lokasi</th>
                              <th>Status</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($users as $item)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $item->username }}</td>
                              <td>{{ $item->role->name }}</td>
                              <td>{{ $item->location ? $item->location->name : '-'}}</td>
                              <td>{{ $item->status->name }}</td>
                              <td>
                                <a href="{{url('users/'.$item->id.'/edit')}}" class="btn btn-sm btn-warning mb-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{('users/'.$item->id)}}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {{ $users->links() }}
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection