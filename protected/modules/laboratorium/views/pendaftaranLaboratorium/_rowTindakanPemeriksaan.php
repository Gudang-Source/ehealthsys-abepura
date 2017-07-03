<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00;" <?php } ?> class="tindakan_lab">
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
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 integer2','style'=>'width:55px')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer2','style'=>'width:95px')); ?>
    </td>
</tr>
<tr class="tindakan_lab2">
	<td colspan="2">Dokter Pemeriksa : </td>
	<td colspan="4"><?php //echo CHtml::link("<i class=\"icon-plus-sign\" title=\"Klik untuk merubah dokter / perawat / bidan\"></i>", 'javascript:;', array('class'=>'btnAddDokter','onclick'=>'addDokterLengkap(this)', 'data-idx'=>$i)); ?>	
	<?php echo CHtml::activeDropDownList($modTindakan, '['.$i.'][ii]dokterpemeriksa1_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --','class'=>'inputFormTabel span3 tindakan_dokter')) ?>
	</td>
</tr>
<tr class="tindakan_lab3">
	<td colspan="2">Analis : </td>
	<td colspan="4">
	<?php echo CHtml::activeDropDownList($modTindakan, '['.$i.'][ii]perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --','class'=>'inputFormTabel span3 tindakan_analis')) ?>	
	</td>
</tr>

