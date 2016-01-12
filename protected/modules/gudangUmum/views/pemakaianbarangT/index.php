<div class="white-container">
    <legend class="rim2">Transaksi <b>Pemakaian Barang</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gupemakaianbarang Ts'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php 
        if(!empty($_GET['id'])){        
    ?>
	<?php echo Yii::app()->user->setFlash('success',"Data Pemakaian Barang berhasil disimpan !"); ?>
    <?php } ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array(
            'model'=>$model, 'modDetails'=>$modDetails)); ?>
</div>