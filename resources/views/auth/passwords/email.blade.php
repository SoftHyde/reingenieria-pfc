@extends('layout')

@section('content')
<div class="jumbotron">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">@lang('auth.reset_password')</div>
					<div class="panel-body">
						@include('partials/success')

						@include('partials/errors')

						<form class="form-horizontal" role="form" method="POST" action="/password/email">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">@lang('validation.attributes.email')</label>
								<div class="col-md-6">
									<input type="email" class="form-control" name="email" value="{{ old('email') }}">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										@lang('auth.send_password_link')
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection