<div class="white-container">
    <legend class="rim2">Ubah Kasus <b>Penyakit Ruangan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rjkasuspenyakitruangan Ms'=>array('index'),
            $model->ruangan_id=>array('view','id'=>$model->ruangan_id),
            'Update',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kasus Penyakit Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kasus Penyakit Ruangan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model,'modDetails'=>$modDetails)); ?>
</div>