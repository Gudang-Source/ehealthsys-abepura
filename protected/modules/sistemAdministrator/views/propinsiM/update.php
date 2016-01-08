<div class="white-container">
    <legend class="rim2">Ubah <b>Propinsi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapropinsi Ms'=>array('index'),
            $model->propinsi_id=>array('view','id'=>$model->propinsi_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Propinsi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Propinsi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Propinsi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Propinsi', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->propinsi_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Propinsi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'latitude'=>$latitude,'longitude'=>$longitude,)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>