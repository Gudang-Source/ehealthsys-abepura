<div class="white-container">
    <legend class="rim2">Ubah Jenis <b>Kasus Penyakit</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajenis Kasus Penyakit Ms'=>array('index'),
            $model->jeniskasuspenyakit_id=>array('view','id'=>$model->jeniskasuspenyakit_id),
            'Update',
    );
    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Kasus Penyakit Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kasus Penyakit', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Kasus Penyakit', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Kasus Penyakit', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jeniskasuspenyakit_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Kasus Penyakit Ruangan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modRuangan'=>$modRuangan)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>