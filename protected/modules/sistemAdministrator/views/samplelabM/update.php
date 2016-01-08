<div class="white-container">
    <legend class="rim2">Ubah <b>Sampel Laboratorium</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Lksamplelab Ms'=>array('index'),
            $model->samplelab_id=>array('view','id'=>$model->samplelab_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sampel Lab '/*.$model->samplelab_id*/, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Sampel Lab', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Sampel Lab', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sampel Lab', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->samplelab_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sampel Lab', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</div>