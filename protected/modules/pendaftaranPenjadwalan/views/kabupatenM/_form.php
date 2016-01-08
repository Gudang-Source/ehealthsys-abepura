
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppkabupaten-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'propinsi_id'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        
	<?php echo $form->dropDownListRow($model,'propinsi_id',  CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        
	<table id="tbl-kabupaten" class="table table-striped table-bordered table-condensed">

		<tr>
			<td>
				<?php echo $form->textField($model,'[1]kabupaten_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kabupaten_nama'))); ?>
				<span class="required">*</span>

			</td>
			<td>
				<?php echo $form->textField($model,'[1]kabupaten_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kabupaten_namalainnya'))); ?>

			</td>
			<td>
				<?php echo CHtml::button( '+', array('class'=>'btn btn-primary','onkeyup'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>
			</td>
		</tr>
	</table>
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
					Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					Yii::app()->createUrl($this->module->id.'/kabupatenM/admin'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>

		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
		$this->createUrl('/pendaftaranPenjadwalan/KabupatenM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
		<?php
			$content = $this->renderPartial('../tips/tipsaddedit2b',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
    
	</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array()); ?>