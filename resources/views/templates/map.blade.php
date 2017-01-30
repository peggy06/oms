<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ isset($page_title) ? $page_title : "BulSU-OJT Monitoring" }}</title>
    {{--====================================================================================--}}
    {{--<!-- My Custom CSS -->--}}
    {{--<link rel="stylesheet" href="https://bulsu-oms.herokuapp.com/css/custom.css">--}}

    {{--<!-- Plugins Bootstrap Core CSS -->--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}

    {{--<!-- Plugins MetisMenu CSS -->--}}
    {{--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/metisMenu/2.5.2/metisMenu.min.css">--}}


    {{--<link rel="stylesheet" href="https://bulsu-oms.herokuapp.com/plugins/datatables-plugins/integration/bootstrap/1/dataTables.bootstrap.css">--}}

    {{--<!-- Plugins Custom CSS -->--}}
    {{--<link href="https://bulsu-oms.herokuapp.com/plugins/css/sb-admin-2.css" rel="stylesheet">--}}

    {{--<!-- Plugins Custom Fonts -->--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}

    <!-- Plugins jQuery -->

    {{--<script src="https://bulsu-oms.herokuapp.com/plugins/jquery/dist/jquery.min.js"></script>--}}
    {{--<link href="https://bulsu-oms.herokuapp.com/plugins/metisMenu/dist/metisMenu.min.css" rel="stylesheet">--}}

    {{--========================================================================================--}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('plugins/metisMenu/dist/metisMenu.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/css/sb-admin-2.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-plugins/integration/bootstrap/1/dataTables.bootstrap.css') }}">

    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <script src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>
</head>
<body {{ isset($page_title) == 'Welcome to BulSU - OMS' ? 'frontpage' : '' }}>
@yield('content')
{{--====================================================================--}}
{{--<script src="https://bulsu-oms.herokuapp.com/plugins/bootstrap/dist/js/bootstrap.min.js"></script>--}}

{{--<!-- Plugins Metis Menu Plugin JavaScript -->--}}
{{--<script src="https://bulsu-oms.herokuapp.com/plugins/metisMenu/dist/metisMenu.min.js"></script>--}}

{{--<script src="https://bulsu-oms.herokuapp.com/plugins/datatables/media/js/jquery.dataTables.min.js"></script>--}}

{{--<script src="https://bulsu-oms.herokuapp.com/plugins/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>--}}


{{--<!-- Plugins Custom Theme JavaScript -->--}}
{{--<script src="https://bulsu-oms.herokuapp.com/plugins/js/sb-admin-2.js"></script>--}}
{{--================================================================--}}
        <!-- Plugins Bootstrap Core JavaScript -->
<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Plugins Metis Menu Plugin JavaScript -->
<script src="{{ asset('plugins/metisMenu/dist/metisMenu.min.js') }}"></script>

<script src="{{ asset('plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('plugins/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>


<!-- Plugins Custom Theme JavaScript -->
<script src="{{ asset('plugins/js/sb-admin-2.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

<script>
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    $("[data-toggle=popover]")
            .popover()
</script>
</body>
</html>
