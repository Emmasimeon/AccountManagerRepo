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
                                    <div>GENERATE CASH WITHDRAWAL REPORT
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Select Start Date and End Date</h5>
                                        <form method="POST" action="/Cash/Withdrawal/History" class="">
                                            {{ csrf_field()}}
                                            
                                            <div class="form-row">
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="Start Date" class="">START DATE</label>
                                                        <input type="date" name="Start_Date" id="Start_Date" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="End Date" class="">END DATE</label>
                                                        <input type="date" name="End_Date" id="End_Date" class="form-control" required>
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