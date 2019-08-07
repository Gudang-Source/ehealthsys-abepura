<div class="white-container">
    <legend class="rim2">Ubah <b>Kriteria Hasil</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Bataskarakteristik Ms'=>array('index'),
            $model->kriteriahasil_id=>array('view','id'=>$model->kriteriahasil_id),
            'Update',
    );
    $this->menu=array(
//            array('label'=>Yii::t('mds','Update').' Lookup ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view. '_form',array('model'=>$model,'modDetail'=>$modDetail)); ?>
</div>