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
                                    <div>Update Student Status
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">{{$full_name = "{$Student[0]['surname']},  {$Student[0]['lastname']} {$Student[0]['middlename']}"}}</h5>
                                    <form method="POST" action="/Update_Student_Status/{{$Student[0]['SAN_id']}}">
                                        <table class="mb-0 table table-bordered">
                                                {{ csrf_field()}}
                                            <thead>
                                           
                                            <tr>
                                                <th>#</th>
                                                <th>SAN:</th>
                                                <th>Reg No:</th>
                                                <th>Student Name:</th>
                                                <th>Class:</th>
                                                <th>Sex:</th>
                                                <th>Accomodation:</th>
                                                <th>Payment Status:</th>
                                                <th>Student Status:</th>
                                                
                                            </tr>
                                            </thead>
                                            <?php $number = 1; ?>
                                            <?php $status; ?>
                                            <tbody>
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Student[0]['SAN_id']}}</td>
                                                                <td>{{$Student[0]['regno']}}</td>
                                                                <td>{{$full_name = "{$Student[0]['surname']}, {$Student[0]['lastname']} {$Student[0]['middlename']}"}}</td>
                                                                <td>{{$Student[0]['class_name']}}</td>
                                                                <td>{{$Student[0]['sex']}}</td>
                                                                <td>{{$Student[0]['accomodation']}}</td>
                                                                <td>{{$Student[0]['PaymentFeeStatus']}}</td>
                                                                <td>

                                                                    <div class="position-relative form-group">
                                                                        <select name="Status" id="Status" class="form-control">
                                                                            <option></option>
                                                                            <option value="101">Still in School</option>
                                                                            <option value="202">Transfered</option>
                                                                            <option value="303">Graduated</option>
                                                                        </select>
                                                                    </div>

                                                                {{-- @if ($Student[0]['status'] == "101") 
                                                                    {{$status = "Still in school"}}
                                                                @elseif($Student[0]['status'] == "202")
                                                                    {{$status = "Transfered"}};
                                                                @elseif ($Student[0]['status'] == "303")
                                                                    {{$status = "Graduated"}};
                                                                @endif --}}
                                                                </td>
                                                                
                                                             </tr>
                                                             
                                            </tbody>
                                            
                                            
                                        </table>
                                        <button action="submit" class="mt-2 btn btn-primary">Update Student</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    </div>    
                </div>        
@endsection