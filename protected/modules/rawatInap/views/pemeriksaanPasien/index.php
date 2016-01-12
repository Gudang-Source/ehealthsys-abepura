<div class="white-container">
    <legend class="rim2">Pemeriksaan <b>Pasien</b></legend>
    <?php 
    $this->widget('bootstrap.widgets.BootAlert');
    $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
    $this->renderPartial($this->path_view.'_tabMenu',array());
    $this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien)); ?>
    <div>
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
    </div>
</div>

