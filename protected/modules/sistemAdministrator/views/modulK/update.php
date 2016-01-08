<div class="white-container">
    <legend class="rim2">Ubah <b>Modul</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Samodul Ks'=>array('index'),
            $model->modul_id=>array('view','id'=>$model->modul_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Modul ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Modul', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Modul', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Modul', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->modul_id)),
    //	array('label'=>Yii::t('mds','Manage').' Modul', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>