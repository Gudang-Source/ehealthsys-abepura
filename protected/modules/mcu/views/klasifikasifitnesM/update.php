<div class="white-container">
    <legend class="rim2">Ubah <b>Klasifikasi Fitnes</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Mcklasifikasifitnes Ms'=>array('index'),
            $model->klasifikasifitnes_id=>array('view','id'=>$model->klasifikasifitnes_id),
            'Update',
    );

    ?>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</div>