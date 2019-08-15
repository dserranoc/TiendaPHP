<?php if (isset($prod)) : ?>
<h1><?= $prod->nombre ?></h1>



<div class="product-detail">
    <div class="product-image">
        <?php if ($prod->imagen != null) : ?>
            <img src="<?= base_url ?>uploads/images/<?= $prod->imagen ?>" alt="<?= $prod->nombre ?>">
        <?php else : ?>
            <img src="<?= base_url ?>assets/img/camiseta.png" alt="camiseta-placeholder">
        <?php endif; ?>
    </div>
    <div class="product-data">
        <p class="product-description"><?= $prod->descripcion ?></p>
        <p class="product-price"><?= $prod->precio ?>€</p>
        <a href="<?= base_url?>carrito/add&id=<?=$prod->id?>" class="button">Comprar</a>
    </div>
</div>

<?php else : ?>
<h1>El producto no existe</h1>
<?php endif; ?>