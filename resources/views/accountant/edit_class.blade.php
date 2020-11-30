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
                                        <i class="pe-7s-plugin text-success">
                                        </i>
                                    </div>
                                    <div>Update a class
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">New Class</h5>
                                        <form method="POST" action="/Update/Class/{{$class[0]['id']}}" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="Class_Name" class="">Class Name</label><input name="Class_Name" id="Class_Name" placeholder="{{$class[0]['stu_class_name']}}" type="text" class="form-control"></br><b>CURRENT VALUE: {{$class[0]['stu_class_name']}}</b></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="Class_Status" class="">Class Status</label><select name="Class_Status" id="Class_Status" class="form-control">
                                                        <option></option>
                                                        <option>Active School Class</option>
                                                        <option>Archival Classes</option>
                                                    </select>
                                                  </div>
                                                </div>
                                            </div>
                                            </div>
                                            <button class="mt-2 btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            
                            
                        </div>
                        </div>
                    </div>
@endsection