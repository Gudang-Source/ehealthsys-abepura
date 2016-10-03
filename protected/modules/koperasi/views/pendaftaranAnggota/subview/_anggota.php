<div class="span4">
	<div class="control-group ">
		<?php echo $form->labelEx($model, 'tglkeanggotaaan', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php   // $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
				$this->widget('MyDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'tglkeanggotaaan',
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
		<?php echo $form->labelEx($model, 'nokeanggotaan', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'nokeanggotaan', array('readonly'=>true, 'class'=>'span3','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nokeanggotaan'),)); ?>
		</div>
	</div>
	<div class="control-group ">
		<?php echo $form->labelEx($model, 'nosuratpersetujuan', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'nosuratpersetujuan', array('class'=>'span3','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nosuratpersetujuan'),)); ?>
		</div>
	</div>
</div>
<div class="span4">
	<div class="control-group ">
		<?php echo $form->labelEx($model, 'tgldisetujui', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php   // $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
				$this->widget('MyDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'tgldisetujui',
					'mode'=>'date',
					'options'=> array(
						//'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>

		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($model, 'disetujuioleh', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php 
			$model->disetujuioleh = null;
			$this->widget('MyJuiAutoComplete',array(
				'model'=>$model, 
				'attribute'=>'disetujuioleh',
				'sourceUrl'=> $this->createUrl('AutocompletePegawai'),
				'options'=>array(
					'showAnim'=>'fold',
					'minLength' => 4,
					'focus'=> 'js:function( event, ui ) {
						return false;
					}',
					'select'=>'js:function( event, ui ) {
						return false;
					}',
				),
				'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3'),
				'tombolDialog'=>array('idDialog'=>'dialogPegawai', 'jsFunction'=>'tampilDialogPegawai(2, "#dialogPegawaiKoperasi"); return false;'),
			)); ?>
		</div>
	</div>
</div>
<div class="span4">
	<div class="control-group">
		<?php echo $form->labelEx($model, 'catatanpengurus', array('class'=>'control-label col-sm-4')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'catatanpengurus',array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('catatanpengurus'),)); ?>
		</div>
	</div>
</div>
