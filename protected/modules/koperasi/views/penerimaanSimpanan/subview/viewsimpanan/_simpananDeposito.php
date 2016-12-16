<?php 
$idx = $simpanan->jenissimpanan_id; 
$jenis = JenissimpananM::model()->findByPk($idx);
$nos = SimpananT::model()->generateNoSimpanan($jenis->jenissimpanan_singkatan);
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
			<?php echo $form->textField($simpanan,'jumlahsimpanan['.$idx.']', array('kumis'=>$idx,'data-validate'=>'number', 'class'=>'form-control num jumlahsimpanan no-storage','maxlength'=>50, 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('jumlahsimpanan'),)); ?>
		</div>
		<?php echo $form->label($simpanan, 'Jasa (%)', array('class'=>'control-label col-sm-1')); ?>
		<div class="col-sm-1">
			<?php echo $form->textField($simpanan,'persenjasa_thn', array('data-validate'=>'number', 'class'=>'form-control num-des','maxlength'=>3,)); ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-6"></div>
		<?php echo $form->label($simpanan, 'Jangka Waktu', array('class'=>'control-label col-sm-2')); ?>
		<div class="col-sm-1">
			<?php echo $form->textField($simpanan,'jangkawaktusimpanan', array('data-validate'=>'number', 'class'=>'form-control num','maxlength'=>3,)); ?>
		</div>
		<div class="col-sm-3">
			<?php echo $form->dropDownList($simpanan, 'satuan', Params::satuanWaktu(), array('empty'=>'-- Satuan --', 'class'=>'form-control')); ?>
		</div>
	</div>
</div>