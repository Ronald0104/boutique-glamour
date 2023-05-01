<?php $i=1; ?>
<?php foreach($categorias as $categoria) :?>
    <tr>
        <td><?php echo $i++ ?></td>
        <td><?php echo $categoria->nombre ?></td>
        <td><?php echo $categoria->prefijo_code ?></td>
        <td><?php echo ($categoria->Estado == 1) ? 'Activo' : 'Inactivo' ?></td>
        <td>
            <button type="button" id="btn-category-" class="btn btn-success btn-xs btn-category-edit-show" data-toggle="modal" data-target="#modal-category-edit2" data-categoria="<?php echo $categoria->categoriaId ?>"><i class="glyphicon glyphicon-edit"></i> Editar</button>
            <button type="button" id="btn-category-" class="btn btn-warning btn-xs btn-category-delete"><i class="glyphicon glyphicon-remove" data-categoria="<?php echo $categoria->categoriaId ?>"></i> Eliminar</button>
        </td>
    </tr>
<?php endforeach; ?>
