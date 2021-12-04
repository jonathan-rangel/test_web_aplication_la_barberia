<h1 class="page-name">Crear una nueva reservación</h1>

<div class="bar">
    <p>Hola, <?php echo $name_last ?? ''; ?></p>

    <a class="boton" href="/logout">Cerrar sesión</a>
</div>

<div id="app">
    <nav class="tabs">
        <button class="current-tab" type="button" data-step='1'>Servicios</button>
        <button type="button" data-step='2'>Reservación</button>
        <button type="button" data-step='3'>Productos</button>
        <button type="button" data-step='4'>Resumen</button>
        <button type="button" data-step='5'>Comentarios</button>
    </nav>

    <div class="section" id="step-1">
        <h2>Servicios</h2>
        <p class="text-align">Elige tus servicios</p>
        <div id="services" class="list-services"></div>
    </div>
    <div class="section" id="step-2">
        <h2>Reservación</h2>
        <p class="text-align">Elige la fecha y la hora de tu reservación</p>

        <form action="" class="form">
            <div class="field">
                <label for="name">Nombre y apellido</label>
                <input type="text" id="name" placeholder="Tu nombre" disabled value="<?php echo $name_last;?>">
            </div>
            <div class="field">
                <label for="date">Fecha</label>
                <input type="date" id="date" min="<?php echo date ('Y-m-d'); ?>">
            </div>
            <div class="field">
                <label for="time">Hora</label>
                <input type="time" id="time">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <div class="section" id="step-3">
        <h2>Productos extra</h2>
        <p class="text-align">Elige algún producto para comprar</p>
        <div id="products" class="list-products"></div>
    </div>
    <div class="section content-sum" id="step-4">
        <h2>Resumen de la reservación</h2>
        <p class="text-align">Verifica que tus datos sean correctos</p>
    </div>
    <div class="section" id="step-5">
        <h2>Comentarios</h2>
        <p class="text-align">Nuestros comentarios</p>
    </div>

    <div class="pagination">
        <button id="previous" class="boton">&laquo; Atrás</button>
        <button id="next" class="boton">Siguiente &raquo;</button>
    </div>
</div>

<?php $script = "<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script src='build/js/app.js'></script>"; ?>