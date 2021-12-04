<div class="field">
    <label for="name">Nombre del servicio</label>
    <input type="text" id="name" name="name" placeholder="Agrega el nombre del servicio" value="<?php echo $service->name; ?>">
</div>
<div class="field">
    <label for="price">Precio del servicio</label>
    <input type="number" min="1" id="price" name="price" placeholder="Agrega el precio del servicio" value="<?php echo $service->price; ?>">
</div>
<div class="field">
    <label for="description">Descripción del servicio</label>
    <textarea rows="6" cols="50" placeholder="Agrega los detalles del servicio (Máximo de 300 caracteres)" id="description" name="description"><?php echo $service->description; ?></textarea>
</div>