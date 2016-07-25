<!--<div class="white-container">
    <legend class="rim2">Tambah <b>Bagian Tubuh</b></legend>-->
<fieldset class = "box">
    <legend class = "rim">Tambah Bagian Tubuh</legend>
    <?php
    $this->breadcrumbs=array(
            'Sabagiantubuh Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
<!--</div>-->
</fieldset>