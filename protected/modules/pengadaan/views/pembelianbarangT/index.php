<div class="white-container">
    <legend class="rim2">Transaksi Permintaan <b>Pembelian Barang</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gupembelianbarang Ts'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'modDetails'=>$modDetails, 'modPesan'=>$modPesan,'modBeli'=>$modBeli, 'renc'=>$renc)); ?>
</div>