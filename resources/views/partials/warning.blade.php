@if(Session::has('warning'))
	<br>
	<div class="alert alert-danger alert-dismissable">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{{ Session::get('warning') }}
	</div>
@endif