@extends("layouts.default")
@section("content")
@if ($message = Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ $message }}',
            timer: 5000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
        });
    </script>
@endif
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Manajemen Karyawan</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Absensi Karyawan</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Data Absensi Karyawan</h6>
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
      <div class="row justify-content-center">
        <div class="col-10">
            <div class="card mb-4" style="height: 300px;">
                <div class="card-body d-flex align-items-center justify-content-center">
                    @if ($data->isNotEmpty()) 
                        <div class="card border border-success rounded p-4 text-center" style="width: 80%;">
                            <h3 class="text-success font-weight-bold">Anda telah absen hari ini</h3>
                        </div>
                    @else
                        <div class="card border border-warning rounded p-5 text-center" style="width: 80%;">
                            <h2 class="text-warning font-weight-bold">Anda belum absen hari ini</h2>
                            <form action="{{ route('absen_karyawan.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning mt-4 px-4 py-2" style="font-size: 18px;">Absen Sekarang</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
