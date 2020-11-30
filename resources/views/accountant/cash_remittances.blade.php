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
                                        <i class="pe-7s-paper-plane text-success">
                                        </i>
                                    </div>
                                    <div>CASH MOVEMENT - (REMITTANCES) 
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">

                        <form method="POST" action="/Cash/Remittances/Process" class="">
                        {{ csrf_field()}}
                        {{-- <input type="hidden" name="date" value="{{date("Y-m-d")}}" hidden> --}}

                        <div class="row">
                            <div class="col-6">
                                {{-- Remiting User details Details Card --}}
                                <div class="main-card mb-2 card">
                                    <div class="card-body"><h5 class="card-title">REMITTING USER DETAILS</h5>
                                        <div class="position-relative form-group">
                                            <div>
                                                <div class="custom-control">NAME: <b>{{strtoupper(Auth::user()->name)}}</b></div>
                                                <div class="custom-control">OFFICE: <b>{{strtoupper(Auth::user()->user_category)}}</b></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                            {{-- Receiving User details Details Card --}}
                                    <div class="main-card mb-2 card">
                                        <div class="card-body"><h5 class="card-title">RECEIVER DETAILS</h5>
                                            <div class="position-relative form-group">
                                                <div>
                                                    <div>
                                                        <div class="position-relative form-group"><label for="receiver" class="">SELECT RECEIVING USER:</label>
                                                            <select name="receiver" id="receiver" class="form-control" required>
                                                                <option></option>
                                                                @foreach ($Users as $User )
                                                                    <option>{{ $User->name }} ( {{ $User->user_category }} )</option>
                                                                @endforeach
                                                            </select>
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
                                            <div class="position-relative form-group"><label for="Date" class="">Date:</label>
                                                <input type="Date" name="date" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="position-relative form-group"><label for="amount" class="">AMOUNT (₦):</label>
                                                <input type="number" placeholder="Amount" name="amount" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="position-relative form-group"><label for="source" class="">SOURCE:</label>
                                                <input type="text" name="source" placeholder="i.e School Fees Paid" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="position-relative form-group">
                                            <label for="comment" class="">COMMENT:</label>
                                            <textarea name="comment" id="comment" placeholder="Enter comment here" type="text" class="form-control" required></textarea></div>    
                                        </div>
                                        
                                    </div>
                                    
                                    <button class="mt-2 btn btn-primary">Submit</button>
                                </form>
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
                                                <th>TRANSACTION DATE:</th>
                                                <th>DATE RECORDED:</th>
                                                <th>TRANSACTION BY:</th>
                                                <th>AMOUNT (₦):</th>
                                                <th>RECEIVED BY:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                             <?php $Message; ?>
                                            <tbody>
                                                
                                                        @foreach ($Last_Trx as $Trx )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{date('d-m-Y', strtotime($Trx->date))}}</td>
                                                                <td>{{date('d-m-Y', strtotime($Trx->created_at))}}</td>
                                                                <td><b>{{$Trx->user . ' ('.$Trx->office.')'}}</b></td>
                                                                <td>{{number_format($Trx->amount ,2,".",",")}}</td>
                                                                <td>{{$Trx->receiver }}</td>
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
                    </div>
@endsection