<footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Irvan Afriandi</a>
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="mailto:aldonisuper123.com" class="nav-link text-muted" target="_blank">
                    <i class="fas fa-envelope fa-lg"></i> 
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://wa.me/6285157317178" class="nav-link text-muted" target="_blank">
                    <i class="fab fa-whatsapp fa-lg"></i>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://www.instagram.com/ald.py" class="nav-link text-muted" target="_blank">
                    <i class="fab fa-instagram fa-lg"></i>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://www.tiktok.com/@ald.py" class="nav-link text-muted pe-0" target="_blank">
                    <i class="fab fa-tiktok fa-lg"></i>
                  </a>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </footer>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="{{ asset('argon/assets/js/core/popper.min.js')}}"></script>
  <script src="{{ asset('argon/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset('argon/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('argon/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{ asset('argon/assets/js/plugins/chartjs.min.js')}}"></script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('argon/assets/js/argon-dashboard.min.js?v=2.0.4')}}"></script>
  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('argon/assets/sweetalert2/sweetalert2.min.js')}}"></script>>
<script src="{{ asset('argon/assets/sweetalert2.js')}}"></script>>
<script>
    document.querySelector('.sidebar-item button').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: 'Anda akan logout dari aplikasi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form logout jika konfirmasi
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>