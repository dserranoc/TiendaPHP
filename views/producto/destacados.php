<!-- CONTENIDO CENTRAL -->

<h1>Algunos de nuestros productos: </h1>

<?php while ($product = $productos->fetch_object()) : ?>

<div class="product">
    <a href="<?= base_url ?>producto/ver&id=<?= $product->id ?>">
        <?php if ($product->imagen != null) : ?>
        <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" alt="<?= $product->nombre ?>">
        <?php else : ?>
        <img src="<?= base_url ?>assets/img/camiseta.png" alt="camiseta-placeholder">
        <?php endif; ?>

        <h2><?= $product->nombre ?></h2></a>
    <p><?= $product->precio ?>€</p>
    <a href="<?= base_url?>carrito/add&id=<?=$product->id?>" class="button">Comprar</a>
</div>
<?php endwhile; ?>