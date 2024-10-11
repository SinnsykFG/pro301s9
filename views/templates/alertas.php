<?php
    foreach($alertas as $key => $alerta):
        foreach($mensaje as $mensaje):
?>
        <div class="alerta <?php echo $key; ?>">
            <?php echo $mensaje; ?>
        </div>
<?php
        endforeach;
    endforeach;
?>