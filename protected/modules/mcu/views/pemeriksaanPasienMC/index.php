<div class="white-container">
    <legend class="rim2">Pemeriksaan <b>Pasien</b></legend>
    <?php 
    $this->breadcrumbs=array(
            'Sapendidikan Ms'=>array('index'),
            'Manage',
    );
    ?>
    <?php 
    $this->renderPartial($this->path_view_mcu.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
    $this->renderPartial($this->path_view_mcu.'_tabMenu',array());
    $this->renderPartial($this->path_view_mcu.'_jsFunctions',array("modPasien"=>$modPasien,'modPendaftaran'=>$modPendaftaran)); ?>
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
</div>