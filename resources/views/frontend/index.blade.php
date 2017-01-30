@extends('templates.map')

@section('content')
    {{--<div style=" width: 100%; height: 100%;">--}}
        {{--<img src="{{ asset('images/logo_red_hd.png') }}" alt="" width="50%" height="50%" style="display: block;margin: auto;" class="img-responsive">--}}
    {{--</div>--}}
    <div id="spinner" class="text-center" style="display: none;position: absolute;top: 0; left: 0; width: 100%;height: 175%;opacity: 0.8;background-color: #eee;z-index: 9999;">

            <h1 style="margin-top: 25%;">
                <span class="fa fa-spinner fa-spin fa-2x"></span><br>
                Please Wait
            </h1>
    </div>
    @include('frontend.templates.nav')
    <div class="container">
        <div class="page-wrapper">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-8" style="margin-bottom: 30px;">
                        <div style="width: 100%;">
                        <img src="{{ asset('images/headereditable.png') }}" alt="" width="450px" class="img-responsive" style="display: block; margin: auto;">
                        </div>
                        <br>
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                                <li data-target="#myCarousel" data-slide-to="3"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <img src="{{ asset('images/2.jpg') }}" alt="banner" width="100%">
                                </div>

                                <div class="item">
                                    <img src="{{ asset('images/4.jpg') }}" alt="banner" width="100%">
                                </div>

                                <div class="item">
                                    <img src="{{ asset('images/3.jpg') }}" alt="banner" width="100%">
                                </div>

                                <div class="item">
                                    <img src="{{ asset('images/1.jpg') }}" alt="banner" width="100%">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div style="border: solid 2px #e2e2e2;background-color: #fff;padding: 10px">
                                    <span class="lead" style="color: #6c1f1f">Vision</span><br><br>
                                    <p class="text-justify" style="text-indent: 20pt">
                                        A recognized leader for excellence in instruction, research, extension and production services, a key player in the education and formation of professionally competent, service-oriented and productive citizens, and a prime mover of the nation's sustainable socio-economic growth and development.
                                    </p>
                                </div>
                                <br>
                                <div style="border: solid 2px #e2e2e2;background-color: #fff;padding: 10px">

                                    <span class="lead" style="color: #6c1f1f">Mission</span><br><br>
                                    <p class="text-justify" style="text-indent: 20pt">
                                        The University shall provide higher professional, technical and special instruction for special purposes, and promote research and extension services, advances studies and progressive leadership in Agriculture, Commerce, Education, Fishery, Engineer, Art and Science, Law, Medicine, Public Administration, Technical and other fields as may be relevant
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="border: solid 2px #e2e2e2;background-color: #fff;padding: 10px">
                                    <h4>Register Now...</h4>
                                    @include('frontend.templates.reg-form')
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div style="border: solid 2px #e2e2e2;background-color: #fff;padding: 10px">
                                    <a href="http://www.freepik.com" target="_blank" style="color: #000;text-decoration: none">
                                        Vector avatars designed by Freepik
                                        <img src="{{ asset('images/freepik-logo-horizontal_318-39883.jpg') }}" alt="" width="100%">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('templates.footer')
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function spin(){
            document.getElementById('spinner').setAttribute('style', 'display:block;position: absolute;top: 0; left: 0; width: 100%;height: 175%;opacity: 0.8;background-color: #eee;z-index: 9999;');
        }
    </script>
@stop

