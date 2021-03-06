@extends('accountant.inc.layout')

@section('content')
    <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-page-title">
                        {{-- Include the message notification bar here --}}
                            @include('accountant.inc.messages')
                            {{-- End the include here --}}
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-study text-success">
                                        </i>
                                    </div>
                                    <div>STUDENT PAYMENT HISTORY
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                {{-- Student Details Card --}}

                                 <div class="main-card mb-3 card">
                                <div class="card-body"><h5 class="card-title">STUDENT DETAILS</h5>
                                    <div class="position-relative form-group">
                                        <div>
                                            <div class="custom-control">STUDENT NAME: <b>{{"{$Student[0]['surname']},  {$Student[0]['lastname']}  {$Student[0]['middlename']}"}}</b></div>
                                            <div class="custom-control">CURRENT CLASS: <b>{{$Student[0]['class']}}</b></div>
                                            <div class="custom-control">STUDENT SCHOOL ADMINISTRATIVE NO(SAN):  <b>{{$Student[0]['SAN_id']}}</b></div>
                                            <div class="custom-control">STUDENT REG NO:  <b>{{$Student[0]['regno']}}</b></div>
                                            <div class="custom-control">STUDENT ACCOMODATION STATUS:  <b>{{$Student[0]['accomodation']}}</b></div>
                                            <div class="custom-control">STUDENT FEE PAYMENT STATUS:  <b>{{$Student[0]['PaymentFeeStatus']}}</b></div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                {{-- Payment Details Card --}}

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Student Payment History</h5>
                                                
                                            @if ($TRX->isNotEmpty())
                                                @foreach ($TRX as $TRX)
                                                    <div class="form-row">
                                                        <table class="mb-0 table table-sm table-responsive">
                                                            <thead>
                                                                <tr class="table-info text-center">
                                                                    <th>DATE:</th>
                                                                    <th>TRANSACTION REF NO:</th>
                                                                    <th>SESSION:</th>
                                                                    <th>CLASS:</th>
                                                                    <th>TERM:</th>
                                                                    <th>PAYMENT DESCRIPTION:</th>    
                                                                    <th></th>
                                                                    <th>AMOUNT(₦)</th>

                                                                </tr>
                                                            </thead>
                                                            
                                                            
                                                            <tbody>
                                                                    <tr class="table-warning text-center">
                                                                        <td rowspan="2">{{date('d-m-Y', strtotime($TRX->created_at))}}</td>
                                                                        <td rowspan="2">{{$TRX->Trx_id}}</td>
                                                                        <td rowspan="2">
                                                                        @foreach ($TRX_SESSION as $SESSION)
                                                                                @if ($SESSION->id == $TRX->session)
                                                                                        {{$SESSION->sessions}}
                                                                                @endif
                                                                        @endforeach
                                                                        </td>
                                                                        <td rowspan="2">
                                                                        @foreach ($TRX_CLASS as $CLASS)
                                                                                @if ($CLASS->id == $TRX->class)
                                                                                        {{$CLASS->stu_class_name}}
                                                                                @endif
                                                                        @endforeach
                                                                        </td>
                                                                        <td rowspan="2">
                                                                        @foreach ($TRX_TERM as $TERM)
                                                                                @if ($TERM->id == $TRX->term)
                                                                                        {{$TERM->term}}
                                                                                @endif
                                                                        @endforeach
                                                                        </td>
                                                                        <td rowspan="2">
                                                                        @foreach ($PAYMENT as $PAY)
                                                                                @if ($PAY->id == $TRX->payment)
                                                                                        <b>{{$PAY->income_category}}</b>
                                                                                @endif
                                                                        @endforeach
                                                                        </td>
                                                                        <td><b>AMOUNT PAID (₦)</b></td>
                                                                        <td><b>{{number_format($TRX->amount_paid,2,".",",")}}</b></td>

                                                                    </tr>
                                                                    <tr class="table-primary text-center">
                                                                        
                                                                        <td><b>BALANCE (₦)</b></td>
                                                                        <td><b>{{number_format($TRX->balance,2,".",",")}}</b></td>
                                                                    </tr>
                                                                    <tr><td><td></tr>
                                                            </tbody>
                                                                
                                                        </table>     
                                                    </div>
                                                @endforeach
                                            @else
                                                {{"NO PAYMENT HISTORY FOUND!!!"}}  
                                            @endif
                                            
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection