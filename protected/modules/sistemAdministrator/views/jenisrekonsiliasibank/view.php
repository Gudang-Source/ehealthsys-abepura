<?php
$this->breadcrumbs=array(
	'Akjenisrekonsiliasibank Ms'=>array('index'),
	$model->jenisrekonsiliasibank_id,
);
?>
<fieldset class="box">
	<legend class="rim">Lihat Jenis Rekonsiliasi Bank</legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
//					'jenisrekonsiliasibank_id',
				'jenisrekonsiliasibank_nama',
				//'jenisrekonsiliasibank_namalain',
				//'jenisrekonsiliasibank_aktif',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'jenisrekonsiliasibank_id',
				//'jenisrekonsiliasibank_nama',
				'jenisrekonsiliasibank_namalain',
				array(            
                            'label'=>'Aktif',
                            'type'=>'raw',
                            'value'=>(($model->jenisrekonsiliasibank_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
				),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->jenisrekonsiliasibank_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Rekonsiliasi Bank',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('type'=>'view'));?>
		</div>
	</div>
</fieldset>
