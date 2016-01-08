<div class="white-container">
    <legend class="rim2">Tambah <b>Obat Alkes</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfobat Alkes Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Obat Alkes ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'modObatAlkesDetail'=>$modObatAlkesDetail)); ?>
</div>