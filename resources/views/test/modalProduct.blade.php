<div class="modal fade" id="modal-product">
	<div class="modal-dialog ">
		<div class="modal-content">
			<form id="formProduct" action="{{ route('productstore') }}" method="post">
				<div class="modal-header">
					<h4 class="modal-title">Nuevo Producto</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label for="artdesc">Nombre</label>
						<input type="text" name="artdesc" id="artdesc" class="form-control">
					</div>

					<div class="form-group">
						<label for="codbarras">SKU</label>
						<input type="text" name="codbarras" id="codbarras" class="form-control">
					</div>

                    <div class="form-group">
						<label for="artprventa">Precio</label>
						<input type="number" name="artprventa" id="artprventa" class="form-control">
					</div>

                    <div class="form-group">
						<label for="category_id">Categoria</label>
						<select name="category_id" id="category_id" class="form-control">
                            <option value="">Selecciona una opcion</option>
                        </select>
					</div>

                    <div class="form-group">
						<label for="artdetalle">Descripcion</label>
						<textarea name="artdetalle" id="artdetalle" class="form-control"></textarea>
					</div>
					
					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>