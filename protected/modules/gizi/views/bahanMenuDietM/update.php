<!--<div class="white-container">
    <legend class="rim2">Ubah Bahan <b>Menu Diet</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Ubah <b>Bahan Menu Diet</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gzbahanmenudiet Ms'=>array('index'),
            $model->bahanmenudiet_id=>array('view','id'=>$model->bahanmenudiet_id),
            'Update',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Propinsi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Propinsi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Propinsi', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->bahanmenudiet_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Menu Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<!--</div>-->
</fieldset>