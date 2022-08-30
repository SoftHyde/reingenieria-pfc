@if(Session::has('alert'))
	<div class="alert alert-success alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{{ Session::get('alert') }}
	</div>
@endif

@if(Session::has('status'))
	<div class="alert alert-info alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{{ Session::get('status') }}
	</div>
@endif