<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Menu Diet</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Ubah <b>Menu Diet</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gzmenudiet Ms'=>array('index'),
            $model->menudiet_id=>array('view','id'=>$model->menudiet_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Menu Diet', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Menu Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Menu Diet', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->menudiet_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Menu Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'zatgizi'=>$zatgizi, 'modZatMenuDietM'=>$modZatMenuDietM)); ?>
<!--</div>-->
</fieldset>