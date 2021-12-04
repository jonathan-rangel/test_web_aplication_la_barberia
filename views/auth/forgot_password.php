<div class="container-title">
    <h1 class="page-name">Olvidé mi contraseña</h1>
    <p class="page-details">Restablece tu contraseña escribiendo tu correo electrónico</p>
</div>


<?php include_once __DIR__ . '/../templates/alerts.php';?>

<form action="/forgot_password" class="form" method="POST">
    <div class="field">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" placeholder="Tu correo electrónico">
    </div>

    <div class="container-submit">
        <input type="submit" class="boton" value="Enviar correo">   
    </div>
</form>

<div class="actions">
        <a href="/create_account">¿No tienes cuenta? Crea una</a>
        <a href="/login">Iniciar sesión</a>
    </div>