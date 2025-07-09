
<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            Clave SIAC
            <input type="text" name="artcve" id="artcve" class="form-control" style="width:auto;">
            {!! $errors->first('artcve', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            <input type="hidden" name="almcnt" value="{{ Auth::user()->almcnt }}" >
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"> Agregar </button>
        <a href="{{ route('releases.index') }}" class="btn btn-default"> Cancelar </a>
    </div>
</div>
