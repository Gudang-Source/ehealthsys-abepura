<div class="white-container">
    <?php
    $sukses = null;
    if(isset($_GET['id'])){
    $sukses = $_GET['id'];
    }
    if($sukses > 0)
            Yii::app()->user->setFlash('success',"Data Pengangkatan Tenaga Pekerja Harian Lepas berhasil disimpan !");

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <?php
    $this->breadcrumbs=array(
            'Kppengangkatantphl Ts'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pengangkatan Tenaga Pekerja Harian Lepas', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPengangkatantphlT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KPPengangkatantphlT', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Pengangkatan Tenaga <b>Pekerja Harian Lepas</b></legend>
    <?php echo $this->renderPartial('_form', array('model'=>$model, 'modPegawai'=>$modPegawai)); ?>
</div>