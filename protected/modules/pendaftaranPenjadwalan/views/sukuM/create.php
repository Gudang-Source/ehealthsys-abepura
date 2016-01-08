<fieldset class="box">
    <legend class="rim">Tambah Suku</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppsuku Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</fieldset>