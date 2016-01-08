<div class="white-container">
    <legend class="rim2">Ubah <b>Bagian Tubuh</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sabagiantubuh Ms'=>array('index'),
            $model->bagiantubuh_id=>array('view','id'=>$model->bagiantubuh_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</div>