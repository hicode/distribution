@layout('layout')
@section('content')
<div>
@if ( $msg = Session::get('msg', false) )
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h5>{{ $msg }}</h5>
</div>
@endif
<h1> Hello World ! </h1>
</div>
@endsection