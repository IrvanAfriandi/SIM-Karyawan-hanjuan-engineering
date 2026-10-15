
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('argon/assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{ asset('argon/assets/img/favicon.png')}}">
  <title>
    Aplikasi Data Karyawan
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="{{ asset('argon/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{ asset('argon/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('argon/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <link id="pagestyle" href="{{ asset('argon/assets/css/argon-dashboard.css?v=2.0.4')}}" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        width: 50%;
        border-radius: 8px;
        text-align: left;
        position: relative;
    }
    .close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 24px;
        cursor: pointer;
    }
    .modal-dialog {
    display: flex;
    align-items: center;
    min-height: 100vh; /* Menjadikan modal berada di tengah secara vertikal */
}

</style>
  
