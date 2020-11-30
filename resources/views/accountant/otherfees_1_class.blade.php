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
                                    <div>New - Other Fee Payment
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Select Class</h5>
                                        <form method="POST" action="/Other/Fees/Students" class="">
                                            {{ csrf_field()}}
                                            
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group"><label for="Class" class="">Class</label>
                                                        <select name="Stu_Class" id="Stu_Class" class="form-control">
                                                            <option></option>
                                                        @foreach ($stu_class as $class )
                                                            <option value="{{$class->id}}">{{$class->stu_class_name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                                {{-- </div>
                                            </div> --}}
                                            <button class="mt-2 btn btn-primary">Fetch Students</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection