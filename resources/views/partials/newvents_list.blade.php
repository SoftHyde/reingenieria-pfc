<div class="alert" style="background-color: #eee;">
	<p>Noticias y Eventos</p>
	<br>
	<div class="autoplay">
		@foreach($action->newvents() as $newvent)
			<div class="row">
				@if($newvent->type == 'event')
					<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1" align="center">
						<!-- <a href="{{$newvent->link}}" target="_blank"> -->
						  	<div class="panel panel-primary">
						  		<div class="panel-heading" style="text-transform: uppercase;">
						  			{{DateTime::createFromFormat('m-Y', substr($newvent->date, 3))->format('F Y')}}
						  		</div>
						  		<div class="panel-body" style="color: #555;">
						  			<a href="{{$newvent->link}}" target="_blank">
						  				<h1 align="center">{{ substr($newvent->date, 0, 2) }}</h1>
						  				<h4>{{$newvent->title}}</h4>
						  			</a>
						  			@if(Gate::allows('admin_action', $action->admin_id))
									<div align="center">
										<a href="{{ route('newvent.edit', $newvent->id)}}" class="btn btn-default btn-block rect"><i class="fa fa-edit" aria-hidden="true"></i> Editar</a>

										<form role="form" method="POST" action="{{ route('newvent.delete')}}">
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<input type="hidden" name="newvent_id" value="{{ $newvent->id }}">
											<input type="hidden" name="_method" value="DELETE">
											<button type="submit" class="btn btn-danger btn-block rect"
											data-toggle="confirmation"
											data-popout="true"
											data-placement="top"
											data-btn-ok-label="Si"
									        data-btn-cancel-label="No"
									        data-title="¿Estás seguro de que deseas eliminarla?"
											>
											  <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
											</button>
										</form>
									</div>
							  		@endif
						  		</div>
						  	</div>
						<!-- </a> -->
					</div>
				@else
					<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
						<div class="card">
							<a href="{{$newvent->link}}" target="_blank">
						    	<div class="card-block">
						    		<span class="text-muted">{{$newvent->date}}</span>
						    		<h3 class="card-title">{{$newvent->title}}</h3>
						    	</div>
						    </a>
						    @if(Gate::allows('admin_action', $action->admin_id))
							<div align="center">
								<a href="{{ route('newvent.edit', $newvent->id)}}" class="btn btn-default btn-block rect"><i class="fa fa-edit" aria-hidden="true"></i> Editar</a>

								<form role="form" method="POST" action="{{ route('newvent.delete')}}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="newvent_id" value="{{ $newvent->id }}">
									<input type="hidden" name="_method" value="DELETE">
									<button type="submit" class="btn btn-danger btn-block rect"
									data-toggle="confirmation"
									data-popout="true"
									data-placement="top"
									data-btn-ok-label="Si"
							        data-btn-cancel-label="No"
							        data-title="¿Estás seguro de que deseas eliminarla?"
									>
									  <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar
									</button>
								</form>
							</div>
					  		@endif
						</div>
					</div>
					<br>
				@endif
			</div>
		@endforeach
	</div>
</div>