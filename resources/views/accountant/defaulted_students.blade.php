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
                                        <i class="pe-7s-graph3 text-success">
                                        </i>
                                    </div>
                                    <div>REPORT ON <b>{{$Term[0]['term']}} - {{$Session[0]['sessions']}} Session</b> SCHOOL FEES DEFAULTING STUDENTS
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">List of all <i><b>({{$Class_Name[0]['stu_class_name']}})</b> school fees defaulting</i> students</h5>
                                        <table class="mb-0 table table-bordered">
                                        <?php $number = 1; ?>
                                            <thead>
                                             @if (count($C_STU) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>SAN:</th>
                                                <th>Reg No:</th>
                                                <th>Student Name:</th>
                                                <th>Payment Status:</th>
                                                <th>Amount Paid:</th>
                                                <th>Balance:</th>
                                                <th>Total to be Paid:</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($C_STU as $C_STU)
                                                    <tr>
                                                        <td>{{$number++}}</td>
                                                        <td>{{$C_STU->SAN_id}}</td>
                                                        <td>{{$C_STU->regno}}</td>
                                                        <td>{{$full_name ="{$C_STU->surname},  {$C_STU->lastname} {$C_STU->middlename}"}}</td>
                                                        <td>{{$C_STU->PaymentFeeStatus}}</td>
                                                        <td>₦ {{number_format($C_STU->trx_total_expected - $C_STU->bal_total,2,".",",")}}</td>
                                                        <td>₦ {{number_format($C_STU->bal_total,2,".",",")}}</td>
                                                         <td>₦ {{number_format($C_STU->trx_total_expected,2,".",",")}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <h4 class="danger">No Defaulting Students in {{$C_STU->stu_class_id}} to display!</h4>   
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