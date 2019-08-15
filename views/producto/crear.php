<?php if (isset($edit) && isset($prod) && is_object(($prod))) : ?>
<h1>Editar producto "<?= $prod->nombre ?>"</h1>
<?php
    $url_action = base_url . "producto/save&id=" . $prod->id;
    ?>
<?php elseif (isset($edit) && !isset($prod)) : ?>
<?php header('Location:' . base_url . "producto/gestion"); ?>
<?php else : ?>
<h1>Crear nuevos productos</h1>
<?php
    $url_action = base_url . "producto/save";
    ?>
<?php endif; ?>
<div class="form_container">

    <form action="<?= $url_action ?>" method="post" enctype="multipart/form-data">
        <label for="name">Nombre:</label>
        <input type="text" name="name" value="<?= isset($prod) && is_object($prod) ? $prod->nombre : '' ?>">
        <label for="name">Descripción:</label>
        <textarea name="description"><?= isset($prod) && is_object($prod) ? $prod->descripcion : '' ?></textarea>
        <label for="name">Categoría:</label>
        <?php $categorias = Utils::showCategorias(); ?>
        <select name="category">
            <?php while ($cat = $categorias->fetch_object()) : ?>
            <option value="<?= $cat->id ?>" <?= isset($prod) && is_object($prod) && $cat->id == $prod->categoria_id ? 'selected' : '' ?>><?= $cat->nombre ?></option>
            <?php endwhile; ?>
        </select>
        <label for="name">Precio:</label>
        <input type="text" name="price" value="<?= isset($prod) && is_object($prod) ? $prod->precio : '' ?>">
        <label for="name">Stock:</label>
        <input type="number" name="stock" value="<?= isset($prod) && is_object($prod) ? $prod->stock : '' ?>">
        <label for="name">Oferta:</label>
        <input type="text" name="offer" value="<?= isset($prod) && is_object($prod) ? $prod->oferta : '' ?>">
        <label for="name">Imagen:</label>
        <?php if (isset($prod) && is_object($prod) && !empty($prod->imagen)) : ?>
        <img class="thumbnail" src="<?= base_url ?>uploads/images/<?= $prod->imagen ?>" alt="">
        <?php endif; ?>
        <input type="file" name="image">


        <input type="submit" value="Enviar">


    </form>
</div>