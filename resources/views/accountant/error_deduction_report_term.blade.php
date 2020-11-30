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
                                    <div>ERROR DEDUCTIONS REPORT
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">

                                {{-- Deductions CARD --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">ERROR DEDUCTIONS REPORT FOR <u>{{$Term_Name[0]['term']}}</u> </h5>
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
                                                            <tr class="table-primary">
                                                                <td colspan="5"><b>TOTAL - SCHOOL FEES ERROR DEDUCTION:</b></td>
                                                                <td colspan="2"><b>₦ {{number_format($SchFee_Total ,2,".",",")}}</b></td>
                                                            </tr>
                                                            <tr class="table-info">
                                                                <td colspan="5"><b>TOTAL - OTHER PAYMENTS ERROR DEDUCTION:</b></td>
                                                                <td colspan="2"><b>₦ {{number_format($OthFee_Total ,2,".",",")}}</b></td>
                                                            </tr>
                                                            <tr class="table-dark">
                                                                <td colspan="5"><b>GRAND TOTAL:</b></td>
                                                                <td colspan="2"><b>₦ {{number_format($Grand_Total ,2,".",",")}}</b></td>
                                                            </tr>
                                                        </tbody>
                                                    @else
                                                        <h5>No Error Deductions found!</h5>  
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