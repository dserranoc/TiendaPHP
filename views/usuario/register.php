<h1>Registrarse</h1>

<?php
if (isset($_SESSION['register']) && $_SESSION['register'] == 'completed') : ?>
    <strong class="success-alert">¡Te has registrado correctamente!</strong>

<?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'failed') : ?>
    <strong class="error-alert">¡Ha habido un error al registrarte!</strong>
<?php endif; ?>
<?php Utils::deleteSession('register'); ?>

<form action="<?= base_url ?>usuario/save" method="post">
    <label for="name">Nombre: </label>
    <input type="text" name="name" required>
    <?php echo isset($_SESSION['errors']) ? Utils::showError($_SESSION['errors'], 'name') : ''; ?>

    <label for="surname">Apellidos: </label>
    <input type="text" name="surname" required>
    <?php echo isset($_SESSION['errors']) ? Utils::showError($_SESSION['errors'], 'surname') : ''; ?>

    <label for="email">Email: </label>
    <input type="text" name="email" required>
    <?php echo isset($_SESSION['errors']) ? Utils::showError($_SESSION['errors'], 'email') : ''; ?>

    <label for="password">Contraseña: </label>
    <input type="password" name="password" required>
    <?php echo isset($_SESSION['errors']) ? Utils::showError($_SESSION['errors'], 'password') : ''; ?>

    <input type="submit" value="Registrarse">
    <?php Utils::deleteSession('errors'); ?>
</form>