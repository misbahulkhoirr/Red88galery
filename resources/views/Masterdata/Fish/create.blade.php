@extends('layouts.app')
@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ $title }}</div>
                {{-- <div class="card-body d-flex justify-content-center"> --}}
                  <div class="col-md-12 mb-2">
                    <form action="{{url('fish')}}" method="POST" enctype="multipart/form-data">
                      @csrf                            
                      <div class="row mt-5">
                        <div class="col-lg-6 mb-3">
                            <div class="mb-3">
                              <label for="date_in" class="form-label">Tanggal Masuk</label>
                              <input type="date" class="form-control @error('date_in') is-invalid @enderror" id="date_in" name="date_in" autofocus value="{{ old ('date_in')}}">
                              @error('date_in')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                          </div>
                            <div class="mb-3">
                                <label for="fish_type" class="form-label">Supplier</label>
                                <select class="form-control form-select @error('supplier_id') is-invalid @enderror" name="supplier_id" autofocus>
                                <option value="">Pilih Supplier</option>
                                  @foreach ($suppliers as $supplier)
                                  @if (old('supplier_id')==$supplier->id)
                                  <option value="{{ $supplier->id }}" selected>{{ $supplier->supplier_name }}</option>
                                  @else
                                  <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                  @endif
                                  @endforeach
                                  
                                </select>
                                @error('supplier_id')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="fish_type" class="form-label">Jenis Ikan</label>
                              <div class="input-group mb-3">
                                  <select class="form-control form-select @error('fish_type_id') is-invalid @enderror" name="fish_type_id" autofocus>
                                    <option value="">Select Fish</option>
                                    @foreach ($fish_type as $fish_type)
                                      @if (old('fish_type_id')==$fish_type->id)
                                      <option value="{{ $fish_type->id }}" selected>{{ $fish_type->name }}</option>
                                      @else
                                      <option value="{{ $fish_type->id }}">{{ $fish_type->name }}</option>
                                      @endif
                                    @endforeach                               
                                  </select>  
                                  <select class="form-control form-select @error('size_id') is-invalid @enderror" name="size_id" autofocus>
                                    <option value="">Select Size</option>
                                    @foreach ($size as $size)
                                    @if (old('size_id')==$size->id)
                                    <option value="{{ $size->id }}" selected>{{ $size->name }}</option>
                                    @else
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endif
                                    @endforeach                                 
                                  </select>

                                  @error('fish_type_id')
                                    <div class="invalid-feedback">
                                      {{ $message}}
                                    </div>
                                  @enderror     
                                
                                  @error('size_id')
                                    <div class="invalid-feedback">
                                      {{ $message}}
                                    </div>
                                  @enderror
                              </div>
                            </div>

                            <div class="mb-3">
                              <label for="tank_type" class="form-label">Jenis Tank</label>
                              <div class="input-group mb-3">
                                <select class="form-control form-select @error('tank_type_id') is-invalid @enderror" name="tank_type_id" id="tank_type_id">
                                  <option value="">Select Tipe Tank</option>
                                  @foreach ($tank_type as $row)
                                    @if ($user->role_id != 1)                                    
                                        @if (old('tank_type_id')==$row->id)
                                        <option value="{{ $row->id }}" selected>{{ $row->name}}</option>
                                        @else
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endif
                                    @else
                                        @if (old('tank_type_id')==$row->id)
                                        <option value="{{ $row->id }}" selected>{{ $row->name}}</option>
                                        @else
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endif
                                    @endif
                                  @endforeach                                
                                </select>
                                @error('tank_type_id')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                                <select class="form-control form-select  @error('tank_id') is-invalid @enderror" name="tank_id" id="tank_id">
                                  <option value="">Select No Tank</option>                                
                                </select>
                                @error('tank_id')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                          </div>
                            </div>
                            <div class="mb-3" id="jumlahIkan" style="display: none">
                                <label for="jumlah_ikan" class="form-label">Jumlah Ikan</label>
                                <input type="text" class="form-control @error('jumlah_ikan') is-invalid @enderror" name="jumlah_ikan" autofocus value="{{ old ('jumlah_ikan')}}">
                                @error('jumlah_ikan')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="class" class="form-label">Kelas</label>
                                <select name="class" id="class" class="form-control @error('jumlah_ikan') is-invalid @enderror">
                                  <option value="1" {{ (old('class') == 1) ? 'selected' : '' }}>1</option>
                                  <option value="2" {{ (old('class') == 2) ? 'selected' : '' }}>2</option>
                                  <option value="3" {{ (old('class') == 3) ? 'selected' : '' }}>3</option>
                                  <option value="4" {{ (old('class') == 4) ? 'selected' : '' }}>4</option>
                                  <option value="5" {{ (old('class') == 5) ? 'selected' : '' }}>5</option>
                                </select>
                                @error('class')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                              <label for="first_size" class="form-label">Ukuran Awal</label>
                              <div class="input-group">
                              <input type="text" class="form-control @error('first_size') is-invalid @enderror" id="first_size" name="first_size" autofocus value="{{ old ('first_size')}}">
                              <label for="first_size" class="input-group-text">cm</label>
                              @error('first_size')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                            </div>
                          </div>
                         
                          </div>

                          <div class="col-lg-6 mb-3">
                    
                            <div class="mb-3">
                              <label for="capital" class="form-label">Modal</label>
                              <input type="text" class="form-control @error('capital') is-invalid @enderror formatNumber" id="capital" name="capital" autofocus value="{{ str_replace([',','.'],'',old('capital')) }}">
                              @error('capital')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                          </div>
                          <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control" placeholder="Catatan" name="notes" id="notes">{{old('notes')}}</textarea>
                        </div>
                           
                            <div class="mb-3">
                              <label for="photo" class="form-label">Upload Gambar</label>
                              <img class="img-preview img-fluid mb-3 col-sm-5">
                              <input type="hidden" id="img-hidden" name="photo">
                              <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" value="{{ old ('photo')}}">
                              <div class="error"></div>
                              @error('photo')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                          <div class="mb-3">
                              <label for="video" class="form-label">Link Video</label>
                              <div id='preVideo'></div>
                              <input type="hidden" name="video" id='url-video'>
                              <input class="form-control @error('video') is-invalid @enderror" type="text" id="video" value="{{ old ('video')}}">
                              @error('video')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>

                            
                          </div>
                        </div>
                        <div class="mt-2 mb-3 d-flex justify-content-center">
                          <a href="{{url('fish')}}" class="btn btn-secondary mr-2">Batal</a>
                          <button type="submit" class="btn primaryBtn text-white" id="btn">Simpan</button>
                        </div>
                    </form>
               
    </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog large">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="modalLabel">Crop Gambar</h5>
    <button type="button" class="close tutup" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="img-container">
      <div class="row">
        <div class="col-md-6">
          <img class="img" id="image" src="">
        </div>
        <div class="col-md-4">
          <div class="preview"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-secondary tutup">Close</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
  </div>
</div>
</div>
</div>
<script src={{ asset('js/crop.js') }}></script>

<script type="text/javascript">
 $(document).ready(function($){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   
 
$('#tank_type_id').change(function(){
    var id = $(this).val();
    if(id){
        $.ajax({
          type:"get",
          url: "{{ url('fish/create')}}",
            data: { id: id },
           dataType: 'JSON',
           success:function(res){
            if(res){
                $("#tank_id").empty();
                $("#tank_id").append('<option>Select No Tank</option>');
                $.each(res,function(index, data){
                    $("#tank_id").append('<option class="input-group-text" value="'+data.id+'">'+data.no_tank+'</option>');
                    
                });
            }else{
              $("#tank_id").empty();
            }
           }
        });
    }else{
        $("#tank_id").empty();
    }

    if(id == 2 || id == 3) {
      $('#jumlahIkan').show();
    }else{
      $('#jumlahIkan').hide();
    }
   });

   var tipe_tank = $('#tank_type_id').val();
    if(tipe_tank != null){
        $.ajax({
          type:"get",
          url: "{{ url('fish/create')}}",
            data: { id: tipe_tank },
           dataType: 'JSON',
           success:function(res){
            if(res){
                $("#tank_id").empty();
                $("#tank_id").append('<option>Select No Tank</option>');
                $.each(res,function(index, data){
                    $("#tank_id").append('<option class="input-group-text" value="'+data.id+'">'+data.no_tank+'</option>');
                });
            }else{
              $("#tank_id").empty();
            }
           }
        });
        if(tipe_tank == 2 || tipe_tank == 3) {
      $('#jumlahIkan').show();
    }else{
      $('#jumlahIkan').hide();
    }
  }

  });
</script>
<script>
  $("body").on("change", "#video", function (e) {
    var inpVideo = $('#video').val();
    var pathname = new URL(inpVideo).pathname;
    var urlpath = pathname.replace('/', '');
console.log(urlpath);
    document.getElementById("url-video").value = urlpath;
    $('#preVideo').html('<iframe class="preVideo" src="https://www.youtube.com/embed'+pathname+'" frameborder="0" allowfullscreen></iframe>');
    
  })
</script>

@endsection
