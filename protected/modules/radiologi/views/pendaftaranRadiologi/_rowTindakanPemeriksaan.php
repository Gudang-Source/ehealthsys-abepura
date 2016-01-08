<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00;" <?php } ?>>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanrad_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? $modTindakan->getPemeriksaanRad()->pemeriksaanrad_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]pemeriksaanrad_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
</tr>

