<?php if (isset($alertas) && is_array($alertas)): ?>
    <?php foreach ($alertas as $key => $mensajes): ?>
        <?php foreach ($mensajes as $mensaje): ?>
            <div class="alerta <?php echo $key; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>