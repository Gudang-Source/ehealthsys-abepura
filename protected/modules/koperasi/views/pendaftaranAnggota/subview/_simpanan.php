<div class="span4">
	<div class="control-group ">
		<?php echo $form->labelEx($model, 'tglsimpanan', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php   // $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
				$this->widget('MyDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'tglsimpanan',
					'mode'=>'date',
					'options'=> array(
						//'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>

		</div>
	</div>
	<div class="control-group ">
		<?php echo $form->labelEx($model, 'jumlahsimpanan', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->hiddenField($model,'jenissimpanan_id'); ?>
				<?php echo $form->textField($model,'jumlahsimpanan', array('empty'=>'-- Pilih --', 'data-validate'=>'integer2ber', 'class'=>'form-control integer2','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('saldosimpanan'),)); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'keterangansimpanan', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'keterangansimpanan',array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('keterangansimpanan'),)); ?>
		</div>
	</div>
</div>
<div class="span4">
	<fieldset class="box2">
		<legend class="rim"><span class='judul'>
			<?php echo CHtml::checkBox('terima_kas', null, array('uncheckValue'=>null, 'class'=>'bkm')); ?> Terima Kas (BKM)
		</span></legend>
		<div class="row-fluid">
			<div class="control-group">
				<?php echo $form->labelEx($kasmasuk, 'jmlpembayaran', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk,'jmlpembayaran', array('readonly'=>true, 'disabled'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control integer2 bkm')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($kasmasuk, 'biayaadministrasi', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk,'biayaadministrasi', array('disabled'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control integer2 bkm')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($kasmasuk, 'biayamaterai', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk,'biayamaterai', array('disabled'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control integer2 bkm')); ?>
				</div>
			</div>
			<hr />
			<div class="control-group">
				<?php echo $form->labelEx($kasmasuk, 'uangditerima', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk,'uangditerima', array('disabled'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control integer2 bkm')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($kasmasuk, 'uangkembalian', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk,'uangkembalian', array('disabled'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control integer2 bkm')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
