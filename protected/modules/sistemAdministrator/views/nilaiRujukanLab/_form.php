<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sanilairujukan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span4">
			<?php echo $form->dropDownListRow($model,'kelkumurhasillab_id',CHtml::listData(KelkumurhasillabM::model()->findAll(array('order'=>'kelkumurhasillab_urutan'),'kelkumurhasillab_aktif = true'),'kelkumurhasillab_id','kelkumurhasillabnama'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->dropDownListRow($model,'nilairujukan_jeniskelamin',LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'kelompokdet',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'namapemeriksaandet',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'nilairujukan_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($model,'nilairujukan_min',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'nilairujukan_max',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php //echo $form->textFieldRow($model,'nilairujukan_satuan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->dropDownListRow($model, 'nilairujukan_satuan',LookupM::getItems('satuanhasillab'), array('empty'=>'--Pilih--')); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'nilairujukan_metode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
			<?php echo $form->textAreaRow($model,'nilairujukan_keterangan',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->checkBoxRow($model,'nilairujukan_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Nilai Rujukan (Referensi) Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Nilai Rujukan (Referensi)',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
		$content = $this->renderPartial($this->path_view.'tips/tipsCreate',array(),true);
		$this->widget('UserTips',array('content'=>$content));
		?>
		</div>
	</div>
<?php $this->endWidget(); ?>
