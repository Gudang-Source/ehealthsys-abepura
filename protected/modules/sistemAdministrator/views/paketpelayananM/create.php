<div class="white-container">
    <legend class="rim2">Tambah <b>Paket Pelayanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapaketpelayanan Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //	array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Paket Pelayanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;
    $totaltarif = 0;
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'dataPaketPelayanan'=>$modPaket, 'totaltarif'=>$totaltarif, 'modPaket'=>$modPaket, 'kelas'=>$kelas)); ?>
</div>