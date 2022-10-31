@extends('layouts.guest')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between mt-5 mb-5">
        <h4>Kode Tank : {{ $tank->no_tank}}</h4>
        <h4>Jenis Tank : {{ $tank->tank_type->name}}</h4>
    </div>
    @if(count($fishes) > 0)
    <div class="row row-cols-1 row-cols-md-3 mb-5" id="show-data" class="d-none">
        @foreach ($fishes as $row)
            @if ($row->isAvailable == true)
            <div class="col mb-4">
                <div class="card h-100">
                    <img src="{{ $row->photo ? Storage::disk('public')->url($row->photo) : 'https://via.placeholder.com/300x200.png?text=No+Image' }}" class="card-img-top ikan" alt="...">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mb-2" style="text-align: left">
                                <h5 class="card-title">{{ $row->fish_type->name }}</h5>
                            </div>
                            @if ($row->class)
                                <div class="col mb-2" style="text-align: right">
                                    @for ($i=0; $i<5; $i++)
                                        @if ($i < $row->class)
                                            <span class="fa fa-star checked"></span>
                                        @else
                                            <span class="fa fa-star"></span>
                                        @endif
                                    @endfor
                                </div>
                            @endif
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="pl-0">Kode Ikan : {{ $row->code }}</td>
                                </tr>
                                <tr>
                                    <td class="pl-0">Tgl Masuk : {{ date('d M Y', strtotime($row->date_in)) }}</td>
                                </tr>
                                <tr>
                                    <td class="pl-0">Jenis Ikan : {{ $row->fish_type->name }}</td>
                                </tr>

                                <tr>
                                    <td class="pl-0">Ukuran : {{ $row->size->name }} ( {{ $row->first_size }} ) cm</td>
                                </tr>
                                {{-- <tr>
                                    <td class="pl-0">Status : {{$row->status->name}}</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
    @else
    <div class="alert alert-warning">
        Tidak ada Data
    </div>
    @endif

    
    <div id="location" class="alert alert-warning"></div>
</div>


<script>
    $('.fishslide').slick();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(success,error);
        }else{
            $('#location').html('Geolocation is not supported by this browser.');
        }
    });

    function success(position) {
      console.log('masuk2')
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;

      console.log(latitude,longitude);

      var jarak = distance(latitude, longitude, '{{ $tank->location->latitude }}', '{{ $tank->location->longitude }}', 'K')
      if(jarak <= 1){
        $('#show-data').removeClass('d-none');
      }else{
        $('#show-data').addClass('d-none');        
        $('#location').html('Akses dari Lokasi Anda tidak di setujui');
      }
      console.log(jarak+' KM');
      // const crd = pos.coords;

      // console.log('sukses2')
      // console.log('Your current position is:');
      // console.log(`Latitude : ${crd.latitude}`);
      // console.log(`Longitude: ${crd.longitude}`);
      // console.log(`More or less ${crd.accuracy} meters.`);
    }

    function error(err) {
      console.warn(`ERROR(${err.code}): ${err.message}`);
    }

    function distance(lat1, lon1, lat2, lon2, unit) {
    if ((lat1 == lat2) && (lon1 == lon2)) {
        return 0;
    } else {
            var radlat1 = Math.PI * lat1/180;
            var radlat2 = Math.PI * lat2/180;
            var theta = lon1-lon2;
            var radtheta = Math.PI * theta/180;
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            if (dist > 1) {
                dist = 1;
            }
            dist = Math.acos(dist);
            dist = dist * 180/Math.PI;
            dist = dist * 60 * 1.1515;
            if (unit=="K") { dist = dist * 1.609344 }
            if (unit=="N") { dist = dist * 0.8684 }
            return dist;
        }
    }
</script>
@endsection
