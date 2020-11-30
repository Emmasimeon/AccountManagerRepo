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
                                    <div>Payments/Expenditures Categories</br>
                                    <small>Payment or Expenditures Categories are those to which the school spend funds on i.e (Diesel, Government Tax, e.t.c)</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Add a New Payment/Expenditures</h5>
                                        <form method="POST" action="/Save_Expenditure" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-6 pr-4">
                                                    <div class="position-relative form-group"><label for="Expenditure" class="">Payment/Expenditures</label><input name="Expenditure" id="Expenditure" placeholder="i.e Diesel" type="text" class="form-control"></div>
                                                </div>

                                                <div class="col-md-4">
                                                        <div>Accountant Administered</div><br/>
                                                        <div class="position-relative form-check form-check-inline"><label class="form-check-label"><input name="access" value="1" type="radio" class="form-check-input"> Yes</label></div>
                                                        <div class="position-relative form-check form-check-inline"><label class="form-check-label"><input name="access" value="0" type="radio" class="form-check-input"> No</label></div>
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
                                    <div class="card-body"><h5 class="card-title">Registered Payments/Expenditures</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($Payments) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>Payment/Expenditure:</th>
                                                <th>Administered By:</th>
                                                <th>Actions:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                             <?php $Message; ?>
                                            <tbody>
                                                
                                                        @foreach ($Payments as $Payments )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Payments->expenditures}}</td>
                                                                <td>
                                                                    @if ($Payments->access == "1")
                                                                        {{$Message = "Accountant"}}
                                                                    @else
                                                                        {{$Message = "Any User"}} 
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($Payments->status == "0")
                                                                        <a class="btn btn-lg btn-primary" href="/Edit/Expenditure/{{$Payments->id}}">Edit  <i class="fa fa-edit"></i></a> 
                                                                        <a class="btn btn-lg btn-success" href="/Activate/Expenditure/{{$Payments->id}}">Activate  <i class="fa fa-check"></i></a>
                                                                    @else 
                                                                        <a class="btn btn-lg btn-primary" href="/Edit/Expenditure/{{$Payments->id}}">Edit  <i class="fa fa-edit"></i></a> 
                                                                        <a class="btn btn-lg btn-danger" href="/Deactivate/Expenditure/{{$Payments->id}}">Deactivate   <i class="fa fa-window-close"></i></a>
                                                                    @endif   
                                                                </td>
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No available Payments/Expenditures to display!</h5>   
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