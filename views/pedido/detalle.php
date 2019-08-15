<h1>Detalles del pedido</h1>

<?php if (isset($ped)) : ?>
<?php if(isset($_SESSION['admin'])) :?>
<h3>Cambiar estado del pedido</h3>
<form action="<?=base_url?>pedido/estado" method="post">
<input type="hidden" name="pedido_id" value="<?= $ped->id ?>">
    <select name="estado">
        <option value="confirmed" <?= $ped->estado == 'confirmed' ? 'selected' : ''?>>Pendiente</option>
        <option value="preparation" <?= $ped->estado == 'preparation' ? 'selected' : ''?>>En preparación</option>
        <option value="ready" <?= $ped->estado == 'ready' ? 'selected' : ''?>>Preparado para enviar</option>
        <option value="sent" <?= $ped->estado == 'sent' ? 'selected' : ''?>>Enviado</option>
    </select>
    <input type="submit" value="Cambiar estado">
</form>
<br>
<?php endif;?>
<h3>Dirección de envío:</h3>

<?= $ped->direccion ?><br>
<?= $ped->localidad ?><br>
<?= $ped->provincia ?><br><br>

<h3>Datos del pedido:</h3>
Numero de pedido: <?= $ped->id ?><br>
Estado del pedido: <td><?=Utils::showEstado($ped->estado) ?></td><br>
Total a pagar: <?= $ped->coste ?> €<br>
Productos:

<table>
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Unidades</th>
    </tr>
    <?php while ($producto = $productos_pedido->fetch_object()) : ?>


    <tr>
        <td><?php if ($producto->imagen != null) : ?>
            <img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" alt="<?= $producto->nombre ?>" class="img-carrito">
            <?php else : ?>
            <img src="<?= base_url ?>assets/img/camiseta.png" alt="camiseta-placeholder" class="img-carrito">
            <?php endif; ?>
        </td>
        <td><a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a></td>
        <td><?= $producto->precio ?></td>
        <td><?= $producto->unidades ?></td>
    </tr>


    <?php endwhile; ?>
</table>

<?php endif;?>