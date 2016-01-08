<div class="white-container">
    <legend class="rim2">Update Jadwal <b>Buka Poli</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Ppjadwal Buka Poli Ms'=>array('index'),
            $model->jadwalbukapoli_id=>array('view','id'=>$model->jadwalbukapoli_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>