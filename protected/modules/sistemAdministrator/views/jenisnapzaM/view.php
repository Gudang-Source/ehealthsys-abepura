<?php
//$this->breadcrumbs=array(
//	'Sajenisnapza Ms'=>array('index'),
//	$model->jenisnapza_id,
//);

//$arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Napza ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisnapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAJenisnapzaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAJenisnapzaM', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenisnapza_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAJenisnapzaM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenisnapza_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Napza', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;
//
//$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'jenisnapza_id',
		'jenisnapza_nama',
		'jenisnapza_desc',
		array(            
                    'label'=>'Aktif',
                    'type'=>'raw',
                    'value'=>(($model->jenisnapza_aktif == 1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                ),
	),
)); ?>
 <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Napza', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                        $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    
<?php $this->widget('UserTips',array('type'=>'view'));?>