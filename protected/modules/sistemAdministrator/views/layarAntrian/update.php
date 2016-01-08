<div class="white-container">
    <legend class="rim2">Ubah <b>Layar Antrian</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Salayarantrian Ms'=>array('index'),
            $model->layarantrian_id=>array('view','id'=>$model->layarantrian_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php // echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</div>