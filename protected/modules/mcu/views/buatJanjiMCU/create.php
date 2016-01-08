<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="white-container">
    <legend class="rim2">Buat Janji <b>Medical Check Up</b></legend>
    <?php echo $this->renderPartial('_form', array('modPasien'=>$modPasien,'modPPBuatJanjiMCU'=>$modPPBuatJanjiMCU
    )); ?>
</div>
