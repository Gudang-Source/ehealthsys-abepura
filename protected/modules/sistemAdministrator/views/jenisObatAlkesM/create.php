<fieldset class="box">
    <legend class="rim">Tambah Jenis Obat ALkes</legend>
    
    <?php
    $this->breadcrumbs=array(
            'Gfjenis Obat Alkes Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</fieldset>