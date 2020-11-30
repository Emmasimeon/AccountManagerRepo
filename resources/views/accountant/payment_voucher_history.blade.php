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
                                    <div>PAYMENT/PURCHASE VOUCHER HISTORY FOR A TERM</div>
                                </div>
                            </div>
                        </div>            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">PAYMENT/PURCHASE HISTORY FOR <i> <h4>{{$Term[0]['term']}}</h4> </i></h5>
                                        <table class="mb-0 table table-bordered">
                                        <?php $number = 1; ?>
                                            <thead>
                                             @if (count($Payments) > 0)
                                             <tr>
                                            <td colspan="8" class="text-center"><b><h4>{{strtoupper ($Details[0]['school_name'])}} </br> {{strtoupper ($Details[0]['school_address'])}} </br> PAYMENT/PURCHASE VOUCHERS</h4></b></td>
                                            </tr>

                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">DATE:</th>
                                                <th class="text-center">PAYMENT/PURCHASE DESCRIPTION:</th>
                                                <th class="text-center">QUANTITY:</th>
                                                <th class="text-center">UNIT PRICE/AMOUNT (₦):</th>
                                                <th class="text-center">TOTAL (₦):</th>
                                                <th class="text-center">SUBMITTED BY:</th>
                                                <th class="text-center">COMMENT:</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Payments as $Pay )
                                                    <tr>
                                                        <td>{{$number++}}</td>
                                                        <td class="text-center">{{$Pay->date}}</td>
                                                        <td class="text-center">
                                                            @foreach ($Expenses as $Exp )
                                                                @if ($Exp->id == $Pay->payment)
                                                                        {{$Exp->expenditures}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    @if ($Pay->quantity == 0)
                                                        <td>{{"N/A"}}</td>
                                                    @else
                                                        <td>{{$Pay->quantity}}</td>
                                                    @endif
                                                        <td class="text-center">₦ {{number_format($Pay->amount,2,".",",")}}</td>
                                                    @if ($Pay->quantity < 1)
                                                        <td>₦ {{number_format(1 * $Pay->amount,2,".",",")}}</td>
                                                    @else 
                                                        <td>₦ {{number_format($Pay->quantity * $Pay->amount,2,".",",")}}</td>
                                                    @endif
                                                        <td>{{$Pay->user}}</td>
                                                        <td>{{$Pay->comment}}</td>
                                                                
                                                    </tr>
                                                @endforeach
                                                    <tr class="table-info">
                                                        <td colspan="5"><b>TOTAL:</b></td>
                                                        <td colspan="3"><b>₦ {{number_format($Grand_Total,2,".",",")}}</b></td>
                                                    </tr>
                                            </tbody>
                                            
                                        </table>

                                        @else
                                            <h5>No Record Found!</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    </div>    
                </div>        
@endsection