<div class="container-title">
    <h1 class="page-name">Iniciar sesión</h1>
    <p class="page-details">Ingresa con tus datos</p>
</div>


<?php include_once __DIR__ . '/../templates/alerts.php';?>

<form class="form" method="POST" action="/login">
    <div class="field">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" placeholder="Tu correo electrónico" name="email" value="<?php echo s($auth->email);?>">
    </div>
    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Tu contraseña" name="password">
    </div>

    <div class="container-submit">
        <input class="boton" type="submit" value="Iniciar sesión">
    </div>
    
</form>

<div class="actions">
    <a href="/create_account">¿No tienes cuenta? Crea una</a>
    <a href="/forgot_password">¿Olvidaste tu contraseña?</a>
</div>