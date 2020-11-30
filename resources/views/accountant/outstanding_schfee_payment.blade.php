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
                                    <div>Outstanding Fees Payment
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
                                            <div class="custom-control">STUDENT NAME: <b>{{$full_name ="{$Student[0]['surname']},  {$Student[0]['lastname']}  {$Student[0]['middlename']}"}}</b></div>
                                            <div class="custom-control">CURRENT CLASS: <b>{{$Student[0]['class_name']}}</b></div>
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
                                    <div class="card-body"><h5 class="card-title">Student School Fee Payment</h5>
                                        <form method="POST" action="/Process/Balance/{{$Student[0]['SAN_id']}}" class="">
                                                {{ csrf_field()}}

                                            <div class="form-row">
                                                    <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <label for="Trx_Ref" class="">TRANSACTION REF ID:</br> <small> Enter the previous Transaction Ref ID to which this balance is paid for</small></label>
                                                    <input name="Trx_Ref" id="Trx_Ref" placeholder="i.e 11272499" type="text" class="form-control"></div>    
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="session" class=""><b>Session:</b></label>
                                                            <input type="hidden" id="session" name="session" value="{{$Selected_Session}}">
                                                            @foreach ($Sessions as $Session )
                                                                @if ($Session->id == $Selected_Session)
                                                                    <input value="{{$Session->sessions}}" type="text" class="form-control" readonly>
                                                                @endif
                                                            @endforeach
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="class" class=""><b>Payment Class:</b><small>  Which class is this school fees meant for?</small></label>
                                                            <input type="hidden" id="class" name="class" value="{{$Selected_Class}}">
                                                            @foreach ($Stu_Class as $Class )
                                                                @if ($Class->id == $Selected_Class)
                                                                    <input value="{{$Class->stu_class_name}}" type="text" class="form-control" readonly>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="term" class=""><b>Term:</b></label>
                                                            <input type="hidden" id="term" name="term" value="{{$Selected_Term}}">
                                                            @foreach ($Terms as $Term )
                                                                @if ($Term->id == $Selected_Term)
                                                                    <input value="{{$Term->term}}" type="text" class="form-control" readonly>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                            </div>

                                    </div>
                                </div>

                                {{-- PAYMENT FIELDS CARD --}}

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">STUDENT PAYMENT FIELDS</h5>

                                            <div class="form-row">
                                                <table class="mb-0 table table-bordered">
                                                    <thead>
                                                    @if (count($SchFee) > 0)
                                                        <tr>
                                                            <th>#</th>
                                                            <th>PAYMENT</th>
                                                            <th>PENDING BALANCE (₦)</th>
                                                            <th>AMOUNT PAID</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <?php $number = 1; ?>
                                                    <tbody>
                                                                @foreach ($SchFee as $SchFee)
                                                                <tr>
                                                                    @if ($SchFee->Field_1 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_1[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_1_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_1_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_1_amount" id="Field_1_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_1_amount" id="Field_1_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_1_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_2 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_2[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_2_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_2_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_2_amount" id="Field_2_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_2_amount" id="Field_2_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_2_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_3 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_3[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_3_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_3_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_3_amount" id="Field_3_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_3_amount" id="Field_3_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_3_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_4 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_4[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_4_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_4_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_4_amount" id="Field_4_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_4_amount" id="Field_4_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_4_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_5 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_5[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_5_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_5_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_5_amount" id="Field_5_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_5_amount" id="Field_5_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_5_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_6 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_6[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_6_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_6_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_6_amount" id="Field_6_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_6_amount" id="Field_6_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_6_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_7 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_7[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_7_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_7_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_7_amount" id="Field_7_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_7_amount" id="Field_7_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_7_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_8 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_8[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_8_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_8_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_8_amount" id="Field_8_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_8_amount" id="Field_8_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_8_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_9 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_9[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_9_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_9_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_9_amount" id="Field_9_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_9_amount" id="Field_9_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_9_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_10 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_10[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_10_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_10_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_10_amount" id="Field_10_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_10_amount" id="Field_10_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_10_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_11 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_11[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_11_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_11_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_11_amount" id="Field_11_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_11_amount" id="Field_11_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_11_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_12 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_12[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_12_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_12_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_12_amount" id="Field_12_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_12_amount" id="Field_12_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_12_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_13 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_13[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_13_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_13_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_13_amount" id="Field_13_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_13_amount" id="Field_13_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_13_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_14 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_14[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_14_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_14_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_14_amount" id="Field_14_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_14_amount" id="Field_14_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_14_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_15 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_15[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input value="₦ {{number_format($P_Balance[0]['Field_15_balance'],2,".",",")}}" type="text" class="form-control" readonly></div>
                                                                        </td>
                                                                        @if ($P_Balance[0]['Field_15_balance'] == 0)
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_15_amount" id="Field_15_amount" placeholder="₦ 0.00" type="text" class="form-control" readonly></div>
                                                                            </td>
                                                                        @else
                                                                            <td>  
                                                                                <div class="position-relative form-group"><input name="Field_15_amount" id="Field_15_amount" placeholder="Enter Amount" type="number" class="form-control" max="{{$P_Balance[0]['Field_15_balance']}}"></div>
                                                                            </td>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                            @endforeach 
                                                    
                                                    </tbody>
                                                        @else
                                                            <b>{{"NO PAYMENT FIELD/S SET! KINDLY ADD PAYMENTS"}}</b>
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
                                                        <select name="mode" id="mode" class="form-control">
                                                            <option></option>
                                                        @foreach ($Modes as $Modes )
                                                            <option value="{{$Modes->id}}">{{$Modes->modes}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group"><label for="bank" class="">BANK:</label>
                                                        <select name="bank" id="bank" class="form-control">
                                                            <option></option>
                                                        @foreach ($Banks as $Banks )
                                                            <option value="{{$Banks->id}}">{{$Banks->banks}}</option>
                                                        @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <label for="comment" class="">COMMENT:</label>
                                                    <textarea name="comment" id="comment" placeholder="Enter comment here" type="text" class="form-control"></textarea></div>    
                                                </div>
                                                
                                            </div>
                                            
                                            <button class="mt-2 btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection