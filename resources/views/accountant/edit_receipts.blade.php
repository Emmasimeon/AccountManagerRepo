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
                                        <i class="pe-7s-ticket text-success">
                                        </i>
                                    </div>
                                    <div>Edit Receipts/Payment Categories</br>
                                    <small>Receipts are Payment Categories to which the school receive funds that are not directly related to school fees i.e (External Examination Fee, Graduation Fee, e.t.c)</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Edit a new receipts/income head</h5>
                                        <form method="POST" action="/Update/Receipt/{{$receipt[0]['id']}}" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-5 pr-4">
                                                    <div class="position-relative form-group"><label for="Receipts" class="">Receipts Name/Income Category</label>
                                                        <input name="Receipts" id="Receipts" Value="{{$receipt[0]['income_category']}}" type="text" class="form-control" required>
                                                    </div>
                                                </div>

                                                 <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="Amount" class="">Amount(₦)</label>
                                                        <input name="Amount" id="Amount" Value="{{$receipt[0]['amount']}}" type="number" class="form-control" required></div>
                                                </div>
                                            </div>

                                             
                                                
                                                <button class="mt-2 btn btn-primary">Update</button>
                                            </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                            
                        </div>
                        </div>
                    </div>
@endsection