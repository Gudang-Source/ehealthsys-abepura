<div class="white-container">
    <legend class="rim2">Ubah <b>Minat Pekerjaan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Lookup Ms'=>array('index'),
            $model->lookup_id=>array('view','id'=>$model->lookup_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Minat Pekerjaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Lookup', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id)),
    //	array('label'=>Yii::t('mds','Manage').' Minat Pekerjaan', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>

</div>