<!--<div class="white-container">
    <legend class="rim2">Tambah <b>Jam Kerja</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Tambah Jam Kerja</legend>
    <?php
    $this->breadcrumbs=array(
            'Kpjamkerja Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<!--</div>-->
</fieldset>