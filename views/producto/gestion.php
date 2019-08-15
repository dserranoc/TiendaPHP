<h1>Gestión de productos</h1>
<a href="<?= base_url ?>producto/crear" class="button button-small">Crear Producto</a>
<?php if (isset($_SESSION['producto']) && $_SESSION['producto'] == 'completed') : ?>
<strong class="success-alert">¡Se ha añadido el producto correctamente!</strong>
<?php elseif (isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed') : ?>
<strong class="error-alert">¡Error al añadir el producto! Comprueba que has introducido los datos correctamente</strong>
<?php endif; ?>

<?php Utils::deleteSession("producto") ?>

<?php if (isset($_SESSION['delete']) && $_SESSION['delete'] == 'completed') : ?>
<strong class="success-alert">¡Se ha eliminado el producto correctamente!</strong>
<?php elseif (isset($_SESSION['delete']) && $_SESSION['delete'] == 'failed') : ?>
<strong class="error-alert">¡Error al eliminar el producto! Vuelve a intentarlo</strong>
<?php endif; ?>

<?php Utils::deleteSession("delete") ?>
<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>PRECIO</th>
        <th>STOCK</th>
        <th>ACCIONES</th>

    </tr>
    <?php while ($prod = $productos->fetch_object()) : ?>

    <tr>
        <td><?= $prod->id ?></td>
        <td><?= $prod->nombre ?></td>
        <td><?= $prod->precio ?></td>
        <td><?= $prod->stock ?></td>
        <td>
            <a href="<?=base_url?>producto/editar&id=<?=$prod->id?>" class="button manage-button">Editar</a>
            <a href="<?=base_url?>producto/eliminar&id=<?=$prod->id?>" class="button manage-button button-red">Eliminar</a>
        </td>

    </tr>
    <?php endwhile; ?>
</table>