<div class="white-container">
    <legend class="rim2">Ubah <b>Karcis</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakarcis Ms'=>array('index'),
            $model->karcis_id=>array('view','id'=>$model->karcis_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Karcis '.$model->karcis_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Karcis', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Karcis', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Karcis', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->karcis_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Karcis', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>