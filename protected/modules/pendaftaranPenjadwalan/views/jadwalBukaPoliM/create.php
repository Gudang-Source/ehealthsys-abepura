<div class="white-container">
    <legend class="rim2">Tambah Jadwal <b>Buka Poli</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Ppjadwal Buka Poli Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>