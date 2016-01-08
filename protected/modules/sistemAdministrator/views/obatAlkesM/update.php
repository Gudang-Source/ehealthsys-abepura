<div class="white-container">
    <legend class="rim2">Ubah <b>Obat Alkes</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfobat Alkes Ms'=>array('index'),
            $model->obatalkes_id=>array('view','id'=>$model->obatalkes_id),
            'Update',
    );

    $arrMenu = array();
    //array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'modObatAlkesDetail'=>$modObatAlkesDetail,'modObatSupplier'=>$modObatSupplier,'modTherapiObat'=>$modTherapiObat, 'modUbahHarga'=>$modUbahHarga)); ?>
</div>