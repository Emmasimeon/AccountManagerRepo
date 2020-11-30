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
                                            <div class="custom-control">STUDENT NAME: <b>{{$full_name ="{$Student[0]['surname']}, {$Student[0]['lastname']} {$Student[0]['middlename']}"}}</b></div>
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
                                    <div class="card-body"><h5 class="card-title">Select Payment</h5>
                                        <form method="GET" action="/Other/Fees/Payment/{{$Student[0]['SAN_id']}}" class="">
                                                {{ csrf_field()}}

                                            
                                            

                                            <div class="form-row">
                                                <table class="mb-0 table table-bordered">
                                                    <tbody>
                                                                <tr>
                                                                    
                                                                        <td>
                                                                           <div class="position-relative form-group">
                                                                                    <select name="Payment" id="Payment" class="form-control">
                                                                                        <option></option>
                                                                                    @foreach ($Payments as $Pay )
                                                                                        <option value="{{$Pay->id}}">{{$Pay->income_category}}</option>
                                                                                    @endforeach
                                                                                    </select>
                                                                                </div>
                                                                        </td>
                                                                   
                                                                </tr>
                                                    </tbody>
                                                </table>     
                                            </div>

                                                
                                         <button class="mt-2 btn btn-primary">Proceed</button>
                                    </div>
                                </div>

                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection