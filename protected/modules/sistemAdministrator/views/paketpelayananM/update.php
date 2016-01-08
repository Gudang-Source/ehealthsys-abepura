<div class="white-container">
    <legend class="rim2">Ubah <b>Paket Pelayanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapaketpelayanan Ms'=>array('index'),
            $model->paketpelayanan_id=>array('view','id'=>$model->paketpelayanan_id),
            'Update',
    );

    $arrMenu = array();
    //	array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Paket Pelayanan #'.$model->paketpelayanan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
</div>