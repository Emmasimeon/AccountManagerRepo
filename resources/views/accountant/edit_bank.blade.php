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
                                        <i class="pe-7s-safe text-success">
                                        </i>
                                    </div>
                                    <div>Bank</br>
                                    <small>Add a Bank to which the school operates and funds are publicy paid into the account</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Add Bank</h5>
                                        <form method="POST" action="/Save_Bank/{{$Banks[0]['id']}}" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-8">
                                                    <div class="position-relative form-group"><label for="Mode" class="">Bank Name</label>
                                                        <input name="Bank" id="Bank" value="{{$Banks[0]['banks']}}" type="text" class="form-control" required>
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