<div class="modal fade" id="modal-discount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <input type="hidden" name="id" id="id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Descuentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="formDiscount">
                            <div class="form-row">
                                <div class="form-group mb-2">
                                    <label for="percentage" class="col-form-label">Porcentaje</label>
                                    <input type="number" class="form-control" id="percentage" name="percentage">
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="date_start" class="col-form-label">Fecha Inicio</label>
                                    <input type="date" class="form-control" id="date_start" name="date_start">
                                </div>

                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="date_end" class="col-form-label">Fecha final</label>
                                    <input type="date" class="form-control" id="date_end" name="date_end">
                                </div>

                                <div class="form-group mx-sm-3 py-4">
                                    <label for="fecha_final" class="col-form-label pt-3">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary">Guardar</button>

                                </div>



                            </div>

                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Porcentaje</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Final</th>
                                    <th>¿Esta Activo?</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableDiscount">

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>