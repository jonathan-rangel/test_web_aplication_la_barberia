<h1 class="page-name">Panel de administración</h1>

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

<h2>Buscar reservaciones</h2>

<div class="search">
    <form class="form">
        <div class="field">
            <label for="date">Fecha</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        </div>
    </form>
</div>

<?php
    if(count($reservations) === 0)
        echo '<h2>No hay reservaciones para este día</h2>';
?>

<div id="reservation-admin">
    <ul class="reservations">
        <?php
            $idRes = 0;
            foreach($reservations as $key => $reservation) {
                if($idRes !== $reservation->id) {
                    $total = 0;
        ?>
        <li>
            <p>ID: <span><?php echo $reservation->id; ?></span></p>
            <p>Hora: <span><?php echo $reservation->time; ?></span></p>
            <p>Nombre del cliente: <span><?php echo $reservation->client_name; ?></span></p>
            <p>Número de teléfono: <span><?php echo $reservation->phone_number; ?></span></p>
            <p>Correo electrónico: <span><?php echo $reservation->email; ?></span></p>
            <h3>Servicios</h3>
            <?php
            $idRes = $reservation->id;
                } 
                $total += $reservation->price;
            ?>
                <p class="service"><?php echo $reservation->service . ' ' . '$' . $reservation->price; ?></p>

                <?php
                    $current = $reservation->id;
                    $next = $reservations[$key + 1]->id ?? 0;

                    if(isLast($current, $next)) { ?>
                        <p class="total">Total a pagar: <span>$<?php echo $total; ?></span></p>

                        <form action="/api/delete" method="POST">
                            <input type="hidden" name="id" value="<?php echo $reservation->id; ?>">
                            <input type="submit" class="button-delete" value="Eliminar">
                        </form>
                <?php } 
                
                ?>
        <?php }; ?>
    </ul>

</div>

<?php
    $script = '<script src="build/js/searcher.js"></script>'
?>