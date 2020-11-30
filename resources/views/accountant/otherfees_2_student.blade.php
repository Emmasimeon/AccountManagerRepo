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
                                    <div>Initiate Other Fee Payment
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">List of all students in {{$Stu_Class[0]['stu_class_name']}}</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($Student) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>SAN:</th>
                                                <th>Reg No:</th>
                                                <th>Student Name:</th>
                                                <th>Sex:</th>
                                                <th>Payment Status:</th>
                                                 @if (Auth::user()->user_category == 'Accountant')
                                                    <th>Payment History:</th>
                                                @else
                                                    <th>New Payment:</th>
                                                    <th>Outstanding Payment:</th>
                                                    <th>Payment History:</th>
                                                @endif
                                                
                                            </tr>
                                            </thead>
                                            <?php $number = 1; ?>
                                            <?php $status; ?>
                                            <tbody>
                                                
                                                        @foreach ($Student as $Stu )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Stu->SAN_id}}</td>
                                                                <td>{{$Stu->regno}}</td>
                                                                <td>{{$full_name = "{$Stu->surname}, {$Stu->lastname} {$Stu->middlename}"}}</td>
                                                                <td>{{$Stu->sex}}</td>
                                                                <td>{{$Stu->PaymentFeeStatus}}</td>
                                                                 @if (Auth::user()->user_category == 'Accountant')
                                                                    <td><a class="btn btn-success btn-sm" href="/Other/Payment/History/{{$Stu->SAN_id}}">View History   <i class="fa fa-list"></i></a></td>
                                                                @else 
                                                                    <td><a class="btn btn-info btn-sm" href="/Other/Fees/Select/Payment/{{$Stu->SAN_id}}">Receive New Payment  <i class="fa fa-money-bill-wave"></i></a></td>
                                                                    <td><a class="btn btn-warning btn-sm" href="/Other/Fees/Select/Balance/{{$Stu->SAN_id}}">Outstanding Payment  <i class="fa fa-money-bill-wave"></i></a></td>
                                                                    <td><a class="btn btn-success btn-sm" href="/Other/Payment/History/{{$Stu->SAN_id}}">View History   <i class="fa fa-list"></i></a></td>
                                                                @endif
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h4 class="danger">No student in {{$Stu_Class[0]['stu_class_name']}} to display! </br> Kindly add students</h4>   
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    </div>    
                </div>        
@endsection