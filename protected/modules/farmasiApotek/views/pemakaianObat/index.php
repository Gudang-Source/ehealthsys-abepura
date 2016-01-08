<div class="white-container">
    <legend class="rim2">Transaksi <b>Pemakaian Obat</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gupemakaianbarang Ts'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php 
        if(!empty($_GET['pemakaianobat_id'])){        
    ?>
      <div class="alert alert-block alert-success">
          <a class="close" data-dismiss="alert">x</a>
          Data Berhasil Disimpan
      </div>
    <?php } ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array(
            'model'=>$model, 'modDetails'=>$modDetails)); ?>
</div>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model,'modDetails'=>$modDetails)); ?>