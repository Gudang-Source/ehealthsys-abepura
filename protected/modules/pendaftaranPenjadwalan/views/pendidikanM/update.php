<fieldset class="box">
    <legend class="rim">Ubah Pendidikan</legend>
    <?php
    $this->breadcrumbs=array(
            'Pppendidikan Ms'=>array('index'),
            $model->pendidikan_id=>array('view','id'=>$model->pendidikan_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>