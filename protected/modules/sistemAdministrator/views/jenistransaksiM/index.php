<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Jenistransaksi Ms',
);
	$this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>

	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan JenistransaksiM',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
