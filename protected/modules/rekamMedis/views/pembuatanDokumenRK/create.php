<div class="white-container">
    <legend class="rim2">Pembuatan Dokumen <b>Rekam Medis Baru</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadokrekammedis Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php
    if(isset($_GET['sukses'])){
        if($_GET['sukses'] == 1){
            Yii::app()->user->setFlash("success","Tansaksi Pembuatan Dokumen Rekam Medis Baru berhasil disimpan!");
        }
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view_rm.'_form', array('model'=>$model)); ?>
</div>