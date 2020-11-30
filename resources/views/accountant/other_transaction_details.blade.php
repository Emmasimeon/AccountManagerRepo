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
                                        <i class="pe-7s-news-paper text-success">
                                        </i>
                                    </div>
                                    <div>Transaction Details
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                {{-- Student Details Card --}}

                                 <div class="main-card mb-3 card">
                                <div class="card-body"><h5 class="card-title">TRANSACTION DETAILS</h5>
                                    <div class="position-relative form-group">
                                        <div>
                                            <div class="custom-control">STUDENT NAME: <b>{{$full_name ="{$STUDENT[0]['surname']},  {$STUDENT[0]['lastname']} {$STUDENT[0]['middlename']}"}}</b></div>
                                            <div class="custom-control">TRANSACTION REFERENCE NO: <b>{{$TRX[0]['Trx_id']}}</b></div>
                                            <div class="custom-control">STUDENT SCHOOL ADMINISTRATIVE NO(SAN):  <b>{{$TRX[0]['SAN_id']}}</b></div>
                                            <div class="custom-control">PREVIOUS TRANSACTION REFERENCE NO:  
                                            @if (strlen($TRX[0]['Ref_Trx_id']) == 0)
                                                <b>{{"1ST TRANSACTION -> TRANSACTION STARTED HERE!"}}</b>
                                                @else 
                                                <b><a target="_blank" href="/Other/Transaction/{{$TRX[0]['Ref_Trx_id']}}">{{$TRX[0]['Ref_Trx_id']}}</a></b>
                                            @endif
                                            </div>
                                            </br>
                                                <h5 class="card-title">PAYMENT PURPOSE:</h5>
                                            @if (strlen($TRX[0]['Ref_Trx_id']) == 7)
                                                <b>{{"OUTSTANDING BALANCE PAYMENT"}}</b></br>Refer to PTR above for more details.
                                            @else 
                                                   
                                                   <div class="custom-control">PAYMENT FOR:  <b>{{$Payment_Name[0]['income_category']}}</b></div>

                                                {{-- PAYMENT CLASS WOULD APPEAR IF ITS A PARENT TRANSACTION, BUT WOUDN'T IF CONTINOUS TRANSACTION --}}
                                                        @foreach ($TRX_CLASS as $CLASS)
                                                            @if ($CLASS->id === $TRX[0]['stu_class_id'])
                                                                <div class="custom-control">PAYMENT CLASS:
                                                                    <b>{{$CLASS->stu_class_name}}</b>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                    {{-- PAYMENT SESSION WOULD APPEAR IF ITS PARENT TRANSACTION, BUT WOUDN'T IF CONTINOUS TRANSACTION --}}
                                                        @foreach ($TRX_SESSION as $SESSION)
                                                        @if ($SESSION->id === $TRX[0]['session'])
                                                                <div class="custom-control">PAYMENT SESSION:
                                                                <b>{{$SESSION->sessions}}</b>
                                                                </div>
                                                        @endif
                                                    @endforeach

                                                    {{-- PAYMENT SESSION WOULD APPEAR IF ITS PARENT TRANSACTION, BUT WOUDN'T IF CONTINOUS TRANSACTION --}}
                                                        @foreach ($TRX_TERM as $TERM)
                                                        @if ($TERM->id === $TRX[0]['term'])
                                                                <div class="custom-control">PAYMENT TERM:
                                                                <b>{{$TERM->term}}</b>
                                                                </div>
                                                        @endif
                                                    @endforeach
                                            @endif

                                            
                                            {{-- <div class="custom-control">STUDENT REG NO:  <b></b></div>
                                            <div class="custom-control">STUDENT ACCOMODATION STATUS:  <b></b></div>
                                            <div class="custom-control">STUDENT FEE PAYMENT STATUS:  <b></b></div> --}}
                                            
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                {{-- Payment Details Card --}}
                            </div>
                                            <div class="form-row">
                                                <table class="mb-0 table table-bordered">
                                                <?php $number = 1; ?>
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>PAYMENT</th>
                                                            <th>AMOUNT PAID (₦)</th>
                                                            <th>AMOUNT TO BALANCE (₦)</th>
                                                            <th>AMOUNT DUE (₦)</th>
                                                        </tr>
                                                    </thead>                                                   
                                                    <tbody>
                                                                 <tr>
                                                                    <td>{{$number++}}</td>
                                                                    <td><b>{{$Payment_Name[0]['income_category']}}</b></td>
                                                                    <td>₦ {{number_format($TRX[0]['amount_paid'],2,".",",")}}</td>
                                                                    <td>₦ {{number_format($TRX[0]['balance'],2,".",",")}}</td>
                                                                    <td>₦ {{number_format($TRX[0]['amount_expected'],2,".",",")}}</td>    
                                                                </tr>
                                                                <tr><td></td></tr>
                                                                    <tr>
                                                                    <td></td>
                                                                    <td><b>TOTAL</b></td>
                                                                    <td><b>₦ {{number_format($TRX[0]['amount_paid'],2,".",",")}}</b></td>
                                                                    <td><b>₦ {{number_format($TRX[0]['balance'],2,".",",")}}</b></td>
                                                                    </tr>
                                                    
                                                    </tbody>
                                                       
                                                </table>     
                                            </div>

                                                
                                        
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
   
@endsection