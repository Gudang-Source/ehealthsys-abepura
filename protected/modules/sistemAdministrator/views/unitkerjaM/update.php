<div class="white-container">
    <legend class="rim2">Ubah <b>Unit Kerja</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Agunitkerja Ms'=>array('index'),
            $model->unitkerja_id=>array('view','id'=>$model->unitkerja_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modRuanganUnit'=>$modRuanganUnit)); ?>
</div>