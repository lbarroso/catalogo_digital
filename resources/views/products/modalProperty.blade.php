<div class="modal fade" id="modal-property" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <input type="hidden" name="id" id="id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleProperty">Propiedades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form id="formProperty">
                            <div class="form-row">
                                <div class="form-group mb-2">
                                    <label for="name" class="col-form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="value" class="col-form-label">Valor</label>
                                    <input type="text" class="form-control" id="value" name="value">
                                </div>

                                <div class="form-group mx-sm-3 py-4">
                                    <label for="" class="col-form-label pt-3">&nbsp;</label>
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
                                    <th>Nombre</th>
                                    <th>Valor</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tableProperties">

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