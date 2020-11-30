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
                                    <div>GENERATE REPORT OF SCHOOL FEES CLEARED STUDENTS
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Select Class, Session and Term</h5>
                                        <form method="POST" action="/Cleared_Students/list" class="">
                                            {{ csrf_field()}}
                                            
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="Class" class="">Class</label>
                                                        <select name="Stu_Class" id="Stu_Class" class="form-control">
                                                            <option></option>
                                                        @foreach ($stu_class as $class )
                                                            <option value="{{$class->id}}">{{$class->stu_class_name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="Session" class="">Session</label>
                                                        <select name="Stu_Session" id="Stu_Session" class="form-control">
                                                            <option></option>
                                                        @foreach ($session as $session )
                                                            <option value="{{$session->id}}">{{$session->sessions}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="Term" class="">Term</label>
                                                        <select name="Stu_Term" id="Stu_Term" class="form-control">
                                                            <option></option>
                                                        @foreach ($term as $term )
                                                            <option value="{{$term->id}}">{{$term->term}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                                {{-- </div>
                                            </div> --}}
                                            <button class="mt-2 btn btn-primary">GENERATE REPORT</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection