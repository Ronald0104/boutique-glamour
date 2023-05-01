<?php $i=1; ?>
<?php foreach($articulos as $articulo) :?>
    <tr>
        <td><?php echo $i++ ?></td>
        <td><?php echo $articulo->code ?></td>
        <td><?php echo $articulo->nombre ?></td>
        <td><?php echo $articulo->descripcion ?></td>
        <td><?php echo $articulo->categoriaId ?></td>
        <td><?php echo 0 ?></td>
        <td><?php echo 0 ?></td>
        <td><?php echo 0 ?></td>
        <td><?php echo ($articulo->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
        <td>
            <button type="button" id="btn-article-" class="btn btn-success btn-xs btn-article-edit-show" data-toggle="modal" data-target="#modal-article-edit2" data-articulo="<?php echo $articulo->articuloId ?>"><i class="glyphicon glyphicon-edit"></i> Editar</button>
            <button type="button" id="btn-article-2" class="btn btn-warning btn-xs btn-article-delete"><i class="glyphicon glyphicon-remove" data-articulo="<?php echo $articulo->articuloId ?>"></i> Eliminar</button>
        </td>
    </tr>
<?php endforeach; ?>
