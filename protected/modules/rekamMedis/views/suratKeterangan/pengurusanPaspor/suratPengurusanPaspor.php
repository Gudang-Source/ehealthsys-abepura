<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
if(!empty($_GET["pendaftaran_id"])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_UTAMA.'');
    if(count($modPasienmorbiditas) < 0){
        $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_MASUK.' OR kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_TAMBAH.'');
    }
    
    if(count($modPasienmorbiditas) > 0){
        $diagnosa = "<u><b>".$modPasienmorbiditas->diagnosa->diagnosa_nama."</u></b>";
    }else{
        $diagnosa = " _________________ ";
    }
    
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pegawai_id);
        $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai : "");
    }
}
if(!empty($modPendaftaran->pasienadmisi_id)){
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
}
if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
}
$model->tglistirahat = date('Y-m-d')." 00:00:00";
$modAdmisi->tgladmisi = date('Y-m-d')." 00:00:00";

if(!empty($_GET['lama_hari'])){
    $model->lama_istirahat = $_GET['lama_hari'];
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE>
<div>
    <div>
        <TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN PENGURUSAN PASPOR"; ?></U></FONT></B>
                </TD>
            </TR>
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Liberation Serif" SIZE=4>NO : <?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></FONT></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </TD>
            </TR>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        Saya yang bertanda tangan dibawah ini, Dokter <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Umur/Tgl. lahir</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPendaftaran->umur, array('readonly'=>false,
                            'class'=>'span2',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo CHtml::textField('nama_pasien',MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir), array('readonly'=>false,
                            'class'=>'span2',
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->jeniskelamin, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>No. RK</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->no_rekam_medik, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Tgl. Opname</td>
                <td>:</td>
                <td><?php 
                        $modAdmisi->tgladmisi = MyFormatter::formatDateTimeForUser($modAdmisi->tgladmisi);
                        $this->widget('MyDateTimePicker', array(
                            'model'=> $modAdmisi,
                            'attribute'=>'tgladmisi',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true,'style'=>'width:150px;',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                    ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Berdasarkan hasil pemeriksaan medis maupun penunjang medis terhadap pasien tersebut di atas, dapat disimpulkan pasien tersebut didiagnosa <?php echo (!empty($_GET["pendaftaran_id"]) ? $diagnosa : " _________________ " ) ; ?> 
            <br/>dan pengobatan lanjutan ke luar negeri <?php echo CHtml::activeTextField($model,'tujuan_negara', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>.
            <br/><br/>            
        </p>
        <p align="justify">
            Demikianlah Surat Keterangan Pengurusan Paspor ini diperbuat untuk dapat dipergunakan untuk pengurusan paspor, atas kerjasamanya diucapkan Terima Kasih.
        </p>
</div><br><br><br><br><br>
<div style="margin-left: 50px">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
<!--    (_________________)-->
<?php
    echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(DokterV::model()->findAll(array(
        'condition'=>'pegawai_aktif = true',
        'order'=>'nama_pegawai'
    )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
?>
</div>
</TABLE>