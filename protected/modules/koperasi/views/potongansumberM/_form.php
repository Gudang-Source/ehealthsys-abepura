<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'potongansumber-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
)); ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'namapotongan',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('namapotongan'),)); ?>

	<?php echo $form->textFieldRow($model,'namapotonganlainnya',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('namapotonganlainnya'),)); ?>

	<?php //echo $form->checkBoxRow($model,'potongansumber_aktif',array('class'=>'form-control')); ?>
	
	<?php 
			if (Yii::app()->controller->action->id == 'update')	{
		?>
		<div class="control-group">
            <?php echo $form->labelEx($model, 'potongansumber_aktif',array('class'=>'control-label col-sm-3')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'potongansumber_aktif',array('class'=>'form-control')); ?>
            </div>
        </div>
        <?php }?>
        
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                       '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sumber Potongan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
		$content = $this->renderPartial('koperasi.views.tips.tips',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>	
</div>

<?php $this->endWidget(); ?>
