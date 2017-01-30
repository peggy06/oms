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
            </div>
            <p style="font-size: 12pt" class="text-center">
                <em><b>In-Plant Training Program</b></em><br>
                <em><b>Performance Evaluation Report</b></em>
            </p><br>
            <p style="font-size: 12pt; line-height: 1.25">
                <span class="pull-left">
                    Student Trainee: <b class="tele-type">{{ auth()->user()->name }}</b>
                </span>
                <span class="pull-right">
                    Age: <b class="tele-type">{{ Carbon\Carbon::now()->diffInYears(Carbon\Carbon::createFromDateString($profile->bday)) }}</b> &nbsp;&nbsp;&nbsp;
                    Sex: <b class="tele-type">{{ $profile->gender == 0 ? 'M' : 'F' }}</b>
                </span><br>
                <span class="pull-left">
                    Course: <b class="tele-type">{{ $course->find($profile->course)->name }}</b>
                </span>
                <span class="pull-right" style="padding-right: 70px;">
                    Major:
                </span><br>
                <span class="pull-left">
                    Name of Company: <b class="tele-type">{{ $company->name }}</b>
                </span><br>
                <span class="pull-left">
                    No. of Training Hours Required: <b class="tele-type">{{ $hour->hours }} hrs</b>
                </span>
                <span class="pull-right">
                    Total Hours Rendered: <b class="tele-type">{{ $profile->number_of_hours_rendered }} hrs</b>
                </span><br>
                <span class="pull-left">
                    Department/Division Assigned: <b class="tele-type">{{ $profile->technology_area }}</b>
                </span><br>
                <span class="pull-left">
                    Training Period: <b>{{ $period->count() != 0 ? $period->first()->date_started : 'N/A' }} to {{ $period->count() != 0 ? $period->first()->date_finished : 'N/A' }}</b>
                </span>
            </p>
            <p style="font-size: 12pt;text-align: right">
                _______________________ <br>
                Signature &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
            </p>
            <table border="solid" style="font-size: 12pt;" width="100%" class="docu-table">
                <thead>
                <tr class="text-center">
                    <td>CRITERIA</td>
                    <td>Maximum rating to be given</td>
                    <td>Rating</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1. Quality of work (thoroughness, accuracy neatness and effectiveness).</td>
                    <td class="text-center">20%</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        2. Quantity of work (able to complete work in allotted time).
                    </td>
                    <td class="text-center">20%</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        3. Dependability, Reliability and Resourcefulness (ability to work with minimum amount of supervision).
                    </td>
                    <td class="text-center">10%</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        4. Judgment ( sound decision, ability to identify  and evaluate pertinent factors).
                    </td>
                    <td class="text-center">10%</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        5. Cooperation ( works well with everyone, good teamwork).
                    </td>
                    <td class="text-center">10%</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        6. Attendance ( regular and proper observation of break periods).
                    </td>
                    <td class="text-center">10%</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        7. Personality (personal grooming and pleasant disposition).
                    </td>
                    <td class="text-center">10%</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        8. Safety (awareness of safety practices).
                    </td>
                    <td class="text-center">10%</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
            <p style="font-size: 12pt" class="text-right">
                Total Rating: _________
            </p>
            <p style="font-size: 12pt;">Strong Points:</p>
            <div class="pull-right" style="width: 100%;border-bottom: 1px solid"></div>
            <br>
            <p style="font-size: 12pt;">Points to be Improved:</p>
            <div class="pull-right" style="width: 100%;border-bottom: 1px solid"></div>
            <br>
            <p style="font-size: 12pt;">Recommendations:</p>
            <div class="pull-right" style="width: 100%;border-bottom: 1px solid"></div>
            <br>
            <p style="font-size: 12pt;">Evaluated by:</p><br>
            <span class="pull-left">
                _____________________ <br>
            &nbsp;&nbsp;&nbsp;Name & Signature
            </span>
            <span class="pull-right">
                 _____________________ <br>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Designation
            </span>
        </div>
    </div>
@stop