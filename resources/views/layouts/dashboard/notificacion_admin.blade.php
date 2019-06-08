<li>
	<a href="">Traspasos por autorizar</a>
</li>
<li class="divider"></li>
@foreach($services_traspaso as $traspaso)
	<li><a href="{{asset(Auth::user()->rol.'/traspasos/'.$traspaso->id)}}">{{$traspaso->nombre}}({{$traspaso->fecha}})</a></li>
@endforeach