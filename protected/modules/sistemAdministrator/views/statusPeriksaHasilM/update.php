<div class="white-container">
    <legend class="rim2">Ubah <b>Status Hasil Periksa Laboratorium</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rdkeadaan Masuk Ms'=>array('index'),
            $model->lookup_id=>array('view','id'=>$model->lookup_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Status Periksa Hasil '/*.$model->lookup_id*/, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Status Periksa Hasil', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Status Periksa Hasil', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Status Periksa Hasil', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Status Periksa Hasil', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</div>