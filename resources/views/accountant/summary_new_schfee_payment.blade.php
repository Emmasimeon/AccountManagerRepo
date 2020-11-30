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
                                    <div>
                                        School Fees Payment Summary
                                    </div>
                                </div>
                                </div>
                        </div>    

                        <div class="alert alert-danger text-center">
                           <h5><b>WARNING:</b> PLEASE DO NOT REFRESH THIS PAGE!!! AS THIS WOULD ALTER YOUR TRANSACTION RECORD!!!</h5>
                        </div>

                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                {{-- Student Details Card --}}

                                 <div class="main-card mb-3 card">
                                <div class="card-body"><h5 class="card-title">STUDENT DETAILS</h5>
                                    <div class="position-relative form-group">
                                        <div>
                                            <div class="custom-control">STUDENT NAME: <b>{{$full_name ="{$Student[0]['surname']}, {$Student[0]['lastname']} {$Student[0]['middlename']}"}}</b></div>
                                            <div class="custom-control">CURRENT CLASS: <b>{{$Student[0]['class_name']}}</b></div>
                                            <div class="custom-control">STUDENT SCHOOL ADMINISTRATIVE NO(SAN):  <b>{{$Student[0]['SAN_id']}}</b></div>
                                            <div class="custom-control">STUDENT REG NO:  <b>{{$Student[0]['regno']}}</b></div>
                                            <div class="custom-control">STUDENT ACCOMODATION STATUS:  <b>{{$Student[0]['accomodation']}}</b></div>
                                            <div class="custom-control">STUDENT FEE PAYMENT STATUS:  <b>{{$Student[0]['PaymentFeeStatus']}}</b></div>
                                            </br>
                                            <div class="custom-control">TRANSACTION REFERENCE NO: <b>{{$TRX[0]['Trx_id']}}</b></div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                {{-- Payment Details Card --}}

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Student School Fee Payment</h5>
                                        

                                            <div class="form-row">
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="session" class=""><b>Session:</b></label>
                                                            <input value="{{$TRX[0]['session']}}" type="text" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="class" class=""><b>Payment Class:</b><small>  Which class is this school fees meant for?</small></label>
                                                            <input value="{{$TRX_CLASS[0]['class']}}" type="text" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="term" class=""><b>Term:</b></label>
                                                            <input value="{{$TRX_TERM[0]['term_name']}}" type="text" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                            </div>
                                            

                                            <div class="form-row">
                                                <table class="mb-0 table table-bordered">
                                                    <thead>
                                                    @if (count($PaymentFields) > 0)
                                                        <tr>
                                                            <th>#</th>
                                                            <th>PAYMENT</th>
                                                            <th>AMOUNT PAID (₦)</th>
                                                            <th>DISCOUNT GIVEN (₦)</th>
                                                            <th>BALANCE (₦)</th>
                                                            <th>AMOUNT DUE (₦)</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <?php $number = 1; ?>
                                                    <tbody>
                                                                @foreach ($PaymentFields as $Field)
                                                                <tr>
                                                                    @if ($Field->Field_1 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_1[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_1_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_1_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_1_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_1_amount'] + $TRX_BALANCE[0]['Field_1_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_2 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_2[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_2_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_2_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_2_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_2_amount'] + $TRX_BALANCE[0]['Field_2_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_3 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_3[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_3_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_3_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_3_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_3_amount'] + $TRX_BALANCE[0]['Field_3_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_4 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_4[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_4_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_4_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_4_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_4_amount'] + $TRX_BALANCE[0]['Field_4_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_5 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_5[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_5_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_5_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_5_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_5_amount'] + $TRX_BALANCE[0]['Field_5_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_6 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_6[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_6_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_6_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_6_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_6_amount'] + $TRX_BALANCE[0]['Field_6_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_7 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_7[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_7_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_7_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_7_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_7_amount'] + $TRX_BALANCE[0]['Field_7_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_8 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_8[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_8_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_8_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_8_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_8_amount'] + $TRX_BALANCE[0]['Field_8_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_9 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_9[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_9_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_9_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_9_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_9_amount'] + $TRX_BALANCE[0]['Field_9_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_10 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_10[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_10_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_10_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_10_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_10_amount'] + $TRX_BALANCE[0]['Field_10_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_11 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_11[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_11_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_11_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_11_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_11_amount'] + $TRX_BALANCE[0]['Field_11_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_12 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_12[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_12_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_12_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_12_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_12_amount'] + $TRX_BALANCE[0]['Field_12_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_13 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_13[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_13_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_13_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_13_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_13_amount'] + $TRX_BALANCE[0]['Field_13_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_14 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_14[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_14_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_14_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_14_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_14_amount'] + $TRX_BALANCE[0]['Field_14_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($Field->Field_15 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_15[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_15_amount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['Field_15_discount'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['Field_15_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($TOTAL = $TRX[0]['Field_15_amount'] + $TRX_BALANCE[0]['Field_15_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach 
                                                        <tr>
                                                            <td></td>
                                                            <td><b>TOTAL</b></td>
                                                            <td>
                                                                <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['trx_total'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                            </td>
                                                            <td>
                                                                <div class="position-relative form-group"><input value="₦ {{number_format($TRX[0]['trx_dsc_total'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                            </td>
                                                            <td>  
                                                                <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['bal_total'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                            </td>
                                                            <td>  
                                                                <div class="position-relative form-group"><input value="₦ {{number_format($TRX_BALANCE[0]['trx_total_expected'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                        @else
                                                            <b>{{"NO PAYMENT SET! KINDLY ADD PAYMENTS"}}</b>
                                                        @endif
                                                </table>     
                                            </div>

                                                
                                        
                                    </div>
                                </div>

                                {{-- PAYMENT MODE CARD --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">School Fee Payment Mode:</h5>

                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group"><label for="mode" class="">PAYMENT MODE:</label>
                                                        <input value="{{$TRX_MODE[0]['modes']}}" type="text" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group"><label for="bank" class="">BANK:</label>
                                                        <input value="{{$TRX_BANK[0]['bank']}}" type="text" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <label for="comment" class="">COMMENT:</label>
                                                    <textarea name="comment" id="comment" placeholder="{{$TRX[0]['comment']}}" type="text" class="form-control" readonly></textarea></div>    
                                                </div>
                                                
                                            </div>
                                            
                                           @if (session('confirmed'))
                                                <a type="button" class="mt-2 btn btn-primary disabled" href="/Receipt/{{$Student[0]['SAN_id']}}/{{$TRX[0]['Trx_id']}}">STEP 1 -> Confirm Transaction</a>
                                                <a type="button" class="mt-2 btn btn-danger float-right" href="/dashboard" data-toggle="modal" data-target="#EndTransactionModal">STEP 2 -> Finalize Transaction</a>
                                            @else
                                                <a type="button" class="mt-2 btn btn-primary" href="/Receipt/{{$Student[0]['SAN_id']}}/{{$TRX[0]['Trx_id']}}">STEP 1 -> Confirm Transaction</a>
                                                <a type="button" class="mt-2 btn btn-danger float-right" href="/dashboard" data-toggle="modal" data-target="#EndTransactionModal">STEP 2 -> Finalize Transaction</a>
                                            @endif
                                        
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>

{{--  --}}
<!-- Modal -->
<div id="EndTransactionModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="EndTransactionModalTitle" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="EndTransactionModalTitle"><b>TRANSACTION PROCESSED</b></h5>
        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> --}}
      </div>
      <div class="modal-body">
        <p><i>TRANSACTION REFERENCE NO:</i> <b>{{$TRX[0]['Trx_id']}}</b></p>
        <p><i>STUDENT NAME:</i> <b>{{$full_name ="{$Student[0]['surname']}, {$Student[0]['middlename']} {$Student[0]['lastname']}"}}</b></p>
        <p><i>PAYMENT CLASS:</i>  <b>{{$TRX_CLASS[0]['class']}}</b></p>

        <p><b>NOTE: <i>KINDLY ENSURE TO QUOTE THE "TRANSACTION REFERENCE NUMBER" ON THE WRITTEN RECEIPT.</i></b></p>
        {{-- <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> --}}
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
        <a type="button" href="/dashboard" class="btn btn-primary">END TRANSACTION</a>
      </div>
    </div>
  </div>
</div>
{{--  --}}    
   
@endsection