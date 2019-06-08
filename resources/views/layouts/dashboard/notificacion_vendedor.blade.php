@if(count($services_traspaso) == 0)
    <li>
        <a href="">No hay ningun traspaso disponible</a>
    </li>
@else
    @foreach($services_traspaso as $traspaso)
        <li>
            <a href="{{asset(Auth::user()->rol.'/traspasos/'.$traspaso->id)}}">
                <i class="ti-share"></i> {{$traspaso->nombre}}({{$traspaso->productos}})({{$traspaso->fecha}})
            </a>
        </li>
    @endforeach
@endif