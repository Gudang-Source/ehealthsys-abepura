<div class="white-container">
    <?php
    $sukses = null;
    if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
    }
    if($sukses > 0)
            Yii::app()->user->setFlash('success',"Data Penilaian Pegawai berhasil disimpan !");

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <legend class="rim2">Penilaian <b>Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kppenilaianpegawai Ts'=>array('index'),
            'Create',
    ); ?>

    <?php echo $this->renderPartial('kepegawaian.views.penilaianpegawaiT._form', array('model'=>$model, 'modPegawai'=>$modPegawai, 'namapegawai'=>'')); ?>
</div>