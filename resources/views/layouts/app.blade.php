<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-90680653-2');
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>HRIS | @yield('title')</title>

    <!-- vendor css -->
    <link href="/assets/lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/assets/lib/typicons.font/typicons.css" rel="stylesheet">
    <link href="/assets/lib/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">

    <!-- azia CSS -->
    <link rel="stylesheet" href="/assets/css/azia.css">
    @livewireStyles()
</head>

<body>

    @include('layouts.header')
    <div class="az-content az-content-dashboard">

        <div class="container">
            <div class="az-content-body">
                {{ $slot }}
            </div><!-- az-content-body -->
        </div>
    </div><!-- az-content -->

    @include('layouts.footer')


    <script src="/assets/lib/jquery/jquery.min.js"></script>
    <script src="/assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/lib/ionicons/ionicons.js"></script>
    <script src="/assets/lib/jquery.flot/jquery.flot.js"></script>
    <script src="/assets/lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="/assets/lib/chart.js/Chart.bundle.min.js"></script>
    <script src="/assets/lib/peity/jquery.peity.min.js"></script>

    <script src="/assets/js/azia.js"></script>
    <script src="/assets/js/chart.flot.sampledata.js"></script>
    <script src="/assets/js/dashboard.sampledata.js"></script>
    <script src="/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script>
        // $(document).ready(function() {
        //     $('#table').DataTable();
        // })
        setTimeout(() => {
            const alertBox = document.getElementById('alertBox');
            if (alertBox) {
                const bsAlert = new bootstrap.Alert(alertBox);
                bsAlert.close(); // auto close
            }
        }, 3000);

        document.addEventListener('livewire:init', () => {
            Livewire.on('reinitComponents', () => {

                setTimeout(() => {
                    const alertBox = document.getElementById('alertBox');
                    if (alertBox) {
                        const bsAlert = new bootstrap.Alert(alertBox);
                        bsAlert.close(); // auto close
                    }

                }, 1000);




                // // inisialisasi ulang setelah update DOM
                // setTimeout(() => {
                //     $('#table').DataTable();
                // }, 100);
            });
        });
    </script>
    @livewireScripts()
</body>

</html>
