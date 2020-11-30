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
                                    <div>Update Student
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Update a Student Record</h5>
                                        <form method="POST" action="#" class="">
                                                {{ csrf_field()}}

                                            <div class="form-row">
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group"><label for="Stu_Reg_No" class="">Student Reg No</label><input name="Stu_Reg_No" id="Stu_Reg_No" placeholder="i.e BSS/19/232" type="text" class="form-control"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="position-relative form-group"><label for="Stu_Adm_NO" class="">Student Admin Number - (<small>leave blank - Auto Generated</small>)</label><input name="Stu_Adm_NO" id="Stu_Adm_NO" placeholder="i.e 253" type="text" class="form-control" disabled></div>
                                                    </div>
                                            </div>

                                            <div class="form-row">
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="Surname" class="">Surname</label><input name="Surname" id="Surname" placeholder="Bello" type="text" class="form-control"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="MiddleName" class="">Middle Name</label><input name="MiddleName" id="MiddleName" placeholder="Obi" type="text" class="form-control"></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="FirstName" class="">First Name</label><input name="FirstName" id="FirstName" placeholder="Uche" type="text" class="form-control"></div>
                                                    </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <div class="position-relative form-group"><label for="Sex" class="">Sex</label>
                                                        <select name="Sex" id="Sex" class="form-control">
                                                            <option></option>
                                                            <option value="M">Male</option>
                                                            <option Value="F">Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group"><label for="Stu_Class" class="">Class</label>
                                                        <select name="Stu_Class" id="Stu_Class" class="form-control">
                                                            <option></option>
                                                        @foreach ($stu_class as $class )
                                                            <option value="{{$class->id}}">{{$class->stu_class_name}}</option>
                                                        @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group"><label for="PaymentFeeStatus" class="">Student Payment Status</label>
                                                        <select name="PaymentFeeStatus" id="PaymentFeeStatus" class="form-control">
                                                            <option></option>
                                                            <option>Regular</option>
                                                            <option>Partial-Scholarship</option>
                                                            <option>Full-Scholarship</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group"><label for="Accomodation" class="">Accomodation Status</label>
                                                        <select name="Accomodation" id="Accomodation" class="form-control">
                                                            <option></option>
                                                            <option>Day</option>
                                                            <option>Boarding</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                                {{-- </div>
                                            </div> --}}
                                            <button class="mt-2 btn btn-primary">Add</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection