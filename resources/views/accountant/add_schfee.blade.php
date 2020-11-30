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
                                    <div>Setup School Fees Fields</br>
                                    <small>This are payments fields applicable to student school fees i.e (Tuition Fee, PTA Levy, e.t.c)</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                        <div class="col-lg-12">
                                            {{-- Field Name Update Card --}}
                                            <div class="main-card mb-3 card">
                                                <div class="card-body"><h5 class="card-title">Update School Fees Field Name</h5>
                                                    <form method="POST" action="/School/Fee/Field/Update" class="">
                                                        {{ csrf_field()}}

                                                        <div class="form-row">
                                                            <div class="col-md-3">
                                                                    <div class="position-relative form-group"><label for="Field ID" class="">Field ID (#)</label>
                                                                        <select name="id" id="id" class="form-control" required>
                                                                            <option></option>
                                                                            @foreach ($Fields as $field )
                                                                                 <option>{{$field->id}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-7">
                                                                <div class="position-relative form-group"><label for="Label Name" class="">Label Name</label><input name="Label_Name" id="Label_Name" placeholder="i.e P.T.A Levy" type="text" class="form-control" required></div>
                                                            </div>
                                                            
                                                        </div>
                                                           <div class="text-center"> 
                                                                <button id="update" name="update" class="btn btn-primary">Update!</button> 
                                                            </div>  
                                                        </div>
                                                    </div>
                                                        
                                                    </form>
                                                </div>
                                            </div>

                                            {{-- School Fees Field List  --}}
                                            <div class="main-card mb-3 card">
                                                <div class="card-body"><h5 class="card-title">School Fees Fields</h5>
                                                    <table class="mb-0 table table-bordered">
                                                        <thead>
                                                        @if (count($Fields) > 0)
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fields:</th>
                                                            <th>Setup Amount::</th>
                                                            
                                                        </tr>
                                                        </thead>
                                                        <?php $number = 1; ?>
                                                        <?php $Message; ?>
                                                        <tbody>
                                                            
                                                                    @foreach ($Fields as $Field )
                                                                        <tr>
                                                                            <td>{{$number++}}</td>
                                                                                <td> <input name="Field_Name" id="Field_Name" Value="{{$Field->name}}" type="text"  required class="form-control" readonly></td>
                                                                                <td><a class="btn btn-lg btn-success" href="/Setup_Amount/{{$Field->id}}">Setup   <i class="fa fa-money-bill-alt"></i></a></td> 
                                                                        </tr>
                                                                    @endforeach
                                                            @else
                                                                <h5>No available Fields to display! Please contact the Developer!!!</h5>   
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