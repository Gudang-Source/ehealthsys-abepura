<div class="white-container">
    <legend class="rim2">Ubah <b>Rencana Keperawatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sarencana Keperawatan Ms'=>array('index'),
            $model->rencanakeperawatan_id=>array('view','id'=>$model->rencanakeperawatan_id),
            'Update',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Rencana Keperawatan  '.$model->rencanakeperawatan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RDRencanaKeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RDRencanaKeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RDRencanaKeperawatanM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->rencanakeperawatan_id))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rencana Keperawatan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model, 'modRencanaKeperawatan'=>$modRencanaKeperawatan)); ?>
</div>