<div class="white-container">
    <legend class="rim2">Ubah Jenis <b>Alat Medis</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajenisalatmedis Ms'=>array('index'),
            $model->jenisalatmedis_id=>array('view','id'=>$model->jenisalatmedis_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Alat Medis '.$model->jenisalatmedis_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisalatmedisM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAJenisalatmedisM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAJenisalatmedisM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jenisalatmedis_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Alat Medis', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>