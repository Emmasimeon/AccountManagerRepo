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
                                        <i class="pe-7s-user text-success">
                                        </i>
                                    </div>
                                    <div>Student School Fee Setup
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="main-card mb-3 card">
                                <div class="card-body"><h5 class="card-title">STUDENT DETAILS</h5>
                                    <div class="position-relative form-group">
                                        <div>
                                            <div class="custom-control">STUDENT NAME: <b>{{$full_name ="{$Student[0]['surname']}, {$Student[0]['lastname']}  {$Student[0]['middlename']}"}}</b></div>
                                            <div class="custom-control">CLASS: <b>{{$Student[0]['class_name']}}</b></div>
                                            <div class="custom-control">STUDENT SCHOOL ADMINISTRATIVE NO(SAN):  <b>{{$Student[0]['SAN_id']}}</b></div>
                                            <div class="custom-control">STUDENT REG NO:  <b>{{$Student[0]['regno']}}</b></div>
                                            <div class="custom-control">STUDENT ACCOMODATION STATUS:  <b>{{$Student[0]['accomodation']}}</b></div>
                                            <div class="custom-control">STUDENT FEE PAYMENT STATUS:  <b>{{$Student[0]['PaymentFeeStatus']}}</b></div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                </div>

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">SETUP - {{$full_name}} - SCHOOL FEES</h5>

                                    <form method="POST" action="/SaveSchoolFeesSetUp/{{$Student[0]['SAN_id']}}" class="">
                                            {{ csrf_field()}}

                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Payment:</th>
                                                <th>Apply to Student(Yes):</th>
                                                <th>Apply to Student(No):</th>
                                            </tr>
                                            </thead>
                                            <?php $number = 1; ?>
                                            <?php $status; ?>
                                            <tbody>
                                                @foreach ($SchFeeFields as $field )
                                                    <tr>
                                                        <td>{{$number++}}</td>
                                                        <td>{{$field->name}}</td>
                                                        <td><div class="position-relative form-check form-check-inline"><label class="form-check-label"><input name="Field{{$field->id}}" value="1" type="radio" class="form-check-input"> Yes</label></div></td>
                                                        <td><div class="position-relative form-check form-check-inline"><label class="form-check-label"><input name="Field{{$field->id}}" value="0" type="radio" class="form-check-input"> No</label></div></td>
                                                    </tr>
                                                @endforeach
                                                 
                                            </tbody>
                                        </table>
                                        <button class="mt-2 btn btn-primary">Apply to student</button>
                                    </form>

                                    </div>
                                </div>

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title"><i>{{$full_name}}</i> - IS GOING TO PAY THE FOLLOWING FOR @if ($Student[0]['sex'] == "M")
                                                                                                                                                {{"HIS"}}
                                                                                                                                            @else
                                                                                                                                                {{"HER"}}
                                                                                                                                            @endif 
                                                                                                                                            SCHOOL FEES:</h5>

                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($SchFee) > 0)
                                                <tr>
                                                    <th>#</th>
                                                    <th>Payment:</th>
                                                </tr>
                                                </thead>
                                                <?php $number = 1; ?>
                                                <?php $status; ?>
                                                <tbody>
                                                    @foreach ($SchFee as $SchFee)
                                                        <tr>
                                                            @if ($SchFee->Field_1 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_1[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_2 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_2[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_3 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_3[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_4 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_4[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_5 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_5[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_6 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_6[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_7 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_7[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_8 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_8[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_9 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_9[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_10 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_10[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_11 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_11[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_12 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_12[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_13 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_13[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_14 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_14[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            @if ($SchFee->Field_15 == 1)
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Name_15[0]['name']}}</td>
                                                            @endif
                                                        </tr>
                                                    @endforeach 
                                                </tbody>
                                            @else
                                                {{"NO PAYMENT SET! KINDLY ADD PAYMENTS"}}
                                            @endif
                                        </table>

                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    </div>    
                </div>        
@endsection