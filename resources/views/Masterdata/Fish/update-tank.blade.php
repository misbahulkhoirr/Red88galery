@extends('layouts.app')
@section('content')
<div class="container">
    @if (session()->has('success'))
    <div class="alert alert-success col-lg-12" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            {{ $title }}
        </div>

        <div class="card-body">
            <form action="{{url('fish/'.$fish->id.'/edit-tank')}}" method="POST">
                @csrf
                @method('put')
                <h5>Data Ikan:</h5>
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
                <h5>Pindah Ke:</h5>
                @if(auth()->user()->role_id == 1)
                <div class="form-group">
                    <label for="tank_type" class="form-label">Lokasi</label>
                    <select class="form-control form-select @error('location') is-invalid @enderror col-lg-6" name="location" id="location">
                        <option value="">--Pilih Lokasi--</option>
                        @foreach (Helper::getLocations() as $location)
                        <option value="{{ $location->id }}" {{ old('location') == $location->id ? 'selected' : ''}}>{{ $location->name}}</option>
                        @endforeach
                    </select>
                    @error('location')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                @endif
                <div class="form-group">
                    <label for="tankType" class="form-label">Tipe Tank</label>
                    <select class="form-control form-select @error('tank_type_id') is-invalid @enderror col-lg-6" name="tank_type_id" id="tankType">
                        <option value="">--Pilih Tipe Tank--</option>
                    </select>
                    @error('tank_type_id')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tank" class="form-label">Nomor Tank</label>
                    <select class="form-control form-select @error('tank_id') is-invalid @enderror col-lg-6" name="tank_id" id="tank">
                        <option value="">--Pilih Tank--</option>

                    </select>
                    @error('tank_id')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn primaryBtn text-white mb-3 btn-sm-lg">Simpan</button>
                <a href="javascript:history.back()" class="btn btn-secondary mb-3" title="Kembali">Kembali </a>
        </div>
        </form>
    </div>

</div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function($) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var locationId = null;
        var userRole = "{{auth()->user()->role_id}}";
      
        if (userRole != 1) {
            console.log('masuk');
            $.ajax({
                type: "get",
                url: "{{ url('/get-tank-types').'/'.auth()->user()->location_id}}",
                dataType: 'JSON',
                success: function(response) {
                    var optionTankType = '<option value="">--Pilih Tipe--</option>';

                    for (var key in response) {
                        console.log(response[key].name)
                        optionTankType += '<option value="' + response[key].id + '">' + response[key].name + '</option>';
                    }

                    $('#tankType').html(optionTankType);
                }
            });
        }

        $('#location').change(function() {
            var id = $(this).val();
            locationId = id;
            if (id) {
                $.ajax({
                    type: "get",
                    url: "{{ url('/get-tank-types')}}/" + id,
                    dataType: 'JSON',
                    success: function(response) {
                        var optionTankType = '<option value="">--Pilih Tipe--</option>';

                        for (var key in response) {
                            console.log(response[key].name)
                            optionTankType += '<option value="' + response[key].id + '">' + response[key].name + '</option>';
                        }

                        $('#tankType').html(optionTankType);
                        var optionTank = '<option value="">--Pilih Tank--</option>';
                        $('#tank').html(optionTank);
                    }
                });
            } else {
                var optionTankType = '<option value="">--Pilih Tipe--</option>';
                $('#tankType').html(optionTankType);

                var optionTank = '<option value="">--Pilih Tank--</option>';
                $('#tank').html(optionTank);
            }

        });


        $('#tankType').change(function() {
            var id = $(this).val();
            console.log('locationId', locationId)

            if (id) {
                $.ajax({
                    type: "get",
                    url: "{{ url('/get-tanks')}}/" + id,
                    data: {
                        locationId: locationId
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        console.log(response)
                        var optionTank = '<option value="">--Pilih Tank--</option>';

                        for (var key in response) {
                            console.log(response[key].name)
                            optionTank += '<option value="' + response[key].id + '">' + response[key].no_tank + '</option>';
                        }

                        $('#tank').html(optionTank);
                    }
                });
            } else {
                var optionTank = '<option value="">--Pilih Tank--</option>';
                $('#tank').html(optionTank);
            }

        });

    });
</script>

@endsection