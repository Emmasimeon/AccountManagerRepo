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
                                        <i class="pe-7s-piggy text-success">
                                        </i>
                                    </div>
                                    <div>CASH BANKING - (DEPOSITING MONEY TO BANK) 
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">

                        <form method="POST" action="/Cash/Banking/Process" class="">
                        {{ csrf_field()}}
                        <input type="hidden" name="date" value="{{date("Y-m-d")}}" hidden>

                        <div class="row">
                            <div class="col-4">
                                {{-- Remiting User details Details Card --}}
                                <div class="main-card mb-2 card">
                                    <div class="card-body"><h5 class="card-title">DEPOSITOR DETAILS</h5>
                                        <div class="position-relative form-group">
                                            <div>
                                                <div class="custom-control">NAME: <b>{{strtoupper(Auth::user()->name)}}</b></div>
                                                <div class="custom-control">OFFICE: <b>{{strtoupper(Auth::user()->user_category)}}</b></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-8">
                            {{-- Receiving User details Details Card --}}
                                    <div class="main-card mb-2 card">
                                        <div class="card-body"><h5 class="card-title">BANK DETAILS</h5>
                                            <div class="position-relative form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="position-relative form-group"><label for="Bank" class="">BANK:</label>
                                                            <select name="Bank" id="Bank" class="form-control" required>
                                                                <option></option>
                                                                @foreach ($Bank as $Bank )
                                                                <option>{{$Bank->banks}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="position-relative form-group"><label for="Teller" class="">TELLER NO:</label>
                                                            <input type="text" name="Teller" placeholder="i.e 457125" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                        </div>

                        {{-- TRANSACTION DETAILS CARD --}}
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">TRANSACTION DETAILS:</h5>

                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="position-relative form-group"><label for="Amount" class="">AMOUNT (₦):</label>
                                                <input type="number" name="Amount" placeholder="Amount" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="position-relative form-group"><label for="Source" class="">SOURCE:</label>
                                                <input type="text" name="Source" placeholder="i.e School Fees Paid" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                            <label for="comment" class="">COMMENT:</label>
                                            <textarea name="comment" id="comment" placeholder="Enter comment here" type="text" class="form-control"></textarea></div>    
                                        </div>
                                        
                                    </div>
                                    
                                    <button class="mt-2 btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title"><b>Latest Transactions</b></h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($Last_Trx) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>DATE:</th>
                                                <th>TRANSACTION BY:</th>
                                                <th>AMOUNT (₦):</th>
                                                <th>BANK:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                             <?php $Message; ?>
                                            <tbody>
                                                
                                                        @foreach ($Last_Trx as $Trx )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{date('d-m-Y', strtotime($Trx->created_at))}}</td>
                                                                <td><b>{{$Trx->user . ' ('.$Trx->office.')'}}</b></td>
                                                                <td>₦ {{number_format($Trx->amount ,2,".",",")}}</td>
                                                                <td>{{$Trx->bank }}</td>
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No recent Transactions!</h5>   
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

                    </div>
@endsection