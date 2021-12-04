<h1 class="page-name">Servicios</h1>
<p class="page-details">Administrar los servicios</p>

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

<ul class="services">
    <?php foreach($services as $service) { ?>
        <li>
            <p>Nombre del servicio: <span><?php echo $service->name; ?></span></p>
            <p>Precio:<span>$<?php echo $service->price; ?></span></p>
            <p>Descripción: <span><?php echo $service->description; ?></span></p>

            <div class="actions">
                <a class="boton" href="/services/edit?id=<?php echo $service->id; ?>">Editar</a>

                <form action="/services/delete" method="POST">
                    <input type="hidden" name="id" value="<?php echo $service->id; ?>">

                    <input type="submit" value="Eliminar" class="button-delete">
                </form>
            </div>
        </li>
    <?php } ?> 
</ul>