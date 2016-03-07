<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapemeriksaanlab-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->dropDownListRow($model,'jenispemeriksaanlab_id',  CHtml::listData(JenispemeriksaanlabM::model()->findAll("jenispemeriksaanlab_aktif = TRUE ORDER BY jenispemeriksaanlab_urutan ASC"), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'),array('empty'=>'--Pilih--','class'=>'span3')); ?>

		<?php echo $form->textFieldRow($model,'pemeriksaanlab_urutan',array('class'=>'span3')); ?>

		<div class="control-group">
			<?php echo CHtml::label('Nama Tindakan','daftartindakan_nama',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'daftartindakan_nama',array('class'=>'span3')); ?>
			</div>
		</div>

	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'pemeriksaanlab_kode',array('class'=>'span3','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'pemeriksaanlab_nama',array('class'=>'span3','maxlength'=>500)); ?>

	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'pemeriksaanlab_namalainnya',array('class'=>'span3','maxlength'=>500)); ?>
            <div>
		<?php echo $form->checkBoxRow($model,'pemeriksaanlab_aktif'); ?>
            </div>
        </div>
</div>


	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
