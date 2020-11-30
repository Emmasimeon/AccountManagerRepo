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
                                        <i class="pe-7s-prev text-success">
                                        </i>
                                    </div>
                                    <div>Error Deduction
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                
                                
                                {{-- Error Deduction Form Card --}}

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Error Deduction</h5>
                                        <form method="POST" action="/Store/Error/Deduction" class="">
                                                {{ csrf_field()}}

                                            <div class="form-row pb-4">
                                                    <div class="col-5">
                                                        <div class="position-relative form-group">
                                                            <label for="Ref_Trx_id" class=""><b>TRANSACTION REFERENCE NO:</b></label>
                                                            <input name="Ref_Trx_id" id="Ref_Trx_id" placeholder="XXXXXXX" type="number" class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="position-relative form-group"><label for="trx_type" class=""><b>TRANSACTION TYPE:</b></label>
                                                            <select name="trx_type" id="trx_type" class="form-control" required>
                                                                <option></option>
                                                                <option value="0">School Fee Payment</option>
                                                                <option value="1">Other Fee Payment</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                            </div>
                                            <div class="form-row">
                                                    <div class="col-md-5">
                                                        <div class="position-relative form-group"><label for="session" class=""><b>SESSION:</b></label>
                                                        <select name="session" id="session" class="form-control" required>
                                                            <option></option>
                                                        @foreach ($session as $Sessions )
                                                            <option value="{{$Sessions->id}}">{{$Sessions->sessions}}</option>
                                                        @endforeach
                                                        </select>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-5">
                                                        <div class="position-relative form-group"><label for="term" class=""><b>TERM:</b></label>
                                                            <select name="term" id="term" class="form-control" required>
                                                                <option></option>
                                                            @foreach ($term as $Terms )
                                                                <option value="{{$Terms->id}}">{{$Terms->term}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                            </div>
                                            

                                            <div class="form-row">

                                                <div class="col-md-5">
                                                    <div class="position-relative form-group">
                                                    <label for="amount" class=""><b>AMOUNT:</b></label>
                                                    <input name="amount" id="amount" placeholder="Amount" type="number" class="form-control" required></div>    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <label for="comment" class=""><b>COMMENT/REASON FOR DEDUCTION:</b></label>
                                                    <textarea name="comment" id="comment" placeholder="Cashier inputed wrong value in excess 0f 90,000 Naira" type="text" class="form-control" required></textarea></div>    
                                                </div>
                                                
                                            </div>
                                        <button class="mt-2 btn btn-primary">Submit</button>
                                        </form>

                                                
                                        
                                    </div>
                                </div>

                                {{-- Deductions CARD --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">DEDUCTIONS:</h5>
                                            <table class="mb-0 table table-bordered">
                                            <?php $number = 1; ?>
                                                    <thead>
                                                    @if (count($Error) > 0)
                                                        <tr>
                                                            <th>#</th>
                                                            <th>TRX REF NO:</th>
                                                            <th>TRANSACTION TYPE:</th>
                                                            <th>SESSION:</th>
                                                            <th>TERM:</th>
                                                            <th>AMOUNT (₦):</th>
                                                            <th>COMMENT/REASON:</th>
                                                        </tr>
                                                        </thead>
                                                        
                                                        
                                                        <tbody>
                                                            @foreach ($Error as $Error )
                                                                <tr>
                                                                    <td>{{$number++}}</td>
                                                                    @if ($Error->transaction == '0')
                                                                        <td><a target="_blank" href="/Transaction/{{$Error->ref_trx_id}}">{{$Error->ref_trx_id}} </a></td>
                                                                        <td>SCHOOL FEES TRANSACTIONS</td>
                                                                    @else 
                                                                        <td><a target="_blank" href="/Other/Transaction/{{$Error->ref_trx_id}}">{{$Error->ref_trx_id}} </a></td>
                                                                        <td>OTHER PAYMENTS TRANSACTIONS</td>
                                                                    @endif
                                                                    @foreach ($session as $sessions )
                                                                        @if ($Error->session === $sessions->id)
                                                                          <td>{{$sessions->sessions}} </td> 
                                                                        @endif
                                                                    @endforeach

                                                                    @foreach ($term as $terms )
                                                                        @if ($Error->term === $terms->id)
                                                                          <td>{{$terms->term}} </td> 
                                                                        @endif
                                                                    @endforeach
                                                                      
                                                                    <td>₦ {{number_format($Error->amount ,2,".",",")}}</td>   
                                                                    <td>{{$Error->comment}}</td>   
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    @else
                                                        <h5>No Deductions found!</h5>  
                                                    @endif
                                                        
                                                </table>         
                                    </div>
                                </div>

                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection