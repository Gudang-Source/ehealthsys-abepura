<div class="white-container">
    <legend class="rim2">Ubah <b>Kelompok Menu</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Menu Ks'=>array('index'),
            $model->kelmenu_id=>array('view','id'=>$model->kelmenu_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Kelompok Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Kelompok Menu', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Kelompok Menu', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Kelompok Menu', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->kelmenu_id)),
    //	array('label'=>Yii::t('mds','Manage').' Kelompok Menu', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>