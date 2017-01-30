@extends('templates.master')

@section('content')
    <script>
        function printDocument(){
            document.getElementById('printer').setAttribute('style', 'display: none');
            window.print();

            document.getElementById('printer').setAttribute('style', 'margin-right: 80px; display: block');
        }
    </script>
    <a href="javascript:printDocument()" class="pull-right btn btn-success btn-sm" id="printer" style="margin-right: 80px;"><span class="fa fa-print "></span> Print</a>
    <div style="background-color: #5e5e5e">
        <div class="legal margin-default">
            <img src="{{ asset('images/bsu_logo.jpeg') }}" alt="" width="90" class="logo">
            <div class="text-center">
                <p>
                    <i style="font-size: 12pt">Republic of the Philippines</i><br>
                    <b style="font-size: 16pt">Bulacan State University</b><br>
                    <b style="font-size: 18pt">Sarmiento Campus</b><br>
                    <i style="font-size: 12pt">City of San Jose del Monte Bulacan</i><br>
                    <i style="font-size: 12pt">Tel. / Fax 044-691-63-67</i><br><br>
                </p>
                <hr style="border: double">
                <span class="lead strong text-center">STUDENT'S WEEKLY ACTIVITY SHEET</span>

            </div>
            <div style="border: 1px solid; width: 125px;height: 80px;float: right" class="text-center">
                Week No: <br>
                <span style="font-size: 20pt;"><b>{{ $week  }}</b></span>
            </div>
            <br><br><br><br><br>
            <p style="font-size: 12pt;">
                    <span class="pull-left">
                        Student Trainee: <ins>{{ $user->name }}</ins>
                    </span>
                    <span class="pull-right">
                        Technology Area: <ins>{{ $user->profile->technology_area }}</ins>
                    </span><br>
                    <span class="pull-left">
                        Supervisor: <ins>{{ $user->profile->company_supervisor }}</ins>
                    </span>
                    <span class="pull-right">
                        Dept / Section: <ins>{{ strtoupper($course->code) }} {{ $section->section }}</ins>
                    </span>
            </p>
            <br><br>
            <table border="solid" style="font-size: 12pt;" width="100%" class="docu-table text-center">
                <thead>
                <tr>
                    <td>Date</td>
                    <td>No.of Hours Rendered</td>
                    <td>Student Activity</td>
                    <td>Supervisor's Signature</td>
                </tr>
                </thead>
                <tbody>
                @foreach($swass as $dtr)
                    <tr>
                        <td>
                            {{ $dtr->date }} <br>
                            <span class="small strong">
                            Time-in: {{ $dtr->created_at->format('H:i:s a')}} <br>
                            Time-out: {{ $dtr->updated_at->format('H:i:s a')}} </span>
                        </td>
                        <td  style="padding-bottom: 55px;">
                            @if( $dtr->created_at->diffInSeconds($dtr->updated_at) < 60)
                                {{ $dtr->created_at->diffInSeconds($dtr->updated_at)}} seconds
                            @elseif($dtr->created_at->diffInSeconds($dtr->updated_at) < 3600)
                                {{ $dtr->created_at->diffInMinutes($dtr->updated_at)}} minutes
                            @elseif($dtr->created_at->diffInSeconds($dtr->updated_at) > 3600)
                                {{ $dtr->created_at->diffInHours($dtr->updated_at)}} hours
                            @else

                            @endif
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <br>
            <p>Total Number of Hours Rendered:______________________</p>
            <p>Remarks: <br>
                ________________________________________________________________________________
            </p>
        </div>
    </div>
@stop