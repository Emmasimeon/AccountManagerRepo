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
                                        <i class="pe-7s-note2 text-success"></i>
                                    </div>
                                    <div>Add Payment/Expenditure Record</br>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Add a New Payment/Expenditures Record</h5>
                                        <form method="POST" action="/Save/Payment/Record" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="position-relative form-group">
                                                    <label for="Payment" class="">DATE OF TRANSACTION</label>
                                                    <input class="form-control" type="Date" name="date" required>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-3 mr-4">
                                                    <div class="position-relative form-group">
                                                        <label for="Payment" class="">Select Payment/Expenditure</label>
                                                        <select name="Payment" id="Payment" class="form-control" required>
                                                                <option></option>
                                                            @foreach ($Payments as $Payment )
                                                                <option value="{{$Payment->id}}">{{$Payment->expenditures}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                 <div class="col-md-2">
                                                        <div>Multiple Quantity</div><br/>
                                                        <div class="position-relative form-check form-check-inline"><label class="form-check-label"><input name="Multiple_Quantity" value="1" type="radio" class="form-check-input"> Yes</label></div>
                                                        <div class="position-relative form-check form-check-inline"><label class="form-check-label"><input name="Multiple_Quantity" value="0" type="radio" class="form-check-input"> No</label></div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                    <label for="Quantity" class="">Quantity</label>
                                                    <input name="Quantity" id="Quantity" placeholder="i.e Quantity 5" type="number" class="form-control" required></div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="position-relative form-group">
                                                    <label for="Amount" class="">Unit Cost/Amount (₦)</label>
                                                    <input name="Amount" id="Amount" placeholder="i.e Amount" type="number" class="form-control" required></div>
                                                </div>
   
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                    <label for="comment" class="">COMMENT:</label>
                                                    <textarea name="comment" id="comment" placeholder="Enter comment here" type="text" class="form-control" required></textarea></div>    
                                                </div>
                                            </div>

                                             
                                                
                                                <button class="mt-2 mb-2 btn btn-primary">Add</button>
                                            </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">PAYMENT ENTRIES FOR TODAY</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($Records) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>Payment/Expenditure:</th>
                                                <th>Quantity</th>
                                                <th>Unit Cost/Amount (₦):</th>
                                                <th>Total (₦):</th>
                                                <th>Comment:</th>
                                                <th>Entry By:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                            <tbody>
                                                
                                                        @foreach ($Records as $Records )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>
                                                                    @foreach ($Expenses as $Exp )
                                                                        @if ($Exp->id == $Records->payment)
                                                                                {{$Exp->expenditures}}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @if ($Records->quantity == 0)
                                                                <td>{{"N/A"}}</td>
                                                            @else
                                                                <td>{{$Records->quantity}}</td>
                                                            @endif

                                                                <td>₦ {{number_format($Records->amount ,2,".",",")}}</td>

                                                            @if ($Records->quantity < 1)
                                                                <td>₦ {{number_format(1 * $Records->amount,2,".",",")}}</td>
                                                            @else 
                                                                <td>₦ {{number_format($Records->quantity * $Records->amount,2,".",",")}}</td>
                                                            @endif
                                                            
                                                                <td>{{$Records->comment}}</td>
                                                                <td>{{$Records->user}}</td>
                                                                
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No available Payments/Expenditures Records to display!</h5>   
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