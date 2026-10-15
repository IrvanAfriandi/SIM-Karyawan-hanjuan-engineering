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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Data Karyawan</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Data Karyawan</h6>
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
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <a class="btn btn-sm btn-success px-2" style="margin-bottom:10px" href="{{ route('karyawan.create') }}"><ion-icon name="add"></ion-icon> Tambah Data</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
<table class="table align-items-center mb-0">
  <thead>
    <tr>
      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Identitas Diri</th>
      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Divisi</th>
      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jabatan</th>
      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Masuk</th>
      <th class="text-secondary opacity-7" width="200px"></th>
    </tr>
  </thead>
  <tbody>
  @foreach ($data as $karyawan)
    <tr>
      <td class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
      {{ $loop->iteration }}
      </td>
      <td>
        <div class="d-flex px-2 py-1">
          <div>
            <img src="{{ asset($karyawan->foto ? 'images/' . $karyawan->foto : 'images/user.jpg') }}"  
              class="avatar me-3" 
              style="width: 80px; height: 80px;" 
              alt="user-photo">
          </div>
          <div class="d-flex flex-column justify-content-center">
              <h6 class="mb-0 text-sm">{{ $karyawan->karyawan_users ? $karyawan->user_id->name : 'None' }}</h6>
              <p class="text-xs text-secondary mb-0">{{ $karyawan->karyawan_users ? $karyawan->user_id->email  : 'None' }}</p>
              <p class="text-xs text-secondary mb-0">
                  NIK : {{ $karyawan->nik ? $karyawan->nik  : 'None' }}
              </p>
          </div>
        </div>
      </td>
      <td class="align-middle text-center text-sm">
        <span class="badge badge-sm bg-gradient-info">{{ $karyawan->divisi_id ? $karyawan->divisi->nama_divisi  : 'None' }}</span>
      </td>
      <td class="align-middle text-center text-sm">
        <span class="badge badge-sm bg-gradient-warning">{{ $karyawan->jabatan_id ? $karyawan->jabatan->nama_jabatan  : 'None' }}</span>
      </td>
      <td class="align-middle text-center text-sm">
        <span class="badge badge-sm bg-gradient-success">{{ $karyawan->tgl_masuk ? $karyawan->tgl_masuk : 'None' }}</span>
      </td>
      <td class="align-middle text-center text-sm text-right">
          <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-primary font-weight-bold text-xs"><ion-icon name="pencil-sharp"></ion-icon> Edit</a>
          <form action="{{ route('karyawan.destroy', $karyawan->id_karyawan) }}" method="POST" style="display:inline;" id="deleteForm-{{ $karyawan->id_karyawan }}">
              @csrf
              @method('DELETE')
              <button type="button" class="btn btn-danger font-weight-bold text-xs" onclick="confirmDelete('{{ $karyawan->id_karyawan }}', '{{ $karyawan->user_id->name }}')"><ion-icon name="trash-outline"></ion-icon> Delete</a></button>
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
@endsection
@push('scripts')
<script>
   function confirmDelete(id, dataName) {
      Swal.fire({
          title: 'Anda yakin?',
          text: "Anda akan menghapus " + dataName + " dari database!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Tidak, batal!',
          reverseButtons: true
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById('deleteForm-' + id).submit();
          }
      });
  }
</script>
@endpush
