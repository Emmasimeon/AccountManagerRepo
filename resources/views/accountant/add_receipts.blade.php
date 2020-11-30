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
                                    <div>Receipts/Payment Categories</br>
                                    <small>Receipts are Payment Categories to which the school receive funds that are not directly related to school fees i.e (External Examination Fee, Graduation Fee, e.t.c)</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Add a new receipts/income head</h5>
                                        <form method="POST" action="/Save_Receipts" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-4 pr-2">
                                                    <div class="position-relative form-group"><label for="Receipts" class="">Receipts Name/Income Category</label><input name="Receipts" id="Receipts" placeholder="i.e P.T.A Levy" type="text" class="form-control" required></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group"><label for="Amount" class="">Amount(₦)</label><input name="Amount" id="Amount" placeholder="i.e 7500.00" type="number" class="form-control" required></div>
                                                </div>

                                                <div class="col-md-4">
                                                        <div class="position-relative form-group"><label for="Business" class="">Business/Department</label>
                                                            <select name="business" id="business" class="form-control" required>
                                                                <option></option>
                                                                <option value="BRIGHTER SCHOOL">BRIGHTER SCHOOL</option>
                                                                <option value="BRIGHTER WATER">BRIGHTER WATER</option>
                                                                <option value="BRIGHTER SHOP">BRIGHTER SHOP</option>
                                                                <option value="BRIGHTER SNACK SHOPS">BRIGHTER SNACK SHOPS</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                             
                                                
                                                <button class="mt-2 btn btn-primary">Add</button>
                                            </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Available Receipts</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($income_category) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>Receipts/Income Category:</th>
                                                <th>Amount Payable(₦):</th>
                                                <th>Business:</th>
                                                <th>Edit:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                             <?php $Message; ?>
                                            <tbody>
                                                
                                                        @foreach ($income_category as $Receipts )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Receipts->income_category}}</td>
                                                                <td>₦ {{number_format($Receipts->amount,2,".",",") }}</td>
                                                                <td>{{$Receipts->business}}</td>
                                                                <td>
                                                                    <a class="btn btn-primary" href="/Edit/Receipt/{{$Receipts->id}}">Edit   <i class="fa fa-pen-alt"></i></a>
                                                                </td> 
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No available Receipts to display! Please add receipts</h5>   
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