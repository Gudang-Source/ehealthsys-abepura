<?php 
$idx = $simpanan->jenissimpanan_id; 
$jenis = JenissimpananM::model()->findByPk($idx);
if (count($jenis)>0){
    $nos = MyGenerator::generateNoSimpanan($jenis->jenissimpanan_singkatan);
}else{
    $nos = '' ;
}
?>
<div class="panel-body col-sm-12">
	<div class="form-group">
		<?php echo CHtml::label('No Simpanan', null, array('class'=>'control-label col-sm-2')); ?>
		<div class="col-sm-4">
			<?php echo $form->textField($simpanan,'nosimpanan['.$idx.']', array('readonly'=>true, 'value'=> $nos, 'empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('jumlahsimpanan'),)); ?>
		</div>
		<?php //echo $form->label($simpanan, 'jumlahsimpanan', array('class'=>'control-label col-sm-2')); ?>
		<label class="control-label col-sm-2" for="PermohonanpinjamanT_jumlahsimpanan">Jumlah Simpanan<span class="required">*</span></label>
		<div class="col-sm-2">
			<?php echo $form->textField($simpanan,'jumlahsimpanan['.$idx.']', array('kumis'=>$idx,'data-validate'=>'number', 'class'=>'form-control jumlahsimpanan num no-storage','maxlength'=>50, 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('jumlahsimpanan'),)); ?>
		</div>
		<?php echo $form->label($simpanan, 'Jasa (%)', array('class'=>'control-label col-sm-1')); ?>
		<div class="col-sm-1">
			<?php echo $form->textField($simpanan,'persenjasa_thn', array('data-validate'=>'number', 'class'=>'form-control num-des','maxlength'=>6,)); ?>
		</div>
	</div>
</div>