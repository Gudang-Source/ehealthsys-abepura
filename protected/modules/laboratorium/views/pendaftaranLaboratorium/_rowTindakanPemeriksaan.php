<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00;" <?php } ?>>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::hiddenField('rowDokter',0) ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? $modTindakan->getPemeriksaanLab()->pemeriksaanlab_nama : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
</tr>
<tr>
	<td colspan="6">Dokter Pemeriksa : <?php echo CHtml::link("<i class=\"icon-plus-sign\" title=\"Klik untuk merubah dokter / perawat / bidan\"></i>", 'javascript:;', array('id'=>'btnAddDokter_0','onclick'=>'addDokterLengkap(this,0)')); ?>	
	<?php echo CHtml::activeTextField($modTindakan, '[0]dokterpemeriksa1_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>	
	<?php echo CHtml::activeTextField($modTindakan, '[0]perawat_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>				
	<div id="tampilanDokterPemeriksa_0"></div>
	<div id="tampilanPerawat_0"></div>
		  
	</td>	
</tr>

