<!doctype html>

<html lang="id" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/') }}" data-template="vertical-menu-template-free" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title ?? 'Dashboard' }} | AMD Academy</title>

    <meta name="description" content="" />
    <meta name="_token" content="{{ csrf_token() }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/icon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('/') }}vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/') }}vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('/') }}css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/sweet-alert/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome-free-6.6.0-web/css/all.min.css') }}" />

    <!-- Page CSS -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Helpers -->
    <script src="{{ asset('/') }}vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('/') }}js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('layouts.partials.sidemenu')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.partials.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="text-body">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by
                                    <a href="https://amdacademy.id" target="_blank" class="footer-link">AMD Academy</a>
                                </div>

                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <div class="buy-now">
        <a href="https://amdacademy.id" target="_blank" class="btn btn-danger btn-buy-now">
            Tingkatkan Skillmu
            <br>
            dan Naikan Potensi Karirmu
        </a>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    @routes
    <script src="{{ asset('/') }}vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('/') }}vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('/') }}vendor/js/bootstrap.js"></script>
    <script src="{{ asset('/') }}vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('/') }}vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('vendor/libs/fontawesome-free-6.6.0-web/js/all.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/sweet-alert/sweetalert2.all.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('/') }}js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function csrfToken() {
            return $('meta[name="_token"]')[0].content;
        }

        function logout() {

            Swal.fire({
                title: "Are you sure?",
                text: "Anda akan keluar dari aplikasi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, keluar!",
                cancelButtonText: "Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: route('logout'),
                        data: {
                            _token: csrfToken(),
                        },
                        dataType: false,
                        success: function(response) {
                            window.location.href = route('login');
                        }
                    });
                }
            });


        }

        function deleteData(route) {
            Swal.fire({
                title: "Are you sure?",
                text: "Anda akan menghapus data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: route,
                        data: {
                            _token: csrfToken(),
                        },
                        dataType: false,
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            window.location.reload();
                        }
                    });
                }
            });


        }
    </script>

    @stack('js')
</body>

</html>
