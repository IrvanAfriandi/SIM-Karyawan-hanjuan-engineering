<div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0 d-flex align-items-center" href="" target="_blank">
          <img src="{{ asset('images/user.jpg')}}" class="navbar-brand-img" style="height: 80px; width: 40px; border-radius: 50%;" alt="main_logo">
          <div class="d-flex flex-column ms-2">
            <span class="font-weight-bold">{{ ucwords(Auth::user()->name) }}</span>
            <span class="text-muted">{{ ucwords(Auth::user()->role) }}</span>
          </div>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Main</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard.index')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @if(Auth::user()->role == 'admin')
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen Akun</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('users.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Users</span>
            </a>
          </li>
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen Karyawan</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('karyawan.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-chart-bar-32 text-dark text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Data Karyawan</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('absensi.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Absensi Karyawan</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('cuti.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Cuti Karyawan</span>
            </a>
          </li>
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen Data</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('jabatan.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-badge text-info text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Data Jabatan</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('divisi.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-atom text-info text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Data Divisi</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('jenis_cuti.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-align-left-2 text-info text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Data Jenis Cuti</span>
            </a>
          </li>
        @elseif(Auth::user()->role == 'karyawan')
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Karyawan</h6>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('absen_karyawan.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-atom text-info text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Absen Harian</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ route('pengajuan_cuti.index')}}">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-align-left-2 text-info text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Pengajuan Cuti</span>
            </a>
          </li>
        @endif
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Log Out</h6>
        </li>
        <li class="sidebar-item nav-item">
          <form id="logoutForm" action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="button" class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex justify-content-center" style="background: none; border: none; width: 100%; text-align: left;">
                <i class="ni ni-button-power text-danger text-sm opacity-10"></i>
              </button>
          </form>
        </li>
      </ul>
    </div>