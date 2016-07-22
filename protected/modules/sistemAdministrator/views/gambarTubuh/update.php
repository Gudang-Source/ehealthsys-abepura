<!--<div class="white-container">
    <legend class="rim2">Ubah <b>Gambar Tubuh</b></legend>-->
<fieldset class = "box">
    <legend class = "rim">Ubah Gambar Tubuh</legend>
    <?php
    $this->breadcrumbs=array(
            'Sagambartubuh Ms'=>array('index'),
            $model->gambartubuh_id=>array('view','id'=>$model->gambartubuh_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
<!--</div>-->
</fieldset>