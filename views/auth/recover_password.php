<div class="container-title">
    <h1 class="page-name">Recuperar contraseña</h1>
    <p class="page-details">Escribe tu nueva contraseña para restablecerla</p>
</div>

<?php include_once __DIR__ . '/../templates/alerts.php';?>

<?php if($error) return; ?>

<form class="form" method="POST">
    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Nueva contraseña">
    </div>

    <div class="container-submit">
        <input type="submit" class="boton" value="Restablecer contraseña">
    </div>

    <div class="actions">
        <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
        <a href="/create_account">¿No tienes cuenta? Crea una</a>
    </div>
    
</form>
