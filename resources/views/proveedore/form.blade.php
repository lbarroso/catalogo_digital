<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            Nombre de proveedor:
            {{ Form::text('prvrazon', $proveedore->prvrazon, ['class' => 'form-control' . ($errors->has('prvrazon') ? ' is-invalid' : ''), 'placeholder' => 'Prvrazon']) }}
            {!! $errors->first('prvrazon', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <div class="form-group">
            Teléfono:
            {{ Form::text('prvtel', $proveedore->prvtel, ['class' => 'form-control' . ($errors->has('prvtel') ? ' is-invalid' : ''), 'placeholder' => 'Prvtel']) }}
            {!! $errors->first('prvtel', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"> Aceptar </button>
		<a href="{{ route('proveedores.index') }}" class="btn btn-default"> Cancelar </a>
    </div>
</div>