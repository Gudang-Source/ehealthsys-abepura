<div class="white-container">
    <legend class="rim2">Ubah <b>Interpretasi Skor</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Psinterpretasiskor Ms'=>array('index'),
            $model->interpretasiskor_id=>array('view','id'=>$model->interpretasiskor_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Interpretasi Skor', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAInterpretasiskorM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAInterpretasiskorM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAInterpretasiskorM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->interpretasiskor_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Interpretasi Skor', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>