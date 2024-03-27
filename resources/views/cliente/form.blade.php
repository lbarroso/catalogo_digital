<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            Nombre del cliente: 
            {{ Form::text('ctenom', $cliente->ctenom, ['class' => 'form-control' . ($errors->has('ctenom') ? ' is-invalid' : ''), 'placeholder' => 'Ctenom']) }}
            {!! $errors->first('ctenom', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            Dirección:
            {{ Form::text('ctedir', $cliente->ctedir, ['class' => 'form-control' . ($errors->has('ctedir') ? ' is-invalid' : ''), 'placeholder' => 'Ctedir']) }}
            {!! $errors->first('ctedir', '<div class="invalid-feedback">:message</div>') !!}
        </div>
		
        <div class="form-group">
            Correo electrónico:
            {{ Form::text('cteemail', $cliente->cteemail, ['class' => 'form-control' . ($errors->has('cteemail') ? ' is-invalid' : ''), 'placeholder' => 'Cteemail']) }}
            {!! $errors->first('cteemail', '<div class="invalid-feedback">:message</div>') !!}
        </div>
		
        <div class="form-group">
            Teléfono:
            {{ Form::text('ctetel', $cliente->ctetel, ['class' => 'form-control' . ($errors->has('ctetel') ? ' is-invalid' : ''), 'placeholder' => 'Ctetel']) }}
            {!! $errors->first('ctetel', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"> Aceptar </button>
		<a class="btn btn-default" href="{{ route('clientes.index') }}">Cancelar</a>
    </div>
</div>