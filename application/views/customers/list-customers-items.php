<?php $i = 1;?>
<?php foreach($clientes as $cliente) :?>
<tr tabindex="0">
    <td><?php echo $i++ ?></td>
    <td data-cliente="<?php echo $cliente->clienteId?>"><?php echo $cliente->nro_documento?></td>
    <td><?php echo $cliente->nombres . " " . $cliente->apellido_paterno ?></td>
    <td><?php echo $cliente->direccion ?></td>
    <td><?php echo $cliente->email ?></td>
    <td><?php echo $cliente->telefono ?></td>
    <td><?php echo $cliente->celular ?></td>
    <td class="center">
        <button type="button" id="btn-user-" class="btn btn-blue btn-xs btn-customer-edit-show" data-toggle="modal" data-target="#modal-customer-edit" data-cliente="<?php echo $cliente->clienteId ?>" data-cliente-nro="<?php echo $cliente->nro_documento ?>"><i class="fa fa-edit"></i></button>
        <button type="button" id="btn-" class="btn btn-danger btn-xs btn-user-delete"><i class="fa fa-trash-alt" data-cliente="<?php echo $cliente->clienteId ?>"></i></button>
    </td>
</tr>
<?php endforeach; ?>