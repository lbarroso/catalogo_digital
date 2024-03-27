<div class="modal fade" id="modal-images" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imagenes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="formImages">
                            <input type="hidden" name="product_id" id="images_product_id">
                            <label for="file">Imagen</label>
                            <input type="file" name="image" class="form-control-file mb-2" id="file">
                            <label for="is_first_image">¿Es Principal?</label>
                            <select name="is_first_image" id="is_first_image" class="form-control">
                                <option value="1">SI</option>
                                <option value="0">NO</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-3 mb-2">Guardar</button>
                        </form>

                    </div>
                </div>
                <div class="row" id="targetImages"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>