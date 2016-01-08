<div class="white-container">
    <legend class="rim2">Ubah <b>SMS Gateway</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sasmsgateway Ms'=>array('index'),
            $model->smsgateway_id=>array('view','id'=>$model->smsgateway_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</div>