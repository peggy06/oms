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
            <p class="text-center">
                <span style="font-size: 14pt">WAIVER</span>
            </p>
            <p style="font-size: 12pt; text-indent: 0.5in" class="text-justify">
                I, <ins class="tele-type">&nbsp;&nbsp;&nbsp;<b>{{ $user->name }}</b>&nbsp;&nbsp;&nbsp;</ins> of legal age, single/married and residing at ______________________________________________________ through the request of Bulacan State Unniversity and
                <ins class="tele-type">
                    &nbsp;&nbsp;&nbsp;
                    @if($company->count() != 0)
                        <b>{{ $company->name }}</b>
                    @endif
                    &nbsp;&nbsp;&nbsp;</ins> and in consideration thereof, hereby freely and voluntarily assumed and impose upon myself the following duties;
            </p>
            <br>
            <p style="font-size: 12pt; text-indent: 0.5in" class="text-justify">
                That I recognize the authority of <ins class="tele-type">
                    &nbsp;&nbsp;&nbsp;
                    @if($company->count() != 0)
                        <b>{{ $company->name }}</b>
                    @endif
                    &nbsp;&nbsp;&nbsp;</ins> whom I am placed and submit myself to rules and regulation that may be imposed in connection with my training;
            </p>
            <br>
            <p style="font-size: 12pt; text-indent: 0.5in" class="text-justify">
                Furthermore, I renounce and waive any/all claims against the Bulacan State University and <ins class="tele-type">&nbsp;&nbsp;&nbsp;
                    @if($company->count() != 0)
                        <b>{{ $company->name }}</b>
                    @endif
                    &nbsp;&nbsp;&nbsp;</ins> for any injury that I may sustain or any loss that I may suffer, personal, pecuniary, in the performance of duties or functions.
            </p>
            <br>
            <p style="font-size: 12pt; text-indent: 0.5in" class="text-justify">
                Signed at the City of San Jose del Monte, Bulacan this ______day of _______________ {{ Carbon\Carbon::now()->format('Y') }}.
            </p>
            <br>
            <p style="font-size: 12pt;text-align: right">
                _______________________ <br>
               Signature &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
            </p>
            <p style="font-size: 12pt">
                Witness: <br>
                _________________________ <br>
                _________________________
            </p><br>
            <p class="text-center">
                <span style="font-size: 14pt">CONFIRMATION</span>
            </p>
            <p style="font-size: 12pt; text-indent: 0.5in" class="text-justify">
                That I ______________________________________________ of legal age, Filipino and a resident of __________________________________ after duly sworn in accordance with the law hereby agree and state:
            </p>
            <p style="font-size: 12pt; text-indent: 0.5in">
                That I hereby confirm the above waiver appearing in this instrument.
            </p><br>
            <p style="font-size: 12pt;text-align: right">
                _______________________ <br>
                Signature of Parent/Guardian
            </p>
            <p style="font-size: 12pt;" class="text-justify">
                Subscribe and sworn before me this ____________ day of ________________________20___ affiant exhibiting his/her residence certificate no._________________ issued at _________________________ on  _____________________________________________.
            </p><br>
            <p style="font-size: 12pt;text-align: right">
                _______________________ <br>
                Administering Officer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </p>
        </div>
    </div>
@stop