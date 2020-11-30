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
                                    <div>GENERATE PAYMENT VOUCHER
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Select Date</h5>
                                        <form method="POST" action="/Payment/Vouchers" class="">
                                            {{ csrf_field()}}
                                            
                                            <div class="form-row">
                                                
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="Date" class="">DATE</label>
                                                        <input type="date" name="Date" id="Date" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                               
                                            <button class="mt-2 btn btn-primary" target="_blank">GENERATE VOUCHER</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection