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
                                    <div>New School Fees Payment
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
                                            <div class="custom-control">STUDENT NAME: <b>{{$full_name ="{$Student[0]['surname']},  {$Student[0]['lastname']} {$Student[0]['middlename']}"}}</b></div>
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
                                        <form method="POST" action="/Process/{{$Student[0]['SAN_id']}}" class="">
                                                {{ csrf_field()}}

                                            <div class="form-row">
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="session" class=""><b>Session:</b></label>
                                                        <select name="session" id="session" class="form-control" required>
                                                            <option></option>
                                                        @foreach ($Sessions as $Sessions )
                                                            <option value="{{$Sessions->id}}">{{$Sessions->sessions}}</option>
                                                        @endforeach
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="class" class=""><b>Payment Class:</b><small>  Which class is this school fees meant for?</small></label>
                                                        <select name="class" id="class" class="form-control" required>
                                                            <option></option>
                                                        @foreach ($Stu_Class as $Stu_Class )
                                                            <option value="{{$Stu_Class->id}}">{{$Stu_Class->stu_class_name}}</option>
                                                        @endforeach
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="term" class=""><b>Term:</b></label>
                                                        <select name="term" id="term" class="form-control" required>
                                                            <option></option>
                                                        @foreach ($Terms as $Terms )
                                                            <option value="{{$Terms->id}}">{{$Terms->term}}</option>
                                                        @endforeach
                                                        </select>
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
                                                            <th>AMOUNT</th>
                                                            <th>DISCOUNT</th>
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
                                                                            <div class="position-relative form-group"><input name="Field_1_amount" id="Field_1_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_1_discount" id="Field_1_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_2 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_2[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_2_amount" id="Field_2_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_2_discount" id="Field_2_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_3 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_3[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_3_amount" id="Field_3_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_3_discount" id="Field_3_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_4 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_4[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_4_amount" id="Field_4_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_4_discount" id="Field_4_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_5 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_5[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_5_amount" id="Field_5_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_5_discount" id="Field_5_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_6 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_6[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_6_amount" id="Field_6_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_6_discount" id="Field_6_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_7 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_7[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_7_amount" id="Field_7_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_7_discount" id="Field_7_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_8 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_8[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_8_amount" id="Field_8_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_8_discount" id="Field_8_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_9 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_9[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_9_amount" id="Field_9_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_9_discount" id="Field_9_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_10 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_10[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_10_amount" id="Field_10_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_10_discount" id="Field_10_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_11 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_11[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_11_amount" id="Field_11_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_11_discount" id="Field_11_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_12 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_12[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_12_amount" id="Field_12_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_12_discount" id="Field_12_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_13 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_13[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_13_amount" id="Field_13_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_13_discount" id="Field_13_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_14 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_14[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_14_amount" id="Field_14_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_14_discount" id="Field_14_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    @if ($SchFee->Field_15 == 1)
                                                                        <td>{{$number++}}</td>
                                                                        <td>{{strtoupper($Name_15[0]['name'])}}</td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_15_amount" id="Field_15_amount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
                                                                        <td>  
                                                                            <div class="position-relative form-group"><input name="Field_15_discount" id="Field_15_discount" placeholder="Enter Amount" type="number" class="form-control"></div>
                                                                        </td>
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
                                                        <select name="mode" id="mode" class="form-control" required>
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
                                                    <textarea name="comment" id="comment" placeholder="Enter comment here" type="text" class="form-control" required></textarea></div>    
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