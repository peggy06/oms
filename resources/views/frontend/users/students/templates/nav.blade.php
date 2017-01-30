<nav class="navbar navbar-default nav-users navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-brand">
            <a href="{{ '' }}">
                <img src="{{ asset('images/banner3.png') }}" class="img-responsive" width="200" alt="">
            </a>
        </div>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav custom navbar-top-links navbar-right text-center">
        <li>
            <a href="{{ route('studentClear') }}">
                <i class="fa fa-envelope fa-fw"></i>
                @if($messages->where(['receiver' => auth()->user()->id, 'deleted' => 0, 'new' => 1])->count() != 0)
                    <sup class="badge small" id="requestBadge">{{$messages->where(['receiver' => auth()->user()->id, 'deleted' => 0, 'new' => 1])->count()}}</sup>
                @endif
            </a>
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ route('studentLogout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
        <!-- /.dropdown -->

    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">

                <li>
                    <a href="{{ route('studentProfile') }}">
                        <div class="row">
                            <div class="col-md-3 col-sm-2 col-xs-2">
                                <img src="{{ asset($users->find(auth()->user()->id)->profile->avatar) }}" width="50px" class="img-circle pull-left" alt="">
                            </div>
                            <div class="col-md-9 col-sm-10 col-xs-10" style="margin-top: 5px;">
                                <span class="pull-left">{{ auth()->user()->name }} <br> <span class="small">View Profile</span></span><br>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider">&nbsp;</li>
                <li>
                    <a href="{{ route('studentDashboard')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('studentClear') }}"><i class="fa fa-comment fa-fw"></i> Messages</a>
                </li>
                @if($users->find(auth()->user()->id)->profile->company_id != 0)
                    <li>
                        <a href="{{ route('studentForm') }}"><i class="fa fa-file-pdf-o fa-fw"></i> OJT Forms</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
<script>
    $(document).ready(function(){
        $("#requestTrigger").click(function(){
            $("#requestBadge").hide();
        });
    });
</script>