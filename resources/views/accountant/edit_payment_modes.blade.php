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
                                        <i class="pe-7s-menu text-success">
                                        </i>
                                    </div>
                                    <div>Payment Modes</br>
                                    <small>Add payment modes or medium to which parents could pay the school</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Update payment mode</h5>
                                        <form method="POST" action="/Save_Payment_Mode/{{$Mode[0]['id']}}" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-8">
                                                    <div class="position-relative form-group"><label for="Mode" class="">Mode of Payments</label>
                                                        <input name="Mode" id="Mode" Value="{{$Mode[0]['modes']}}" type="text" class="form-control">
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