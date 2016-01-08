<div class="white-container">
    <legend class="rim2">Ubah <b>Lokasi Aset</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Salokasiaset Ms'=>array('index'),
            $model->lokasi_id=>array('view','id'=>$model->lokasi_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').'  Lokasi Aset ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SALokasiasetM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SALokasiasetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SALokasiasetM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lokasi_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  Lokasi Aset', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php // STANDARD 1 FORM echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'garis_latitude'=>$garis_latitude,'garis_longitude'=>$garis_longitude)); ?>
</div>