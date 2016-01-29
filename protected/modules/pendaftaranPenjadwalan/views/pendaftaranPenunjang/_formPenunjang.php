<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, '['.$i.']ruangan_id', array('readonly'=>true,'class'=>'span3')); ?>

<?php 
$kp = $model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id);
$peg = $model->getDokterItems($modPasienMasukPenunjang->ruangan_id);

if (count($kp) == 1) $modPasienMasukPenunjang->jeniskasuspenyakit_id = $kp[0]->jeniskasuspenyakit_id;
if (count($peg) == 1) $modPasienMasukPenunjang->pegawai_id = $peg[0]->pegawai_id;

echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']jeniskasuspenyakit_id', CHtml::listData($kp, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'['.$i.']kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcisPenunjang(".$i.");", 'class'=>'span3')); ?>
<?php  echo $form->hiddenField($modPasienMasukPenunjang,'['.$i.']kelaspelayanan_id'); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'['.$i.']pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'['.$i.']pegawai_id', CHtml::listData($peg, 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>



