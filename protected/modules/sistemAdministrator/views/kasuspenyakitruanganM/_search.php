<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rjkasuspenyakitruangan-m-search',
	'type'=>'horizontal',
)); ?>


	<?php echo $form->DropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData(SAJenisKasusPenyakitM::model()->getItems(),'jeniskasuspenyakit_id','jeniskasuspenyakit_nama'),array('empty'=>'-- Pilih --')); ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
