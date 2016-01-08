<div class="white-container">
    <legend class="rim2">Tambah <b>Kelompok Menu</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Menu Ks'=>array('index'),
            'Create',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Create').' Kelompok Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Kelompok Menu', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Manage').' Kelompok Menu', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>