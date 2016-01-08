<div class="white-container">
    <legend class='rim2'>Ubah <b>Tindakan #<?php echo $model->tindakanrm_id ?></b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmtindakanrm Ms'=>array('index'),
            $model->tindakanrm_id=>array('view','id'=>$model->tindakanrm_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tindakan #'.$model->tindakanrm_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tindakan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>