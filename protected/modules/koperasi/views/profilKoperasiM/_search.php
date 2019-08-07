<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'form-groups-bordered'),
)); ?>

		<?php echo $form->textFieldRow($model,'nama_profil',array('class'=>'form-control','maxlength'=>200, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nama_profil'),)); ?>

		<?php echo $form->textFieldRow($model,'alamat_profil',array('class'=>'form-control','maxlength'=>300, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('alamat_profil'),)); ?>

		<?php echo $form->textFieldRow($model,'propinsi_profil',array('class'=>'form-control','maxlength'=>200, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('propinsi_profil'),)); ?>

		<?php echo $form->textFieldRow($model,'kota_kab_profil',array('class'=>'form-control','maxlength'=>200, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('kota_kab_profil'),)); ?>

		<?php echo $form->textFieldRow($model,'telp_profil',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('telp_profil'),)); ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-5">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Cari',
			'htmlOptions'=>array('class'=>'btn-primary'),
		)); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
