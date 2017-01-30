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

            </div>
            <br>
            <h4><b>Personal Information of OJT Student</b></h4>
            <p style="font-size: 12pt;line-height: 2">
                <b>Name:</b> {{ auth()->user()->lastname}}, {{ auth()->user()->firstname }}<br>
                <b>Contact:</b> 0{{ $users->find(auth()->user()->id)->profile->contact }}<br>
                <b>Name and Contact no. in case of emergency:</b> ________________________ <br>
                <b>Year and Section:</b> {{ $course->find($users->find(auth()->user()->id)->profile->company_id)->code }} <br>
                <b>Adviser/OJT Coordinator:</b> {{ $users->find(auth()->user()->under_to)->name }}
            </p><br>
            <h4><b>Company Information</b></h4>
            <p style="font-size: 12pt;line-height: 2">
                <b>Name:</b> {{ $company->name }}<br>
                <b>Contact:</b> 0{{ $users->find(auth()->user()->id)->profile->company_contact }}<br>
                <b>Address:</b> <br> {{ $company->address }}<br>
                <br><br>
            </p>
            <p style="font-size: 12pt;line-height: 2">
                Location Map:
                <br>
                <br>
                <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $company->latitude }},{{ $company->longitude }}&markers=color:blue|{{ $company->latitude }},{{ $company->longitude }}&zoom=16&size=600x300&maptype=roadmap&imageformat=JPEG&key=AIzaSyBWCrfFXJHO2Qnl6J_X6-RVTE58EFFU4tI" alt="Location of {{ $company->name }}" class="img-responsive" width="600" height="300">
            </p>
        </div>
    </div>
@stop