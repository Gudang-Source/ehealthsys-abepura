<div class="white-container">
    <legend class="rim2">Tambah <b>Kegiatan Persalinan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Pskegiatanpersalinan Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kegiatan Persalinan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAKegiatanpersalinanM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kegiatan Persalinan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>