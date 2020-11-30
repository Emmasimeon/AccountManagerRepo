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
                                            <div class="custom-control">TRANSACTION DATE: <b>{{date('d-m-Y', strtotime($TRX[0]['created_at']))}}</b></div>
                                            <hr>
                                            <div class="custom-control">STUDENT NAME: <b>{{$full_name ="{$STUDENT[0]['surname']}, {$STUDENT[0]['lastname']}  {$STUDENT[0]['middlename']}"}}</b></div>
                                            <div class="custom-control">TRANSACTION REFERENCE NO: <b>{{$TRX[0]['Trx_id']}}</b></div>
                                            <div class="custom-control">STUDENT SCHOOL ADMINISTRATIVE NO(SAN):  <b>{{$TRX[0]['SAN_id']}}</b></div>
                                            <div class="custom-control">PREVIOUS TRANSACTION REFERENCE NO:  
                                            @if (strlen($TRX[0]['Ref_Trx_id']) == 0)
                                                <b>{{"1ST TRANSACTION -> TRANSACTION STARTED HERE!"}}</b>
                                                @else 
                                                <b><a target="_blank" href="/Transaction/{{$TRX[0]['Ref_Trx_id']}}">{{$TRX[0]['Ref_Trx_id']}}</a></b>
                                            @endif
                                            </div>
                                            </br>
                                                <h5 class="card-title">PAYMENT PURPOSE:</h5>
                                            @if (strlen($TRX[0]['Ref_Trx_id']) >= 8)
                                                <b>{{"OUTSTANDING BALANCE PAYMENT"}}</b></br>Refer to PTR above for more details.
                                            @else 
                                                   
                                                   <div class="custom-control">PAYMENT FOR:  
                                                        @if (strlen($TRX[0]['Trx_id']) >= 8)
                                                                <b>{{"SCHOOL FEES"}}</b>
                                                            @else 
                                                                <b>{{"OTHER PAYMENT"}}</b>
                                                        @endif
                                                    </div>
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
                                                    @if (count($SchFee) > 0)
                                                        <tr>
                                                            <th>#</th>
                                                            <th>PAYMENT</th>
                                                            <th>AMOUNT PAID (₦)</th>
                                                            <th>DISCOUNT GIVEN (₦)</th>
                                                            <th>AMOUNT TO BALANCE (₦)</th>
                                                        </tr>
                                                    </thead>
                                                    
                                        
                                                    <tbody>
                                                                @foreach ($SchFee as $SchFee)
                                                                <tr>
                                                                    @if ($SchFee->Field_1 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_1[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_1_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_1_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_1_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_2 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_2[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_2_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_2_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_2_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_3 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_3[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_3_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_3_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_3_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_4 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_4[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_4_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_4_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_4_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_5 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_5[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_5_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_5_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_5_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_6 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_6[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_6_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_6_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_6_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_7 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_7[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_7_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_7_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_7_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_8 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_8[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_8_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_8_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_8_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_9 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_9[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_9_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_9_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_9_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_10 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_10[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_10_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_10_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_10_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_11 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_11[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_11_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_11_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_11_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_12 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_12[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_12_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_12_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_12_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_13 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_13[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_13_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_13_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_13_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_14 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_14[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_14_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_14_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_14_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_15 == "1")
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_15[0]['name'])}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_15_amount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX[0]['Field_15_discount'],2,".",",")}}</td>
                                                                        <td>₦ {{number_format($TRX_BALANCE[0]['Field_15_balance'],2,".",",")}}</td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach 
                                                                <tr>
                                                                <td></td>
                                                                <td><b>TOTAL</b></td>
                                                                <td><b>₦ {{number_format($TRX[0]['trx_total'],2,".",",")}}</b></td>
                                                                <td><b>₦ {{number_format($TRX[0]['trx_dsc_total'],2,".",",")}}</b></td>
                                                                <td><b>₦ {{number_format($TRX_BALANCE[0]['bal_total'],2,".",",")}}</b></td>
                                                                </tr>
                                                    
                                                    </tbody>
                                                        @else
                                                            <b>{{"NO PAYMENT SET! KINDLY ADD PAYMENTS"}}</b>
                                                        @endif
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