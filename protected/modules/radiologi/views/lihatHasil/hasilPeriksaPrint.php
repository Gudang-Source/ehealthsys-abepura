<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);?>
<?php $i = $_GET['i'];?>
<style>
    td .isi_hasil{
        height:5em;
        width:100px;
        text-align: left;
        vertical-align: top;
        border:1px solid;
        font-size: 11pt;
        font-family: Arial;
    }
    td .isi_hasil p {
        font-size: 11pt; 
        font-family: Arial;
    }
    .label_hasil{
        /*height:100px;*/
        width:20%;
        text-align: left;
        vertical-align: top;
        border:1px solid;
        font-size: 11pt; 
        font-family: Arial;
    }
</style>
<?php  //echo $this->renderPartial('application.views.headerReport.headerDefaultSurat');
       echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
<table style="width:100%;">
    <tr><td height="150px"></td></tr>
    <tr>
        <td>
            <center>
                <h3 style="font-family: Arial; font-size: 10pt;">HASIL PEMERIKSAAN RADIOLOGI</h3>
            </center><br/>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" style="font-family: Arial; font-size: 9pt;">
                <tr>
<!--                    <td>Tgl. Masuk</td><td width="45%">: <?php // echo $modPasienMasukPenunjang->tglmasukpenunjang; ?></td>-->
                    <td>Tgl. Pemeriksaan</td><td>: <?php echo $detailHasil[0]->tglpemeriksaanrad; ?></td>
                    <td>Alamat Pasien</td><td width="25%">: <?php echo $modPasienMasukPenunjang->alamat_pasien; ?></td>
                </tr>
                <tr>
                    <td>No. Rekam Medis</td><td>: <?php echo $modPasienMasukPenunjang->no_rekam_medik; ?></td>
                    <td>No. Pendaftaran</td><td>: <?php echo $modPasienMasukPenunjang->no_pendaftaran; ?></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td><td>: <?php echo $modPasienMasukPenunjang->nama_pasien; ?></td>
                    <td>No. Penunjang</td><td>: <?php echo $modPasienMasukPenunjang->no_masukpenunjang; ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td><td>: <?php echo $modPasienMasukPenunjang->jeniskelamin; ?></td>
<!--                    <td>Penjamin</td><td>: <?php // echo $modPasienMasukPenunjang->penjamin_nama; ?></td>-->
                    <td>Cara Bayar /Penjamin</td><td>: <?php echo $modPasienMasukPenunjang->carabayar_nama.' / '.$modPasienMasukPenunjang->penjamin_nama; ?></td>
                </tr>
                <tr>
                    <td>Umur</td><td>: <?php echo $modPasienMasukPenunjang->umur; ?></td>
                    <td>Dokter Perujuk</td><td>: <?php echo $modPasienMasukPenunjang->namaperujuk; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style=" margin:4px auto;">
            <?php // foreach($detailHasil as $i=>$detail): ?>
                <table style="border:1px solid #000; margin:4px auto;"  width="100%">
                    <tr style="border-bottom: 1px solid #000;">
                        <th colspan="3" style="font-family: Arial; font-size: 14pt;">Pemeriksaan : <?php echo $detailHasil[$i]->pemeriksaanrad->pemeriksaanrad_nama; ?></th>
                    </tr>
                    <tr>
                        <td class="label_hasil">Hasil Expertise</td>
                        <td class="isi_hasil"><?php echo $detailHasil[$i]->hasilexpertise; ?></td>
                    </tr>
                    <tr>
                        <td class="label_hasil" >Kesan</td>
                        <td class="isi_hasil"><?php echo $detailHasil[$i]->kesan_hasilrad; ?></td>
                    </tr>
                    <tr>
                        <td class="label_hasil">Kesimpulan</td>
                        <td class="isi_hasil"><?php echo $detailHasil[$i]->kesimpulan_hasilrad; ?></td>
                    </tr>
                </table>
            <?php // endforeach; ?>
        </td>
    </tr>
</table>
<table style="width:100%;" style="font-family: Arial; font-size: 11pt;">
    <tr  style="height:100px;">
        <td style="width:50%; vertical-align: top;">
                        <?php // echo $data->kabupaten->kabupaten_nama.', '.Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d'), 'yyyy-MM-dd'),'long',null); ?> 
            <?php echo $data->kabupaten->kabupaten_nama.', '.Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d'), 'yyyy-MM-dd'),'long',null); ?> 
        </td>
        <td style="width:50%; vertical-align: top; text-align: center;">
            Pemeriksa,
        </td>
    </tr>
    <tr>
        <td>
            Dicetak oleh: <?php echo LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai; ?><br>
            <?php echo date('Y/m/d H:i:s'); ?>
        </td>
        <td><center><?php echo
//                            PendaftaranT::model()->findByPK($detailHasil[0]->pendaftaran_id)->pegawai->NamaLengkap; 
                $pemeriksa->NamaLengkap;
        ?></center></td>
    </tr>
</table>