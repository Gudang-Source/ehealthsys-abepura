<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Jam Kerja</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Ubah Jam Kerja</legend>
    <?php
    $this->breadcrumbs=array(
            'Kpjamkerja Ms'=>array('index'),
            $model->jamkerja_id=>array('view','id'=>$model->jamkerja_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<!--</div>-->
</fieldset>