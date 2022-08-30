<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading" align="center">
                <h3>{{$action->poll->question}}</h3>
                <span class="muted-text">Fecha de cierre: {{date('d-m-Y', strtotime($action->poll->ending_date))}}</span>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('vote') }}" id="poll-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($action->poll->options as $option)
                            <li class="list-group-item">
                                @if(Gate::allows('vote', $action->poll->id))
                                    <div class="radio">
                                      <label><h4><input type="radio" name="selected_option" value="{{$option->id}}">{{$option->proposal->title}}</h4></label>
                                    </div>
                                @else
                                    @if($action->poll->num_votes()==0)
                                        <h4>
                                            {{$option->proposal->title}}
                                            (0%)
                                        </h4>
                                        <div class="progress">
                                          <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"  style="width:0%">
                                          </div>
                                        </div>
                                    @else
                                        <h4>
                                            {{$option->proposal->title}}
                                            ({{ round(100*count($option->voters)/$action->poll->num_votes(), 2) }}%)
                                        </h4>
                                        <div class="progress">
                                          <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"  style="width: {{ 100*count($option->voters)/$action->poll->num_votes() }}%">    
                                          </div>
                                        </div>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if(Gate::allows('vote', $action->poll->id))
                    <div class="panel-footer text-center" name="footer_vote">
                        <button type="submit" name="btn_vote" class="btn btn-modern btn-lg">
                            Votar</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
