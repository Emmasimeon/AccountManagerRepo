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
                                        <i class="pe-7s-cash text-success">
                                        </i>
                                    </div>
                                    <div>Other Fees Payment
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
                                
                                {{-- Student Details Card --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Payment Session, Class and Term</h5>
                                        <form method="POST" action="/Other/Fees/Process/{{$Student[0]['SAN_id']}}" class="">
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
                                                        <div class="position-relative form-group"><label for="class" class=""><b>Payment Class:</b><small>  Which class is this payment meant for?</small></label>
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

                                {{-- Payment Details Card --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Payment Details</h5>
  
                                            <div class="form-row">
                                                    <div class="col-md-5">
                                                        <div class="position-relative form-group"><label for="session" class=""><b>PAYMENT:</b></label>
                                                            <input name="Payment" id="Payment" Value="{{$Payment[0]['id']}}" type="hidden">
                                                            <div class="position-relative form-group">
                                                                <input Value="{{$Payment[0]['income_category']}}" type="text" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="class" class=""><b>PAYMENT FEE:</b><small>  total amount expected for a student to pay</small></label>
                                                            <input name="Amount_Expected" id="Amount_Expected" Value="{{$Payment[0]['amount']}}" type="hidden">
                                                            <div class="position-relative form-group">
                                                                <input  value="₦ {{number_format($Payment[0]['amount'],2,".",",")}}" type="text" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-group"><label for="term" class=""><b>AMOUNT PAID:</b></label>
                                                            <div class="position-relative form-group">
                                                                <input name="Amount_Paid" id="Amount_Paid" placeholder="Amount" type="number" max="{{$Payment[0]['amount']}}" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            



                                                
                                        
                                    </div>
                                </div>

                                {{-- PAYMENT MODE CARD --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Payment Mode:</h5>

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
                                                    <textarea name="comment" id="comment" placeholder="Enter comment here i.e Teller No: 451874" type="text" class="form-control" required></textarea></div>    
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