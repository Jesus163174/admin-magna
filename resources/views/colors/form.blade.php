<div class="form-group">
    <label for="">IMEI</label>
    <input type="text" required class="form-control" value="{{$color->imei}}" name="imei" placeholder="Ingresa el codigo de color">
</div>
<div class="form-group">
    <label for="">Color</label>
    <input placeholder="Ingresa el color" value="{{$color->color}}" type="text" class="form-control" name="color">
</div>
<div class="form-group">
    <label for="">Marca</label>
    <select class="form-control" name="marca_id" id="">
        @if($color->marca_id == null)
            <option value="">
                Selecciona una marca disponible
            </option>
        @else
            <option value="{{$color->marca->id}}"> {{$color->marca->nombre}}</option>
        @endif       
        @foreach($marcas as $marca)
            <option value="{{$marca->id}}">{{$marca->nombre}}</option>
        @endforeach
    </select>
</div>

<button class="btn btn-success ">{{$btn}}</button>