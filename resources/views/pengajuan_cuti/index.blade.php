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
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 mt-3">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">Jenis Cuti</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">Alasan Cuti</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">Tanggal Mulai Cuti</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">Tanggal Selesai Cuti</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-100">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $pengajuan_cuti)
                    <tr>
                      <td class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      {{ $loop->iteration }}
                      </td>
                      <td class="text-sm">
                        {{ $pengajuan_cuti->jenis_cuti ? $pengajuan_cuti->jenis_cuti_id->nama_cuti : 'None' }}
                      </td>
                      <td class="text-sm">
                        {{ $pengajuan_cuti->alasan ? $pengajuan_cuti->alasan : 'None' }}
                      </td>
                      <td class="text-center text-sm">
                        {{ $pengajuan_cuti->tgl_mulai ? $pengajuan_cuti->tgl_mulai : 'None' }}
                      </td>
                      <td class="text-center text-sm">
                        {{ $pengajuan_cuti->tgl_selesai ? $pengajuan_cuti->tgl_selesai : 'None' }}
                      </td>
                      <td class="text-center text-sm">
                        <span class="badge badge-sm 
                            {{ $pengajuan_cuti->status == 'disetujui' ? 'bg-gradient-success' : 
                              ($pengajuan_cuti->status == 'ditolak' ? 'bg-gradient-danger' : 
                              ($pengajuan_cuti->status == 'menunggu' ? 'bg-gradient-secondary' : 'bg-gradient-dark')) }}">
                            {{ $pengajuan_cuti->status ?? 'None' }}
                        </span>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                <div class="card-header pb-0 d-flex justify-content-center">
                    <button class="btn btn-sm btn-warning px-3 d-flex align-items-center text-uppercase" 
                            style="margin-bottom:10px;" 
                            onclick="openModal()">
                        <ion-icon name="add" class="me-1"></ion-icon> Buat Pengajuan Cuti Baru
                    </button>
                </div>

                <!-- Modal Pop-up Form Pengajuan Cuti -->
<div id="cutiModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document"> <!-- Tambahkan modal-lg untuk memperbesar modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pengajuan Cuti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengajuan_cuti.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tgl_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tgl_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tgl_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_cuti">Jenis Cuti</label>
                        <select class="form-control" name="jenis_cuti" required>
                            <option value="">-- Pilih Jenis Cuti --</option>
                            @foreach($jenis_cuti as $jenis_cuti)
                            <option value="{{ $jenis_cuti->id_jenis_cuti }}">
                                {{ $jenis_cuti->nama_cuti }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan</label>
                        <textarea class="form-control" name="alasan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ajukan Cuti</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('scripts')
<script>
    function openModal() {
        $('#cutiModal').modal('show');
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
