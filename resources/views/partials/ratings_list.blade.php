@foreach($work->ratings as $rating)
	<div class="card">
		<div class="card-block"> 
			@for($i=0; $i < $rating->stars; $i++)
				<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
			@endfor
			@for($i=$rating->stars; $i < 5; $i++)
				<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
			@endfor
			<br>
			<div class="proposal-comment">{!! nl2br($rating->comment) !!}</div>
			<hr>
			<div class="row">
				<div class="col col-md-3 col-md-offset-8" align="right">
					<a href="{{route('user', $rating->user->id)}}">{{ $rating->user->name }}</a>
					<br>
					<small>{{$rating->updated_at}}</small>
				</div>
				<div class="col col-md-1" align="center">
					<img class="img-circle img-xsmall" src="{{$rating->user->avatar}}">
				</div>
			</div>
		</div>
	</div>
	<br>
@endforeach
<hr>