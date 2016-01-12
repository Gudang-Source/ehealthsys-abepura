<fieldset class="box">
    <legend class="rim">Ubah Cara Keluar</legend>
    <?php
    $this->breadcrumbs=array(
            'Rdcara Keluar Ms'=>array('index'),
            $model->lookup_id=>array('view','id'=>$model->lookup_id),
            'Update',
    );

    $arrMenu = array();
    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
</fieldset>