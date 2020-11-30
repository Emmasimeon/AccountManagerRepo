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
                                    <div>TOTAL RECEIPTS OF OTHER PAYMENTS PER SESSION
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Select Payment and Session</h5>
                                        <form method="POST" action="/Other/Fee/Total/Session/Transactions" class="">
                                            {{ csrf_field()}}
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="Payment" class="">Payments Category</label>
                                                        <select name="Payment" id="Payment" class="form-control">
                                                            <option></option>
                                                        @foreach ($Payments as $Pay )
                                                            <option value="{{$Pay->id}}">{{$Pay->income_category}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="Session" class="">Session</label>
                                                        <select name="Stu_Session" id="Stu_Session" class="form-control">
                                                            <option></option>
                                                        @foreach ($session as $session )
                                                            <option value="{{$session->id}}">{{$session->sessions}}</option>
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