<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modTerima, 'nopenerimaan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modTerima, 'nopenerimaan', array('readonly'=>true))
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modTerima, 'tglterima', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modTerima, 'tglterima', array('readonly'=>true))
                    ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modTerima, 'sumberdana_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modTerima, 'sumberdana_id', array('readonly'=>true, 'value'=>$modTerima->sumberdana->sumberdana_nama))
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>