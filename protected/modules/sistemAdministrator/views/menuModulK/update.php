<div class="white-container">
    <legend class="rim2">Ubah <b>Menu</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Samenu Modul Ks'=>array('index'),
            $model->menu_id=>array('view','id'=>$model->menu_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Menu', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Menu', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Menu', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->menu_id)),
    //	array('label'=>Yii::t('mds','Manage').' Menu', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>