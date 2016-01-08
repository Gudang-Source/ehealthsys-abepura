<div class="white-container">
    <legend class="rim2">Ubah <b>Supplier</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfsupplier Ms'=>array('index'),
            $model->supplier_id=>array('view','id'=>$model->supplier_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Supplier', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Supplier', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->supplier_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Supplier', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modObatSupplier'=>$modObatSupplier,'latitude'=>$latitude,'longitude'=>$longitude)); ?>
</div>