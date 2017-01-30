<nav class="navbar navbar-inverse nav-users navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-brand">
            <a href="{{ '' }}">
                <img src="{{ asset('images/banner3.png') }}" alt="" width="200" class="img-responsive">

            </a>
        </div>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav custom navbar-top-links navbar-right text-center">
        <li>
            <a href="{{ route('adviserClear') }}">
                <i class="fa fa-envelope fa-fw"></i>
                @if($messages->where(['receiver' => auth()->user()->id, 'deleted' => 0, 'new' => 1])->count() != 0)
                    <span class="badge small" id="requestBadge">{{$messages->where(['receiver' => auth()->user()->id, 'deleted' => 0, 'new' => 1])->count()}}</span>
                @endif
            </a>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="requestTrigger">
                <i class="fa fa-globe fa-fw"></i>
                @if($notifications->where(['to' => auth()->user()->id, 'removed' => 0])->count() != 0)
                    <span class="badge small" id="requestBadge">{{$notifications->where(['to' => auth()->user()->id, 'removed' => 0])->count()}}</span>
                @endif
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-tasks dropdown-scroll">
                <iframe src="{{ route('adviserLoadNotification') }}" frameborder="0" height="100%" width="100%" style="overflow-x: hidden"></iframe>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="requestTrigger">
                <i class="fa fa-bullhorn fa-fw"></i>
                @if($permissions->where(['to' => auth()->user()->id, 'accepted' => 0])->count() != 0)
                    <span class="badge small" id="requestBadge">{{$permissions->where('new', 1)->count()}}</span>
                @endif
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts dropdown-scroll">
                <iframe src="{{ route('adviserLoadRequest') }}" frameborder="0" height="100%" width="100%" style="overflow-x: hidden"></iframe>
            </ul>
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
                <li><a href="{{ route('adviserLogout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                    <a href="{{ route('adviserProfile') }}">
                        <div class="row">
                            <div class="col-md-3 col-sm-2 col-xs-2">
                                <img src="{{ asset(auth()->user()->profile->avatar) }}" width="50px" class="img-circle pull-left" alt="">
                            </div>
                            <div class="col-md-9 col-sm-10 col-xs-10" style="margin-top: 5px;">
                                <span class="pull-left">{{ auth()->user()->name }} <br> <span class="small">View Profile</span></span><br>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="divider">&nbsp;</li>
                <li>
                    <a href="{{ route('adviserDashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('adviserClear') }}"><i class="fa fa-inbox fa-fw"></i> Inbox</a>
                </li>
                <li>
                    <a href="{{ route('myStudents') }}"><i class="fa fa-users fa-fw"></i> My Students</a>
                </li>
                <li>
                    <a href="{{ route('adviserActivityLogs') }}"><i class="fa fa-list-alt fa-fw"></i> Activity Log</a>
                </li>
                <li>
                    <a href="{{ route('adviserForms') }}"><i class="fa fa-file fa-fw"></i> OJT Forms</a>
                </li>
                <li>
                    <a href="{{ route('adviserReports') }}"><i class="fa fa-file-text fa-fw"></i> Reports</a>
                </li>
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