<div class="white-container">
    <legend class="rim2">Ubah Monitoring <b>Error & Bugs</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sareportbugs Rs'=>array('index'),
            $model->reportbugs_id=>array('view','id'=>$model->reportbugs_id),
            'Update',
    );

    ?>
    <legend class="rim2">Ubah Monitoring Error & Bugs</legend>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</div>