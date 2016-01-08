<div class="white-container">
    <legend class="rim2">Tambah Jenis <b>Kasus Penyakit</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajenis Kasus Penyakit Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Kasus Penyakit Ruangan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kasus Penyakit', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Kasus Penyakit Ruangan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'modRuangan'=>$modRuangan)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>