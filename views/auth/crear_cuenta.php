<div class="container-title">
    <h1 class="page-name">Crear cuenta</h1>
    <p class="page-details">Introduce tu información para crear una cuenta</p>
</div>


<?php include_once __DIR__ . '/../templates/alerts.php';?>


<form class="form" method="POST" action="/create_account">
    <p>Datos personales</p>
    <div class="field">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" placeholder="Tu nombre" value="<?php echo s($usuario->name);?>">
    </div>
    <div class="field">
        <label for="last_name">Apellido</label>
        <input type="text" id="last_name" name="last_name" placeholder="Tu apellido" value="<?php echo s($usuario->last_name);?>">
    </div>
    <div class="field">
        <label for="phone_number">Número de teléfono</label>
        <input type="tel" id="phone_number" name="phone_number" placeholder="Tu número de teléfono" value="<?php echo s($usuario->phone_number);?>">
    </div>
    <p>Datos de inicio</p>
    <div class="field">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" placeholder="Tu correo electrónico" value="<?php echo s($usuario->email);?>">
    </div>
    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Elige una contraseña">
    </div>

    <div class="container-submit">
        <input class="boton" type="submit" value="Crear cuenta">
    </div>

    <div class="actions">
        <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
        <a href="/forgot_password">¿Olvidaste tu contraseña?</a>
    </div>
</form>
