<?php 
        if(count($modTarif) > 0){
//        foreach ($modTarif as $i => $konsul) { 
    ?>
        <tr>
            <td><?php echo $modTarif->daftartindakan->daftartindakan_nama ?></td>
            <td>
                <?php echo MyFormatter::formatNumberForPrint($modTarif->harga_tariftindakan); ?>
                <?php echo CHtml::hiddenField('daftartindakan_id['.$modTarif->daftartindakan_id.']',$modTarif->daftartindakan_id,array('class'=>'daftartindakan_id')); ?>
            </td>
        </tr>
    <?php //} ?>
    <?php }else{ ?>
        <tr>
            <td colspan="3">Data tidak ditemukan.</td>
        </tr>
    <?php } ?>