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
                                        <i class="pe-7s-cash text-success">
                                        </i>
                                    </div>
                                    <div>{{$Receipts->name}}
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Setup {{$Receipts->name}} Amount</h5>
                                        <form method="POST" action="/Store_Amount/{{$Receipts->id}}" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="Class" class="">Class</label>
                                                        <select name="Stu_Class" id="Stu_Class" class="form-control">
                                                            <option></option>
                                                        @foreach ($stu_class as $class )
                                                            <option value="{{$class->id}}">{{$class->stu_class_name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="Amount" class="">Amount </label><input name="Amount" id="Amount" placeholder="0.0" type="number" class="form-control"></div>
                                                </div>
                                                
                                            </div>
                                            </div>
                                            <button class="mt-2 btn btn-primary">Add/Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Class and Amount Payable</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($ClassName) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>Class:</th>
                                                <th>(₦)Amount:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                            <tbody>
                                                
                                                        @foreach ($ClassName as $ClassName )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$ClassName->class_name}}</td>
                                                                <td>₦ {{number_format($ClassName->amount,2,".",",")}}</td>
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No class and amount added! Please add class and amount</h5>   
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
