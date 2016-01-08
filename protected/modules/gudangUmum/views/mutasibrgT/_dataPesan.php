<legend class="rim">Data Pemesanan Barang</legend>
<table>
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPesan, 'nopemesanan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modPesan, 'nopemesanan', array('readonly'=>true))
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPesan, 'tglpesanbarang', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modPesan, 'tglpesanbarang', array('readonly'=>true))
                    ?>
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo CHtml::activeLabel($modPesan, 'ruanganpemesan_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($modPesan, 'ruanganpemesan_id', array('readonly'=>true, 'value'=>$modPesan->ruanganpemesan->ruangan_nama))
                    ?>
                </div>
            </div>
        </td>
    </tr>
</table>