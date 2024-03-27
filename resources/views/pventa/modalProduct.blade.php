<div class="modal fade" id="modal-product">
	<div class="modal-dialog ">
		<div class="modal-content">
			<form id="formProduct">
				<div class="modal-header">
					<h4 class="modal-title">Producto</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					
					<input type="hidden" name="id" id="id">

                    <div class="form-group">
						<label for="doccant">Cantidad</label>
						<input type="number" onKeyPress="return enterCantidad(this, event)"  name="doccant" id="doccant" class="form-control">
					</div>
				
										
				</div>
				<div class="modal-footer justify-content-between">					
					<button type="button" id="formProductBtn" class="btn btn-primary">Guardar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>