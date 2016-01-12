<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]tariftindakan_id',array('class'=>'tariftindakan_id')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]jenistarif_id',array('class'=>'jenistarif_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]daftartindakan_id',array('class'=>'daftartindakan_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]komponentarif_id',array('class'=>'komponentarif_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]kelaspelayanan_id',array('class'=>'kelaspelayanan_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]perdatarif_id',array('class'=>'perdatarif_id required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]harga_tariftindakan',array('class'=>'harga_tariftindakan required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]persendiskon_tind',array('class'=>'persendiskon_tind required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]hargadiskon_tind',array('class'=>'hargadiskon_tind required')); ?>
        <?php echo CHtml::activeHiddenField($model,'[ii]persencyto_tind',array('class'=>'persencyto_tind required')); ?>        
    </td>
    <td>
        <span name="[ii][perdanama_sk]" id="perdanama_sk"><?php echo isset($model->perdatarif->perdanama_sk) ? $model->perdatarif->perdanama_sk : "" ?></span>
    </td>
    <td>
        <span name="[ii][jenistarif_nama]" id="jenistarif_nama"><?php echo isset($model->jenistarif->jenistarif_nama) ? $model->jenistarif->jenistarif_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][kelaspelayanan_nama]" id="kelaspelayanan_nama"><?php echo isset($model->kelaspelayanan->kelaspelayanan_nama) ? $model->kelaspelayanan->kelaspelayanan_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][daftartindakan_nama]" id="daftartindakan_nama"><?php echo isset($model->daftartindakan->daftartindakan_nama) ? $model->daftartindakan->daftartindakan_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][komponentarif_nama]" id="komponentarif_nama"><?php echo isset($model->komponentarif->komponentarif_nama) ? $model->komponentarif->komponentarif_nama : "" ?></span>
    </td>
    <td>
        <span name="[ii][harga_tariftindakan]" id="harga_tariftindakan"><?php echo isset($model->harga_tariftindakan) ? number_format($model->harga_tariftindakan) : 0 ?></span>
    </td>
    <td>
        <span name="[ii][persendiskon_tind]" id="persendiskon_tind"><?php echo isset($model->persendiskon_tind) ? $model->persendiskon_tind : "" ?></span>
    </td>
    <td>
        <span name="[ii][persencyto_tind]" id="persencyto_tind"><?php echo isset($model->persencyto_tind) ? $model->persencyto_tind: "" ?></span>
    </td>
    <td>
        <a onclick="hapus(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus tarif tindakan"><i class="icon-remove"></i></a>
    </td>
</tr>