<style>
.num , .num-des {
	text-align: right;
}
</style>
<div class="panel panel-primary col-sm-12">
	<?php echo $form->hiddenField($simpanan, 'keanggotaan_id'); ?>
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Simpanan</div>  
	</div>
	<?php 
	if (is_array($simpanan->jenissimpanan_id)) echo $this->renderPartial('subview/viewsimpanan/_simpananPokokWajib', array('simpanan'=>$simpanan, 'form'=>$form)); 
	else if ($simpanan->jenissimpanan_id == Params::ID_SIMPANAN_SUKARELA || $simpanan->jenissimpanan_id == Params::ID_SIMPANAN_JASA_SUKARELA) echo $this->renderPartial('subview/viewsimpanan/_simpananSukarela', array('simpanan'=>$simpanan, 'form'=>$form)); 
	else if ($simpanan->jenissimpanan_id == Params::ID_SIMPANAN_DEPOSITO) echo $this->renderPartial('subview/viewsimpanan/_simpananDeposito', array('simpanan'=>$simpanan, 'form'=>$form)); 
	?>
	<div class="panel-body col-sm-6">
		
		<div class="form-group">
			<?php echo $form->labelEx($simpanan, 'tglsimpanan', array('class'=>'control-label col-sm-4')); ?>
			<div class="col-sm-8">
			<div class="input-group">
			<?php 
				$this->widget('bootstrap.widgets.TbDateTimePicker', array(
					'model'=>$simpanan, 'attribute'=>'tglsimpanan', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				));
			?>
			<div class='input-group-addon' onclick="$('#SimpananT_tglsimpanan').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($simpanan, 'keterangansimpanan', array('class'=>'control-label col-sm-4')); ?>
			<div class="col-sm-8">
				<?php echo $form->textArea($simpanan,'keterangansimpanan',array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('keterangansimpanan'),)); ?>
			</div>
		</div>
	</div>
	<div class="panel-body col-sm-6">
		<div class="form-group">
			<?php echo $form->labelEx($kasmasuk, 'jmlpembayaran', array('class'=>'control-label col-sm-4')); ?>
			<div class="col-sm-8">
				<?php echo $form->textField($kasmasuk,'jmlpembayaran', array('readonly'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php //echo $form->labelEx($kasmasuk, 'biayaadministrasi', array('class'=>'control-label col-sm-4')); ?>
			<label class="control-label col-sm-4" for="PermohonanpinjamanT_biayaadministrasi">Biaya Administrasi<span class="required">*</span></label>
			<div class="col-sm-8">
				<?php echo $form->textField($kasmasuk,'biayaadministrasi', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($kasmasuk, 'biayamaterai', array('class'=>'control-label col-sm-4')); ?>
			<div class="col-sm-8">
				<?php echo $form->textField($kasmasuk,'biayamaterai', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<hr />
		<div class="form-group">
			<?php echo $form->labelEx($kasmasuk, 'uangditerima', array('class'=>'control-label col-sm-4')); ?>
			<div class="col-sm-8">
				<?php echo $form->textField($kasmasuk,'uangditerima', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($kasmasuk, 'uangkembalian', array('class'=>'control-label col-sm-4')); ?>
			<div class="col-sm-8">
				<?php echo $form->textField($kasmasuk,'uangkembalian', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
	</div>
</div>