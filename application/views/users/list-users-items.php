<?php $i = 1;?>
<?php foreach($usuarios as $usuario) :?>
<tr>
    <td><?php echo $i++ ?></td>
    <td><?php echo $usuario->nombre . " " . $usuario->apellido_paterno ?></td>
    <td><?php echo $usuario->email ?></td>
    <td><?php echo $usuario->rol ?></td>
    <td><?php echo $usuario->usuario ?></td>
    <td><?php echo ($usuario->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
    <td>
        <button type="button" id="btn-user-" class="btn btn-success btn-xs btn-user-edit-show" data-toggle="modal" data-target="#modal-user-edit2" data-usuario="<?php echo $usuario->usuario_id ?>"><i class="glyphicon glyphicon-edit"></i> Editar</button>
        <button type="button" id="btn-user-" class="btn btn-warning btn-xs btn-user-delete"><i class="glyphicon glyphicon-remove" data-usuario-id="<?php echo $usuario->usuario_id ?>"></i> Eliminar</button>
    </td>
</tr>
<?php endforeach; ?>