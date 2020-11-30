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
                                        <i class="pe-7s-timer text-success">
                                        </i>
                                    </div>
                                    <div>School Terms
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Update term dates</h5>
                                        <form method="POST" action="/Save_Updated_Term/{{$Term[0]['id']}}" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="term" class="">Term</label><input name="term" id="term" value="{{$Term[0]['term']}}" type="text" class="form-control" disabled></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="start_date" class="">Term Start Date</label><input name="start_date" id="start_date" placeholder="i.e P.T.A Levy" type="date" class="form-control"></br>Current Set Date: <b>{{$Term[0]['start_date']}}</b></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="end_date" class="">Term End Date</label><input name="end_date" id="end_date" placeholder="i.e P.T.A Levy" type="date" class="form-control"></br>Current Set Date: <b>{{$Term[0]['end_date']}}</b></div>
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
                    </div>
@endsection