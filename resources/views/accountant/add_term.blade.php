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
                                    <div class="card-body"><h5 class="card-title">Add a new Term</h5>
                                        <form method="POST" action="/Save_Term" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="term" class="">Term</label><input name="term" id="term" placeholder="i.e 1st Term 18/19" type="text" class="form-control"></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="start_date" class="">Term Start Date</label><input name="start_date" id="start_date" placeholder="i.e P.T.A Levy" type="date" class="form-control"></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="end_date" class="">Term End Date</label><input name="end_date" id="end_date" placeholder="i.e P.T.A Levy" type="date" class="form-control"></div>
                                                </div>
                                                
                                            </div>
                                            </div>
                                            <button class="mt-2 btn btn-primary">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Terms</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($sch_term) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>Term:</th>
                                                <th>Start Date:</th>
                                                <th>End Date:</th>
                                                <th>Adjust Date:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                            <tbody>
                                                
                                                        @foreach ($sch_term as $Terms )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Terms->term}}</td>
                                                                <td>{{$Terms->start_date}}</td>
                                                                <td>{{$Terms->end_date}}</td>
                                                                <td><a class="btn btn-info btn-sm" href="Update_Term/{{$Terms->id}}">Edit   <i class="fa fa-edit"></i></a></td>   
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No available Terms to display! Please add terms</h5>   
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