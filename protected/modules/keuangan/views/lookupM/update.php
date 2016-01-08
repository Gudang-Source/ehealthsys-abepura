<div class="white-container">
    <legend class='rim2'>Ubah <b>Jenis Transaksi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Lookup Ms'=>array('index'),
            $model->lookup_id=>array('view','id'=>$model->lookup_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Jenis Transaksi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Lookup', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id)),
    //	array('label'=>Yii::t('mds','Manage').' Lookup', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modLookup'=>$modLookup)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>