<fieldset class="box">
    <legend class="rim">Ubah Kelompok Pemeriksaan Laboratorium</legend>
    <?php
    $this->breadcrumbs=array(
            'Rdkeadaan Masuk Ms'=>array('index'),
            $model->lookup_id=>array('view','id'=>$model->lookup_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Pemeriksaan '/*.$model->lookup_id*/, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Pemeriksaan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Pemeriksaan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelompok Pemeriksaan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Pemeriksaan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>