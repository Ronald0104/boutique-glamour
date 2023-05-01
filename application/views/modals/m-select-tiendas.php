<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header bg-indigo-600">
            <h4 class="modal-title">Cambiar Tienda</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <ul class="list-group" id="list-tiendas">
                    <?php foreach ($tiendas as $key => $value) { ?>
                    <li class="list-group-item link-tienda"><a href="#" style="text-decoration: underline" data-tienda="<?php echo $value->id?>"><b><?php echo strtoupper($value->nombre) ?></b></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            <button type="button" class="btn btn-primary" id="btn-select-tienda">Seleccionar</button>
        </div>
    </div>
</div>