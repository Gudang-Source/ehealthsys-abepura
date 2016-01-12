<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
$format = new MyFormatter();

$pendaftaran_id = $model->pendaftaran_id;
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
        <TABLE ALIGN="CENTER">
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN CUTI PASCA MELAHIRKAN"; ?></U></FONT></B>
                </TD>
            </TR>
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Liberation Serif" SIZE=4>NO : <?php echo $model->nomorsurat; ?></FONT></B>
                </TD>
            </TR>
        </TABLE>
    </div>
    </br><br><br><br>
    <div>        
    <p align="justify">
        Saya yang bertanda tangan dibawah ini, Dokter <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="50%" style="margin-left:100px;width:auto;">
            <tr>
                <td style='padding-right: 70px;'>Nama</td>
                <td>:</td>
                <td><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td style='padding-right: 70px;'>Umur/Tgl. lahir</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->umur." / ".$modPasien->tanggal_lahir ?></td>
            </tr>
            <tr>
                <td style='padding-right: 70px;'>No. RK</td>
                <td>:</td>
                <td><?php echo $modPasien->no_rekam_medik; ?></td>
            </tr>
            <tr>
                <td style='padding-right: 70px;'>Alamat</td>
                <td>:</td>
                <td><?php echo $modPasien->alamat_pasien; ?></td>
            </tr>
        </table>
        <p align="justify">
            Berdasarkan hasil pemeriksaan dokter dapat diinformasikan sebagai berikut :
            <br/>
            <table width="35%" style="margin-left:100px;width:auto;">
                <tr>
                    <td style='padding-right: 50px;'>Tekanan Darah</td>
                    <td>:</td>
                    <td><?php echo (!empty($tekanan_darah) ? $tekanan_darah : "-"); ?></td>
                </tr>
                <tr>
                    <td syle='padding-right: 50px;'>Tempratur</td>
                    <td>:</td>
                    <td><?php echo (!empty($tempratur) ? $tempratur : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 50px;'>Pols</td>
                    <td>:</td>
                    <td><?php echo (!empty($pols) ? $pols : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 50px;'>RR</td>
                    <td>:</td>
                    <td><?php echo (!empty($rr) ? $rr : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 50px;'>Usia Kehamilan</td>
                    <td>:</td>
                    <td><?php echo (!empty($model->usiakehamilan) ? $model->usiakehamilan : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 50px;'>Pemeriksaan Lain</td>
                    <td>:</td>
                    <td><?php echo (!empty($pemeriksaan_lain) ? $pemeriksaan_lain : "-"); ?></td>
                </tr>
                <tr>
                    <td style='padding-right: 50px;'>Diagnosa</td>
                    <td>:</td>
                    <td><?php echo (!empty($diagnosa) ? $diagnosa : "-"); ?></td>
                </tr>
            </table><br>
            <p align="justify">
                Sehubungan dengan hasil pemeriksaan di atas dapat disimpulkan bahwa pasien membutuhkan istirahat/ cuti pasca melahirkan selama <u><?php echo $model->lamaistirahat; ?></u> hari.
            </p>
            <br/>
            <p align="justify">
                Demikianlah Surat Keterangan Cuti Pasca Melahirkan ini diperbuat untuk dapat dipergunakan seperlunya, atas kerjasamanya diucapkan Terima Kasih.
            </p>
        </p>
</div><br><br><br><br><br>
<div style="margin-left:400px;text-align: center;">
    <?php $date = date('Y-m-d'); ?>
    <?php echo $data->kabupaten->kabupaten_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?>
<br><br><br><br><br>
    <?php echo (!empty($model->mengetahui_surat) ? "<u><b>".$model->mengetahui_surat."</b></u>" : " _________________ " ) ; ?>
</div>
</TABLE>