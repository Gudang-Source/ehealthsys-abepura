<fieldset class="box row-fluid">
    <legend class="rim">Lihat Diagnosa ICD IX</legend>
<?php
//$this->breadcrumbs=array(
//	'Sadiagnosa Icdixms'=>array('index'),
//	$model->diagnosaicdix_id,
//);
//
//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa ICD IX', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SADiagnosaICDIXM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SADiagnosaICDIXM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SADiagnosaICDIXM', 'icon'=>'pencil','url'=>array('update','id'=>$model->diagnosaicdix_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SADiagnosaICDIXM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->diagnosaicdix_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa ICD IX', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;
//
//$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'diagnosaicdix_id',
		'diagnosaicdix_kode',
		'diagnosaicdix_nama',
		'diagnosaicdix_namalainnya',
		'diagnosatindakan_katakunci',
		'diagnosaicdix_nourut',
		'diagnosaicdix_aktif',
	),
)); ?>
<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->diagnosaicdix_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')).'&nbsp;'; ?>
<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Diagnosa ICD IX',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')).'&nbsp;'; ?>
<?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>