<div class="white-container">
    <legend class="rim2">Tambah <b>Modul</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Samodul Ks'=>array('index'),
            'Create',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Create').' Modul ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Modul', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Manage').' Modul', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>