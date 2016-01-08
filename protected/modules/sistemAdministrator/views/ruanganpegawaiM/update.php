<div class="white-container">
    <legend class="rim2">Ubah <b>Ruangan Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rjkelasruangan Ms'=>array('index'),
            $model->ruangan_id=>array('view','id'=>$model->ruangan_id),
            'Update',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelas Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Ruangan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model,'modDetails'=>$modDetails)); ?>
</div>