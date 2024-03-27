<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            Nombre:
            {{ Form::text('name', $category->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"> Aceptar </button>
		<a href="{{ route('categories.index') }}" class="btn btn-default">Cancelar</a>
    </div>
</div>