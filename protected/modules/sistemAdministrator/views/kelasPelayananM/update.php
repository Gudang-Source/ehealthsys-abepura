<div class="white-container">
    <legend class="rim2">Ubah <b>Kelas Pelayanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelas Pelayanan Ms'=>array('index'),
            $model->kelaspelayanan_id=>array('view','id'=>$model->kelaspelayanan_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelas Pelayanan ','header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Pelayanan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Pelayanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelas Pelayanan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->kelaspelayanan_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Pelayanan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modRuangan'=>$modRuangan)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>