<div class="white-container">
    <legend class="rim2">Lihat <b>Faktor Risiko</b></legend>
	<?php
	$this->breadcrumbs = array(
		'Lookup Ms' => array('index'),
		$model->implementasikep_id,
	);

	$this->menu = array(
			//        array('label'=>Yii::t('mds','View').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	);

	$this->widget('bootstrap.widgets.BootAlert');
	?>

	<?php
	$this->widget('ext.bootstrap.widgets.BootDetailView', array(
		'data' => $model,
		'attributes' => array(
			array(
				'label' => 'Diagnosa Keperawatan',
				'value' => $model->diagnosakep->diagnosakep_nama,
			),
			array(
				'label'=>'Indikator',
				'type'=>'raw',
				'value'=>$this->renderPartial($this->path_view.'_indikator',array('implementasikep_id'=>$model->implementasikep_id),true),
			),
		),
	));
	?>
	<?php //echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->implementasikep_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Implementasi Keperawatan', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
$this->widget('UserTips', array('type' => 'view'));
?>
</div>