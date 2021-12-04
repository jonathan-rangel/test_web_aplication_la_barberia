<h1 class="page-name">Agregar un servicio</h1>
<p class="page-details">Llena los datos para agregar un servicio</p>

<div class="bar">
    <p>Hola, <?php echo $name ?? ''; ?></p>

    <a class="boton" href="/logout">Cerrar sesión</a>
</div>

<div class="services-bar">
    <a class="boton" href="/admin">Ver reservaciones</a>
    <a class="boton" href="/services">Ver servicios</a>
    <a class="boton" href="/products">Ver productos</a>
    <a class="boton" href="/services/add">Agregar servicio</a>
    <a class="boton" href="/products/add">Agregar producto</a>
</div>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<form action="/services/add" method="POST" class="form">
    <?php include_once __DIR__ . '/form.php' ?>
    <div class="container-submit">
        <input type="submit" class="boton" value="Agregar servicio">
    </div>
    
</form>