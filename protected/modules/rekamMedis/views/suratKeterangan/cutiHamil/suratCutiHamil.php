<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
if(!empty($_GET["pendaftaran_id"])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pegawai_id);
        $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai:"");
    }
    
    $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_UTAMA.'');
    if(count($modPasienmorbiditas) < 0){
        $modPasienmorbiditas = PasienmorbiditasT::model()->find('pendaftaran_id = '.$pendaftaran_id.' AND kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_MASUK.' OR kelompokdiagnosa_id = '.PARAMS::KELOMPOKDIAGNOSA_TAMBAH.'');
    }
    if(count($modPasienmorbiditas) > 0){
        $diagnosa = $modPasienmorbiditas->diagnosa->diagnosa_nama;
    }else{
        $diagnosa = " ";
    }
    
    $modPemeriksaan = PemeriksaanfisikT::model()->find('pendaftaran_id = '.$pendaftaran_id.'');
    $modAnamnesa = AnamnesaT::model()->find('pendaftaran_id = '.$pendaftaran_id.'');
    
    if(count($modAnamnesa) > 0){
        $keluhan_utama = $modAnamnesa->keluhanutama;
    }else{
        $keluhan_utama = '';
    }
    
    if(count($modPemeriksaan) > 0){
        $tekanan_darah = $modPemeriksaan->tekanandarah;
        $tempratur = $modPemeriksaan->suhutubuh;
        $pols = $modPemeriksaan->detaknadi;
        $rr = $modPemeriksaan->pernapasan;
        $tinggi_badan = $modPemeriksaan->tinggibadan_cm;
        $berat_badan = $modPemeriksaan->beratbadan_kg;
        $pemeriksaan_lain = $modPemeriksaan->kelainanpadabagtubuh;
    }else{
        $tekanan_darah = '';
        $tempratur = '';
        $pols = '';
        $rr = '';
        $tinggi_badan = '';
        $berat_badan = '';
        $pemeriksaan_lain = '';
    }
}
$model->tglistirahat = date('Y-m-d');
$model->tglperkiraanpartus = date('Y-m-d');

if(!empty($_GET['lama_hari'])){
    $model->lama_istirahat = $_GET['lama_hari'];
}

if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
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
                    <B><FONT FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN CUTI HAMIL"; ?></U></FONT></B>
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
        </table>
        <p align="justify">
            Berdasarkan hasil pemeriksaan dokter dapat diinformasikan sebagai berikut :
            <br/>
            <table width="100%" style="width:750px;margin-left:80px;">
                <tr>
                    <td>Tekanan Darah</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('tekanan_darah',(!empty($_GET['pendaftaran_id']) ? $tekanan_darah : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($tekanan_darah) || empty($_GET['pendaftaran_id']) ? "" : 'Tekanan Darah harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Tempratur</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('tempratur',(!empty($_GET['pendaftaran_id']) ? $tempratur : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($tempratur) || empty($_GET['pendaftaran_id']) ? "" : 'Tempratur harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Pols</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('pols',(!empty($_GET['pendaftaran_id']) ? $pols : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($pols) || empty($_GET['pendaftaran_id']) ? "" : 'Pols harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>RR</td>
                    <td>:</td>
                    <td><?php echo CHtml::textField('rr',(!empty($_GET['pendaftaran_id']) ? $rr : ''), array('readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($rr) || empty($_GET['pendaftaran_id']) ? "" : 'RR harus diinputkan di Pemeriksaan Pasien')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Usia Kehamilan</td>
                    <td>:</td>
                    <td><?php echo CHtml::activeTextField($model,'usiakehamilan', array('readonly'=>false,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php 
                                echo "<span class='help-inline error'>".(!empty($model->usiakehamilan) || empty($_GET['pendaftaran_id']) ? "" : 'Usia Kehamilan tidak boleh kosong')."</span>";                         
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Pemeriksaan Lain</td>
                    <td>:</td>
                    <td><?php echo CHtml::textArea('pemeriksaan_lain',(!empty($_GET['pendaftaran_id']) ? $pemeriksaan_lain : ''), array('readonly'=>false,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
                </tr>
                <tr>
                    <td>Diagnosa</td>
                    <td>:</td>
                    <td><?php echo CHtml::textArea('diagnosa',(!empty($_GET['pendaftaran_id']) ? $diagnosa : ''), array('readonly'=>false,
                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
                </tr>
            </table><br>
            <p align="justify"> Sehubungan dengan hasil pemeriksaan di atas dapat disimpulkan bahwa pasien membutuhkan istirahat/ cuti hamil mulai tanggal 
                            <div style="margin-top:-28px;margin-left:800px;"> 
                                <?php 
                                    $model->tglistirahat = $format->formatDateTimeForUser($model->tglistirahat);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tglistirahat',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
//                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true,'class'=>'span2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                ?>
                            </div> sampai tanggal perkiraan partus 
                            <div style="margin-top:-17px;margin-left:200px;"> 
                                <?php 
                                    $model->tglperkiraanpartus = $format->formatDateTimeForUser($model->tglperkiraanpartus);
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tglperkiraanpartus',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
//                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true,'class'=>'span2',
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                ?>
                            </div>
            </p>
            <br/><br/>
            <p align="justify">
                Demikianlah Surat Keterangan Cuti Hamil ini diperbuat untuk dapat dipergunakan seperlunya, atas kerjasamanya diucapkan Terima Kasih.
            </p>
        </p>
</div><br><br><br><br><br>
<div style="margin-left: 50px">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
<!--    (_________________)-->
<?php
    echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(PegawaiV::model()->findAll(array(
        'condition'=>'pegawai_aktif = true',
        'order'=>'nama_pegawai'
    )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
?>
</div>
</TABLE>