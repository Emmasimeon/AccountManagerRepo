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
                                    <div>View students
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
                                                
                                                @if (Auth::user()->user_category == 'Secretary' || Auth::user()->user_category == 'Director' )
                                                    <th>#</th>
                                                    <th>SAN:</th>
                                                    <th>Reg No:</th>
                                                    <th>Student Name:</th>
                                                    <th>Sex:</th>
                                                    <th>Student Status:</th>
                                                    <th>Accomodation:</th>
                                                @else
                                                    <th>#</th>
                                                    <th>SAN:</th>
                                                    <th>Reg No:</th>
                                                    <th>Student Name:</th>
                                                    <th>Sex:</th>
                                                    <th>Student Status:</th>
                                                    <th>Accomodation:</th>
                                                    <th>Edit Details:</th>
                                                    <th>Student Status:</th>
                                                @endif
                                                
                                            </tr>
                                            </thead>
                                            <?php $number = 1; ?>
                                            <?php $status; ?>
                                            <tbody>
                                                
                                                        @foreach ($Student as $Stu )
                                                            <tr>
                                                                @if (Auth::user()->user_category == 'Secretary' || Auth::user()->user_category == 'Director')
                                                                    <td>{{$number++}}</td>
                                                                    <td>{{$Stu->SAN_id}}</td>
                                                                    <td>{{$Stu->regno}}</td>
                                                                    <td>{{$full_name = "{$Stu->surname},  {$Stu->lastname} {$Stu->middlename}"}}</td>
                                                                    <td>{{$Stu->sex}}</td>
                                                                    <td>
                                                                    @if ($Stu->status == "101") 
                                                                        {{$status = "Still in school"}}
                                                                    @elseif($Stu->status == "202")
                                                                        {{$status = "Transfered"}}
                                                                    @elseif ($Stu->status == "303")
                                                                        {{$status = "Graduated"}}
                                                                    @endif
                                                                    </td>
                                                                    <td>{{$Stu->accomodation}}</td>
                                                                @else
                                                                    <td>{{$number++}}</td>
                                                                    <td>{{$Stu->SAN_id}}</td>
                                                                    <td>{{$Stu->regno}}</td>
                                                                    <td>{{$full_name = "{$Stu->surname},  {$Stu->lastname} {$Stu->middlename}"}}</td>
                                                                    <td>{{$Stu->sex}}</td>
                                                                    <td>
                                                                    @if ($Stu->status == "101") 
                                                                        {{$status = "Still in school"}}
                                                                    @elseif($Stu->status == "202")
                                                                        {{$status = "Transfered"}}
                                                                    @elseif ($Stu->status == "303")
                                                                        {{$status = "Graduated"}}
                                                                    @endif
                                                                    </td>
                                                                    <td>{{$Stu->accomodation}}</td>
                                                                    <td><a class="btn btn-info btn-sm" href="Update_Student/{{$Stu->SAN_id}}">Edit   <i class="fa fa-edit"></i></a></td>
                                                                    <td><a class="btn btn-info btn-sm" href="/Update_Status/{{$Stu->SAN_id}}">Update   <i class="fa fa-eraser"></i></a></td>
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