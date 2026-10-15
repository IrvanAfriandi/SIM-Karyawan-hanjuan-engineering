@extends('layouts.default')
@section('content')
@if ($message = Session::get('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ $message }}',
            showConfirmButton: true,
            confirmButtonText: 'OK',
        });
    </script>
@endif 
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Manajenem Akun</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Users</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Users</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            @if(session('status'))
                <div class="alert alert-success mb-1 mt-1">
                    {{ session('status') }}
                </div>
            @endif
<form action="{{ route('karyawan.update',$karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" value="{{ $karyawan->user_id->name }}" 
        class="form-control" placeholder="name">
        @error('name')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Divisi</label>
        <select name="divisi_id" class="form-select mb-3" aria-label="Default select example">
            @foreach($divisi as $divisi)
                <option value="{{ $divisi->id_divisi }}" 
                    {{ $karyawan->divisi_id == $divisi->id_divisi ? 'selected' : '' }}>
                    {{ $divisi->nama_divisi }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Jabatan</label>
        <select name="jabatan_id" class="form-select mb-3" aria-label="Default select example">
            @foreach($jabatan as $jabatan)
                <option value="{{ $jabatan->id_jabatan }}" 
                    {{ $karyawan->jabatan_id == $jabatan->id_jabatan ? 'selected' : '' }}>
                    {{ $jabatan->nama_jabatan }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">NIK</label>
        <input type="text" name="nik" value="{{ $karyawan->nik }}" 
        class="form-control" placeholder="None">
        @error('nik')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Tanggal Masuk</label>
        <input type="text" name="tgl_masuk" value="{{ $karyawan->tgl_masuk }}" 
        class="form-control" placeholder="tgl_masuk">
        @error('tgl_masuk')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Foto</label>
        <input type="file" id="foto" name="foto" class="form-control" onchange="previewImage(event)">
        <div id="imagePreviewContainer" style="padding-top:30px; {{ $karyawan->foto ? '' : 'display:none;' }}">
            <img id="imagePreview" 
                src="{{ $karyawan->foto ? asset('images/' . $karyawan->foto) : '#' }}" 
                alt="Image Preview" 
                style="max-width: 200px;">
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary ml-3">Submit</button>
    </div>
</form>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var imagePreview = document.getElementById('imagePreview');
            var imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreview.src = reader.result;
            imagePreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush