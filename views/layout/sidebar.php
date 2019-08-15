<aside id="sidebar">

    <div id="carrito" class="block-aside">
        <h3>Mi carrito</h3>

        <ul>
            <?php $stats = Utils::statsCarrito()?>
        <li><a href="<?= base_url ?>carrito/index">Productos (<?=$stats['count']?>)</a></li>
        <li><a href="<?= base_url ?>carrito/index">Precio total: <?=$stats['total']?>€</a></li>
        <li><a href="<?= base_url ?>carrito/index">Ver el carrito</a></li>
        </ul>
    </div>

    <div id="login" class="block-aside">
        <?php if (!isset($_SESSION['identity'])) : ?>
        <h3>Entrar a la web</h3>
        <form action="<?= base_url ?>usuario/login" method="post">
            <label for="email">Email:</label>
            <input type="text" name="email">
            <label for="password">Contraseña:</label>
            <input type="password" name="password">
            <input type="submit" value="Enviar">
        </form>
        <?php else : ?>
        <h3>¡Hola, <?= $_SESSION['identity']->nombre ?>!</h3>
        <?php endif; ?>
        <ul>
            <?php if (isset($_SESSION['identity'])) : ?>

            <li><a href="<?= base_url ?>pedido/mis_pedidos">Mis pedidos</a></li>
            <?php if (isset($_SESSION['admin'])) : ?>
            <li><a href="<?= base_url ?>categoria/index">Gestionar categorias</a></li>
            <li><a href="<?= base_url ?>producto/gestion">Gestionar productos</a></li>
            <li><a href="<?= base_url ?>pedido/gestion">Gestionar pedidos</a></li>
            <?php endif; ?>
            <li><a href="<?= base_url ?>usuario/logout">Cerrar sesión</a></li>
            <?php else : ?>
            <li><a href="<?= base_url ?>usuario/register">Regístrate aquí</a></li>
            <?php endif; ?>
        </ul>
		<br>
		<h3>Cuenta de administrador</h3>
		<p>Email: admin@admin.com</p><br>
		<p>Contraseña: admin</p>

    </div>
</aside>

<div id="main">