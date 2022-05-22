<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/demo.style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/tooltip.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body id="kt_body" class="bg-dark header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div id="app"></div>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>   
    <script>
        $(document).ready(function(){
            $( '#kt_aside' ).mouseenter( function(){
                $('body#kt_body[data-kt-aside-minimize="on"] .profile').show();
            }).mouseleave( function(){
                $('body#kt_body[data-kt-aside-minimize="on"] .profile').hide();
            });
            var start = moment().subtract(89, 'days');
            var end = moment();   
            $("#kt_daterangepicker_1").daterangepicker({
                autoApply:true,
                startDate: start,
                endDate: end,
                showDropdowns: true,
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'Last 90 Days': [moment().subtract(89, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function(start, end, label) {
                $('#kt_daterangepicker_1').val( start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
            });
        });
    </script>
</body>
</html>