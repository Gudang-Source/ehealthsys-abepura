<div class="white-container">
    <legend class="rim2">Informasi Riwayat <b>Pasien Gizi</b></legend>
    <?php 
        $this->renderPartial('_ringkasDataPasien',array(
                            'modPendaftaran'=>$modPendaftaran,
                            'modPasien'=>$modPasien,
                            'modPasienMasukPenunjang'=>$modPasienMasukPenunjang
        ));
    ?>
    <div class="block-tabel">
        <h6> Riwayat <b>Pasien</b></h6>
        <?php 
            $this->renderPartial('/_periksaDataPasien/_riwayatPasien',array(
                                 'pages'=>$pages,
                                 'modKunjungan'=>$modKunjungan,
            ));
        ?>
    </div>
    <div>
        <table class="items table table-striped table-bordered table-condensed" >
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl. Pendaftaran</th>
                    <th>Tgl. Anamnesis</th>
                    <th>Waktu Makan</th>
                    <th>Menu</th>
                    <th>Bahan Makanan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modAnamnesa) > 0){
                    foreach($modAnamnesa as $key=>$detail){
                ?>
                <tr>
                    <td><?php echo ($key+1); ?> </td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($detail->pendaftaran->tgl_pendaftaran); ?></td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($detail->tglanamesadiet); ?></td>
                    <td><?php echo $detail->jeniswaktu->jeniswaktu_nama; ?></td>
                    <td><?php echo $detail->menudiet->menudiet_nama; ?></td>
                    <td><?php echo $detail->bahanmakanan->namabahanmakanan; ?></td>
                </tr>
                <?php 
                    }
                }else{
                ?>
                <tr>
                    <td colspan="6"><i>Data Tidak Ditemukan</i></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    //========= Dialog Detail Anamnesa Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailAnamnesa',
        'options' => array(
            'title' => 'Data Anamnesa Diet',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 600,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailDialogAnamnesa" width="100%" height="500">
    </iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>
    
    <?php
    //========= Dialog Detail Konsultasi Gizi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailGizi',
        'options' => array(
            'title' => 'Data Konsultasi Gizi',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 600,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailDialogGizi" width="100%" height="500">
    </iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>
    
    <?php
    //========= Dialog Detail Pemeriksaan Fisik Gizi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPeriksaFisik',
        'options' => array(
            'title' => 'Data Periksa Fisik',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 600,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="dialogPeriksaFisik" width="100%" height="500">
    </iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>

    <?php
    //========= Dialog Detail Anamnesa Keperawatan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'detailAnamnesisPerawatan',
        'options' => array(
            'title' => 'Data Anamnesa Keperawatan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 600,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailAnamnesisPerawatan" width="100%" height="500">
    </iframe>
    <?php
    $this->endWidget();
    //=======================================================================
    ?>
    <?php
    //========= Dialog Detail Konsultasi Gizi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetailData',
        'options' => array(
            'title' => 'Detail Data',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 600,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailDialog" width="100%" height="500">
    </iframe>
    <?php
    $this->endWidget();
    ?>
</div>