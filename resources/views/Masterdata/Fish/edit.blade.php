@extends('layouts.app')
@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header">{{ $title }}</div>
                  <div class="col-md-12 mb-2">
                    <form action="{{url('fish/'.$fish->id)}}" method="POST" enctype="multipart/form-data">
                      @method('PUT')
                      @csrf

                      <div class="row mt-5">
                          <div class="col-lg-6 mb-3">

                            <div class="mb-3">
                                <label for="code" class="form-label">Kode</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old ('code', $fish->code)}}" readonly>
                                @error('code')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                              <label for="date_in" class="form-label">Tanggal Masuk</label>
                              <input type="date" class="form-control @error('date_in') is-invalid @enderror" id="date_in" name="date_in" autofocus value="{{ old ('date_in', $fish->date_in)}}">
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
                                  @if (old('supplier_id',$fish->supplier->id)==$supplier->id)
                                  <option value="{{ $supplier->id }}" selected>{{ $supplier->supplier_name }}</option>
                                  @else
                                  <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                  @endif
                                  @endforeach
                                  @error('supplier_id')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                                </select>
                            </div>

                            <div class="mb-3">
                              <label for="tank" class="form-label">No Tank</label>
                              <select class="form-control form-select @error('tank_id') is-invalid @enderror" name="tank_id">
                              <option value="">Select Tank</option>
                                @foreach ($tank as $tank)
                                @if (old('tank_id', $fish->tank->id)==$tank->id)
                                <option value="{{ $tank->id }}" selected>{{ $tank->no_tank }}</option>
                                @else
                                <option value="{{ $tank->id }}">{{ $tank->no_tank }}</option>
                                @endif
                                @endforeach
                                @error('tank_id')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                              </select>
                          </div>

                          <div class="mb-3">
                            <label for="fish_type" class="form-label">Jenis Ikan</label>

                            <div class="input-group mb-3">
                              <select class="form-control form-select @error('fish_type_id') is-invalid @enderror" name="fish_type_id" autofocus>
                              <option value="">Select Fish</option>
                                @foreach ($fish_type as $fish_type)
                                @if (old('fish_type_id', $fish->fish_type->id)==$fish_type->id)
                                <option value="{{ $fish_type->id }}" selected>{{ $fish_type->name }}</option>
                                @else
                                <option value="{{ $fish_type->id }}">{{ $fish_type->name }}</option>
                                @endif
                                @endforeach
                                @error('fish_type')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                              </select>
                              <select class="form-select input-group-text @error('size_id') is-invalid @enderror" name="size_id" autofocus>
                                <option value="">-- Pilih Ukuran --</option>
                                  @foreach ($size as $size)
                                  @if (old('size_id', $fish->size->id)==$size->id)
                                  <option value="{{ $size->id }}" selected>{{ $size->name }}</option>
                                  @else
                                  <option value="{{ $size->id }}">{{ $size->name }}</option>
                                  @endif
                                  @endforeach
                                  @error('Size_id')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                                </select>
                            </div>
                          </div>

                          <div class="form-group mb-3">
                                <label for="class" class="form-label">Kelas</label>
                                <select name="class" id="class" class="form-control @error('jumlah_ikan') is-invalid @enderror">
                                  <option value="1" {{ (old('class',$fish->class) == 1) ? 'selected' : '' }}>1</option>
                                  <option value="2" {{ (old('class',$fish->class) == 2) ? 'selected' : '' }}>2</option>
                                  <option value="3" {{ (old('class',$fish->class) == 3) ? 'selected' : '' }}>3</option>
                                  <option value="4" {{ (old('class',$fish->class) == 4) ? 'selected' : '' }}>4</option>
                                  <option value="5" {{ (old('class',$fish->class) == 5) ? 'selected' : '' }}>5</option>
                                </select>
                                @error('class')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="first_size" class="form-label">Ukuran Awal</label>
                                <input type="text" class="form-control @error('first_size') is-invalid @enderror" id="first_size" name="first_size" autofocus value="{{ old ('first_size', $fish->first_size)}}">
                                @error('first_size')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                            </div>
                            @if (auth()->user()->role_id == 1)
                            <div class="mb-3">
                                <label for="capital" class="form-label">Modal</label>
                                <input type="text" class="form-control @error('capital') is-invalid @enderror formatNumber" id="capital" name="capital" autofocus value="{{ old('capital',$fish->capital) }}">
                                @error('capital')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                                </div>
                                <div class="mb-3">
                                  <label for="sell_price" class="form-label">Harga Jual</label>
                                  <input type="text" class="form-control @error('sell_price') is-invalid @enderror formatNumber" id="sell_price" name="sell_price" autofocus value="{{ old('sell_price',$fish->sell_price) }}">
                                  @error('sell_price')
                                  <div class="invalid-feedback">
                                    {{ $message}}
                                  </div>
                                  @enderror
                              </div>
                            @else
                            <div class="mb-3">
                                <label for="capital" class="form-label">Modal</label>
                                <input type="text" class="form-control @error('capital') is-invalid @enderror formatNumber" id="capital" name="capital" autofocus value="{{ old('capital',$fish->capital) }}" readonly>
                                @error('capital')
                                <div class="invalid-feedback">
                                  {{ $message}}
                                </div>
                                @enderror
                                </div>
                                <div class="mb-3">
                                  <label for="sell_price" class="form-label">Harga Jual</label>
                                  <input type="text" class="form-control @error('sell_price') is-invalid @enderror formatNumber" id="sell_price" name="sell_price" autofocus value="{{ old('sell_price',$fish->sell_price) }}" readonly>
                                  @error('sell_price')
                                  <div class="invalid-feedback">
                                    {{ $message}}
                                  </div>
                                  @enderror
                              </div>
                            @endif

                          </div>


                      <div class="col-lg-6">
                        {{-- <div class="mb-3">
                          <label for="date_out" class="form-label">Tgl Keluar</label>
                          <input type="date" class="form-control @error('date_out') is-invalid @enderror" id="date_out" name="date_out" autofocus value="{{ old ('date_out', $fish->date_out)}}">
                          @error('date_out')
                          <div class="invalid-feedback">
                          {{ $message}}
                          </div>
                          @enderror
                      </div> --}}

                      <div class="mb-3">
                        <label for="status" class="form-controlt">Status</label>
                        <select class="form-control form-select @error('status_id') is-invalid @enderror" name="status_id"  >
                        <option value="">-- Pilih Status --</option>
                          @foreach ($status as $status)
                          @if (old('status_id',$fish->status->id)==$status->id)
                          <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                          @else
                          <option value="{{ $status->id }}">{{ $status->name }}</option>
                          @endif
                          @endforeach
                          @error('status_id')
                          <div class="invalid-feedback">
                            {{ $message}}
                          </div>
                          @enderror
                        </select>
                      </div>

                            <div class="mb-3">
                              <label for="notes" class="form-label">Catatan</label>
                              {{-- <input type="text" class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" autofocus value="{{ old ('notes', $fish->notes)}}"> --}}
                              <textarea class="form-control @error('notes') is-invalid @enderror"  placeholder="Catatan" name="notes" id="notes">{{old('notes',  $fish->notes)}}</textarea>
                              @error('notes')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                          </div>

                          <div class="mb-3">
                            <label for="photo" class="form-label">Unggah photo</label>
                            <input type="hidden" name="photolama" value="{{ $fish->photo }}"> {{-- input untuk menghapus img di folder public/fish-photos --}}
                            @if ($fish->photo)
                            <img src="{{asset('storage/'.$fish->photo)}}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                @else
                                <img class="img-preview img-fluid mb-3 col-sm-5">
                            @endif
                            <img class="img-preview img-fluid mb-3 col-sm-5">
                            <input type="hidden" id="img-hidden" name="photo">
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" onchange="previewImage()">
                            @error('photo')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                          </div>

                          <div class="mb-3">
                            <label for="video" class="form-label">Link Video</label>
                            <input type="hidden" name="videolama" value="{{ $fish->video }}">

                                <div id='preVideo'></div>
                            <input type="hidden" name="video" id='url-video'>
                            <input class="form-control @error('video') is-invalid @enderror" type="text" id="video" value="{{ old ('video', 'https://youtu.be/'.$fish->video)}}">
                            @error('video')
                              <div class="invalid-feedback">
                                {{ $message}}
                              </div>
                              @enderror
                          </div>

                      </div>
                      <div class="mt-2 mb-3 d-flex justify-content-center">
                        <a href="{{url('fish')}}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn primaryBtn text-white">Simpan</button>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
    </div>

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog large" role="document">
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
                <img class="img" id="image" src="https://avatars0.githubusercontent.com/u/3456749">
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
    <script>
       var inpVideo = $('#video').val();

       var pathname = new URL(inpVideo).pathname;
        var urlpath = pathname.replace('/', '');
        console.log(pathname);
        document.getElementById("url-video").value = urlpath;
        if(pathname != '/'){
          $('#preVideo').html('<iframe class="preVideo" src="https://www.youtube.com/embed'+pathname+'" frameborder="0" allowfullscreen></iframe>');
        }else{
          $('#preVideo').html('');
          document.getElementById("url-video").value = ''
          document.getElementById("video").value = ''
        }

      $("body").on("change", "#video", function (e) {
        var inpVideo = $('#video').val();
        var pathname = new URL(inpVideo).pathname;
        var urlpath = pathname.replace('/', '');

        document.getElementById("url-video").value = urlpath;
        if(pathname){
          $('#preVideo').html('<iframe class ="preVideo" src="https://www.youtube.com/embed'+pathname+'" frameborder="0" allowfullscreen></iframe>');
        }


      })
    </script>
@endsection
