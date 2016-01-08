
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapaketpelayanan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'tipepaket_id',CHtml::listData(TipepaketM::model()->findAll(), 'tipepaket_id','tipepaket_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->dropDownListRow($model,'daftartindakan_id', CHtml::listData(DaftartindakanM::model()->findAll(), 'daftartindakan_id','daftartindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id','ruangan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->textFieldRow($model,'namatindakan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($model,'tarifpaketpel',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($model,'subsidiasuransi',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->textFieldRow($model,'subsidipemerintah',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->textFieldRow($model,'subsidirumahsakit',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php echo $form->textFieldRow($model,'iurbiaya',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				Yii::app()->createUrl($this->module->id.'/paketpelayananM/admin'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'))."&nbsp"; ?>
		<?php
			$content = $this->renderPartial($this->path_view.'tips.tips',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
	</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('angka', "
$(document).ready(function () {
        $('.numbersOnly').keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode
                if ((charCode >= 48 && charCode <= 57)
                        || charCode == 46
                        || charCode == 44)
                        return true;
                return false;
        });
});
", CClientScript::POS_HEAD); ?>