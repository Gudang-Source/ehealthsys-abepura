<div class="white-container">
    <?php
    $sukses = null;
    if(isset($_GET['id'])){
    $sukses = $_GET['id'];
    }
    if($sukses > 0)
            Yii::app()->user->setFlash('success',"Data Pinjaman Pegawai berhasil disimpan !");

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <?php
    $this->breadcrumbs=array(
            'PinjamanPeg Ts'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //array_push($arrMenu,array('label'=>' Pinjaman Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Pinjaman <b>Pegawai</b></legend>
    <?php echo $this->renderPartial('_form', array('model'=>$model, 'modPegawai'=>$modPegawai)); ?>
</div>