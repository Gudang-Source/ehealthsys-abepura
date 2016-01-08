<div class="white-container">
    <legend class="rim2"><b>Indexing</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Indexing Ms'=>array('index'),
            $model->indexing_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Indexing ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Remunerasi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Remunerasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess('Update')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Remunerasi', 'icon'=>'pencil','url'=>array('update','id'=>$model->gelarbelakang_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kelompok Remunerasi','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->gelarbelakang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Indexing', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu; ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'indexing_id',
		'kelrem_id',
		'indexing_urutan',
		'indexing_nama',
		'indexing_singk',
		'indexing_nilai',
                                array(               // related city displayed as a link
                                    'name'=>'indexing_aktif',
                                    'type'=>'raw',
                                    'value'=>(($model->indexing_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                                ),
	),
    )); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>