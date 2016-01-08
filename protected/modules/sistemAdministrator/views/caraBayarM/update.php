<div class="white-container">
    <legend class="rim2">Ubah <b>Cara Bayar</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sacara Bayar Ms'=>array('index'),
            $model->carabayar_id=>array('view','id'=>$model->carabayar_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Cara Bayar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Cara Bayar', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Bayar', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Cara Bayar', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->carabayar_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Bayar', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>