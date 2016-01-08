<div class="white-container">
    <legend class="rim2">Transaksi <b>Surat Keterangan</b></legend>
    <?php 
        $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
    ?>
    <fieldset class="box">
        <legend class="rim">Surat Keterangan</legend>
        <?php
            $this->renderPartial($this->path_view.'_tabMenu',array());
            $this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien));
        ?>
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
    </fieldset>
</div>