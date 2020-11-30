
@if (count($errors) > 0)
    @foreach ($errors->all() as $error )
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach    
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning">
        {{session('warning')}}
    </div>
@endif

@if (session('confirmed'))
    <div class="alert alert-success">
        {{session('confirmed')}}
    </div>
@endif

@if(session('confirmed'))
   <script type="text/javascript">
      $(document).ready(function() {
        $('#exampleModalCenter').modal();
      });
   </script>

    {{--  --}}
    <!-- Modal -->
    <div id="exampleModalCenter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Transaction Confirmed</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
    {{--  --}}    

@endif