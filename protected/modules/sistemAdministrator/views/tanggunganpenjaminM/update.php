<div class="white-container">
    <legend class="rim2">Ubah <b>Tanggungan Pasien</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Satanggunganpenjamin Ms'=>array('index'),
            $model->tanggunganpenjamin_id=>array('view','id'=>$model->tanggunganpenjamin_id),
            'Update',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tanggungan Penjamin #'.$model->tanggunganpenjamin_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SATanggunganpenjaminM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SATanggunganpenjaminM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SATanggunganpenjaminM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->tanggunganpenjamin_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tanggungan Penjamin', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>