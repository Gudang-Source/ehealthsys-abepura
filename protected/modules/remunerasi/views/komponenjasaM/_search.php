<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'komponenjasa-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'komponenjasa_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'komponentarif_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'kelompoktindakan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'jenistarif_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'komponenjasa_kode',array('class'=>'span5','maxlength'=>5)); ?>

	<?php echo $form->textFieldRow($model,'komponenjasa_nama',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'komponenjasa_singkatan',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'besaranjasa',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'potongan',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'jasadireksi',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'kuebesar',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jasadokter',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jasaparamedis',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jasaunit',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jasabalanceins',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jasaemergency',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'biayaumum',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'komponenjasa_aktif'); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
