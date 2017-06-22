<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 48px;
        border:1px solid #000;
    }
</style>
<table width="100%">
    <tr>
        <td nowrap><b>Nama Pasien / No. RM</b></td>
        <td>:</td><td width="100%"> <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td nowrap><b>No. Pendaftaran</b></td>
        <td>:</td><td> <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td><b>Umur</b></td>
        <td>:</td><td> <?php echo $modPendaftaran->umur; ?></td>
        <td><b>Alamat</b></td>
        <td>:</td><td nowrap> <?php echo $modPasien->alamat_pasien;?> <?php echo $modPasien->rt;?> <?php echo $modPasien->rw; ?></td>
    </tr>
</table>
<br>
<?php
    if (COUNT($modPersalinan)>0){
        echo "<h5>Persalinan</h5>";
    }
?>
<table width="100%" border ="1"  class = "content">
<?php 
$letakjanin = '';
if (COUNT($modPersalinan)>0){
foreach ($modPersalinan as $i => $persalinan){
    $letakjanin = $persalinan->posisijanin;
?>        
    <tr>
        <td nowrap><b>Dokter</b></td>
        <td width="33%"> <?php echo (isset($persalinan->pegawai_id) ? $persalinan->pegawai->namaLengkap :"-"); ?></td>
        <td nowrap><b>Tanggal Mulai Persalinan</b></td>
        <td width="33%"> <?php echo (isset($persalinan->tglmulaipersalinan) ? MyFormatter::formatDateTimeForUser($persalinan->tglmulaipersalinan) :"-"); ?></td>                
        <td nowrap><b>Jenis Kegiatan Persalinan</b></td>
        <td width="33%"> <?php echo (isset($persalinan->jeniskegiatanpersalinan) ? $persalinan->jeniskegiatanpersalinan :"-"); ?></td>
    </tr>
    <tr>
        <td><b>Bidan</b></td>
        <td> <?php echo (isset($persalinan->bidan_id) ? $persalinan->bidan->namaLengkap :"-"); ?></td>
        <td><b>Tanggal Selesai Persalinan</b></td>
        <td> <?php echo (isset($persalinan->tglselesaipersalinan) ? MyFormatter::formatDateTimeForUser($persalinan->tglselesaipersalinan) :"-"); ?></td>
        <td><b>Kegiatan Persalinan</b></td>
        <td> <?php echo  (isset($persalinan->kegiatanpersalinan_id) ? $persalinan->kegiatanpersalinan->kegiatanpersalinan_nama :"-"); ?></td>                
    </tr>
    <tr>
        <td><b>Bidan 2</b></td>
        <td> <?php echo (isset($persalinan->bidan2_id) ? $persalinan->bidan2->namaLengkap :"-"); ?></td>        
        <td><b>Lama Persalinan</b></td>
        <td> <?php echo (isset($persalinan->lamapersalinan_jam) ? $persalinan->lamapersalinan_jam :"-"); ?> Jam</td>       
        <td><b>Cara Persalinan</b></td>
        <td> <?php echo (isset($persalinan->carapersalinan) ? $persalinan->carapersalinan :"-"); ?></td>
    </tr>
    <tr>
        <td><b>Bidan 3</b></td>
        <td> <?php echo (isset($persalinan->bidan3_id) ? $persalinan->bidan3->namaLengkap :"-"); ?></td>
        <td><b>Tanggal Melahirkan</b></td>
        <td> <?php echo (isset($persalinan->tglmelahirkan) ? MyFormatter::formatDateTimeForUser($persalinan->tglmelahirkan) :"-"); ?></td>
        <td><b>Posisi Janin</b></td>
        <td> <?php echo  (isset($persalinan->posisijanin) ? $persalinan->posisijanin :"-"); ?></td>        
        
    </tr>
    <tr>
        <td><b>Paramedis</b></td>
        <td> <?php echo (isset($persalinan->paramedis_id) ? $persalinan->paramedis->namaLengkap :"-"); ?></td>
        <td><b>Lahir Di RS</b></td>
        <td> <?php 
                    if (isset($persalinan->islahirdirs))
                    {
                        if ($persalinan->islahirdirs == TRUE){
                            echo "Ya";
                        }else{
                            echo "Tidak";
                        }
                    }else{
                        echo '-';
                    }
        ?></td>  
        <td><b>Kelompok Sebab Abortus</b></td>
        <td> <?php echo (isset($persalinan->kelsebababortus_id) ? $persalinan->kelsebababortus->kelsebababortus_nama :"-"); ?></td>
    </tr>
    <tr>
        <td><b>Catatan Dokter</b></td>
        <td> <?php echo  (isset($persalinan->catatan_dokter) ? $persalinan->catatan_dokter :"-"); ?></td>
        <td><b>Keadaan Lahir</b></td>
        <td> <?php echo (isset($persalinan->keadaanlahir) ? $persalinan->keadaanlahir :"-"); ?></td>
        <td><b>Sebab Abortus</b></td>
        <td> <?php echo (isset($persalinan->sebababortus_id) ? $persalinan->sebababortus->sebababortus_nama :"-"); ?></td>              
    </tr>  
    <tr>
        <td colspan="2">&nbsp;</td>
        <td><b>Masa Gestasi</b></td>
        <td> <?php echo (isset($persalinan->masagestasi_minggu) ? $persalinan->masagestasi_minggu :"-"); ?> Minggu</td>
        <td><b>Sebab Kematian</b></td>
        <td> <?php echo  (isset($persalinan->sebabkematian) ? $persalinan->sebabkematian :"-"); ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td><b>Paritas</b></td>
        <td> <?php 
        
                if (isset($persalinan->paritaske)){
                    if (is_numeric($persalinan->paritaske)){
                        echo (isset($persalinan->paritaske) ? implode('',CustomFunction::getNomorUrutText($persalinan->paritaske,$persalinan->paritaske)) :"-");                         
                    }else{
                        echo  (isset($persalinan->paritaske) ?$persalinan->paritaske:'-'); //(isset($persalinan->paritaske) ? implode('',CustomFunction::getNomorUrutText($persalinan->paritaske,$persalinan->paritaske)) :"-"); 
                    }
                }
             ?></td>                
        <td><b>Tanggal Abortus</b></td>
        <td> <?php echo  (isset($persalinan->tglabortus) ? $persalinan->tglabortus :"-"); ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td><b>Jumlah Kelahiran Hidup</b></td>
        <td> <?php echo (isset($persalinan->jmlkelahiranhidup) ? $persalinan->jmlkelahiranhidup :"-"); ?> Orang</td>
        <td><b>Jumlah Abortus</b></td>
        <td> <?php echo  (isset($persalinan->jmlabortus) ? $persalinan->jmlabortus :"-"); ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td><b>Jumlah Kelahiran Mati</b></td>
        <td> <?php echo (isset($persalinan->jmlkelahiranmati) ? $persalinan->jmlkelahiranmati :"-"); ?> Orang</td>
        <td colspan="2">&nbsp;</td>
    </tr>
        
<?php }
}else{
?>
    <tr>
        <td colspan="9">* Tidak ada riwayat persalinan</td>
    </tr> 
<?php } ?>
</table> 
<p>&nbsp;</p>
<?php
    if (count($modPemeriksaan)>0){
?>
        <h5>Pemeriksaan Obsterikus</h5>
        <table width="100%" border ="1"  class = "content">
        <?php
            foreach($modPemeriksaan as $modPemeriksaan):
        ?>
        <tr>
            <td colspan = "6"><h6 style = "color:#000;">Status Obsterikus</h6></td>
        <tr>
        <tr>
            <td nowrap><b>Fundus Ufen</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->obs_fundusufen)?$modPemeriksaan->obs_fundusufen.' cm':'-'.' cm'; ?></td>
            <td nowrap><b>Pemeriksa</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->obs_pemeriksa)?$modPemeriksaan->obs_pemeriksa:'-'; ?></td>
            <td nowrap><b>Presentasi</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->presentasi_genitalia)?$modPemeriksaan->presentasi_genitalia:'-'; ?></td>
        </tr>
         <tr>
             <td><b>Letak Janin</b></td>
            <td><?php echo ($letakjanin!='')?$letakjanin:'-'; ?></td>
            <td><b>Warna Ketuban</b></td>
            <td><?php echo isset($modPemeriksaan->obs_warnaketuban)?$modPemeriksaan->obs_warnaketuban:'-'; ?></td>            
            <td><b>Denyut Jantung Janin</b></td>
            <td><?php echo isset($modPemeriksaan->denyutjantung_janin)?$modPemeriksaan->denyutjantung_janin:'-'; ?></td>
        </tr>
         <tr>
             <td><b>Pemeriksaan Dalam</b></td>
             <td><?php echo isset($modPemeriksaan->obs_periksadalam)?MyFormatter::formatDateTimeForUser($modPemeriksaan->obs_periksadalam):'-'; ?></td>
            <td><b>Warna Ketuban</b></td>
            <td><?php echo isset($modPemeriksaan->penurunan_genitalia)?$modPemeriksaan->penurunan_genitalia:'-'; ?></td>            
            <td><b>Frekuensi</b></td>
            <td><?php echo isset($modPemeriksaan->frek_auskultasi)?$modPemeriksaan->frek_auskultasi.' /menit':'-'; ?></td>                        
        </tr>
         <tr>
            <td><b>Portio</b></td> 
            <td><?php echo isset($modPemeriksaan->portio_genitalia)?$modPemeriksaan->portio_genitalia:'-'; ?></td>            
            <td><b>Hodge</b></td>
            <td><?php echo isset($modPemeriksaan->obs_hodge)?$modPemeriksaan->obs_hodge:'-'; ?></td>                 
            <td><b>Pemeriksaan</b></td>
            <td><?php echo isset($modPemeriksaan->obs_pemeriksaan)?$modPemeriksaan->obs_pemeriksaan:'-'; ?></td>
        </tr>
         <tr>
             <td><b>Konsistensi</b></td>
            <td><?php echo isset($modPemeriksaan->obs_konsistensigenitalia)?$modPemeriksaan->obs_konsistensigenitalia:'-'; ?></td>            
            <td><b>Posisi</b></td>
            <td><?php echo isset($modPemeriksaan->posisi_genitalia)?$modPemeriksaan->posisi_genitalia:'-'; ?></td>
            <td colspan = "2">&nbsp;</td>
        </tr>
         <tr>
            <td><b>Arah</b></td>
            <td><?php echo isset($modPemeriksaan->obs_arah)?$modPemeriksaan->obs_arah:'-'; ?></td>  
            <td><b>Imbang Fetovelfik</b></td>
            <td><?php echo isset($modPemeriksaan->obs_fetofelvik)?$modPemeriksaan->obs_fetofelvik:'-'; ?></td>
            <td colspan = "2">&nbsp;</td>
        </tr>
        <tr>
            <td nowrap><b>Ketuban</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->ketuban_genitalia)?$modPemeriksaan->ketuban_genitalia:'-'; ?></td>
            <td colspan = "4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan = "2"><b>Plasenta</b></td>
            <td colspan = "2"><b>Tali Pusar</b></td>
            <td colspan = "2"><b>Perlukaan Jalan Lahir</b></td>
        </tr>
        <tr>
            <td nowrap><b>Lahir</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->plasenta_lahir)?MyFormatter::formatDateTimeForUser($modPemeriksaan->plasenta_lahir):'-'; ?></td>
            <td nowrap><b>Insersi</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->pusar_insersi)?$modPemeriksaan->pusar_insersi:'-' ?></td>
            <td  nowrap><b>Luka Perineum</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->luka_perineum)?$modPemeriksaan->luka_perineum:'-' ?></td>
        </tr>
        <tr>
            <td><b>Spontanitas</b></td>
            <td><?php echo isset($modPemeriksaan->plasentaspontanitas)?$modPemeriksaan->plasentaspontanitas:'-'; ?></td>
            <td><b>Panjang</b></td>
            <td><?php echo isset($modPemeriksaan->pusar_panjang)?$modPemeriksaan->pusar_panjang.' cm':'-'.' cm' ?></td>
            <td><b>Luka Vagina</b></td>
            <td><?php echo isset($modPemeriksaan->luka_vagina)?$modPemeriksaan->luka_vagina:'-' ?></td>
        </tr>
        <tr>
            <td><b>Kelengkapan</b></td>
            <td><?php echo isset($modPemeriksaan->plasentakelengkapan)?$modPemeriksaan->plasentakelengkapan:'-'; ?></td>
            <td><b>Kelengkapan</b></td>
            <td><?php echo isset($modPemeriksaan->pusar_kelengkapan)?$modPemeriksaan->pusar_panjang.' cm':'-'.' cm' ?></td>
            <td><b>Luka Serviks</b></td>
            <td><?php echo isset($modPemeriksaan->luka_serviks)?$modPemeriksaan->luka_serviks:'-' ?></td>
        </tr>
        <tr>
            <td><b>Berat</b></td>
            <td><?php echo isset($modPemeriksaan->plasenta_berat)?$modPemeriksaan->plasenta_berat.' gram':'-'.' gram'; ?></td>
            <td><b>Robekan</b></td>
            <td><?php echo isset($modPemeriksaan->pusar_robekan)?$modPemeriksaan->pusar_robekan:'-'; ?></td>
            <td><b>Episiotomi</b></td>
            <td><?php echo isset($modPemeriksaan->episiotomi)?$modPemeriksaan->episiotomi:'-' ?></td>
        </tr>
         <tr>
            <td><b>Diameter</b></td>
            <td><?php echo isset($modPemeriksaan->plasenta_diameter)?$modPemeriksaan->plasenta_diameter.' gram':'-'.' gram'; ?></td>
            <td><b>Lain Lain</b></td>
            <td><?php echo isset($modPemeriksaan->pusar_lainlain)?$modPemeriksaan->pusar_lainlain:'-'; ?></td>
            <td><b>Ruptura Perinei</b></td>
            <td><?php echo isset($modPemeriksaan->rupturaperinei)?$modPemeriksaan->rupturaperinei:'-' ?></td>
        </tr>
        <tr>
            <td colspan = "6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan = "2"><b>Kala IV</b></td>
            <td colspan = "2"><b>Pendarahan</b></td>
            <td colspan = "2"><b>Nifas</b></td>
        </tr>
        <tr>
            <td nowrap><b>Anemia</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->kala4_anemia)?$modPemeriksaan->kala4_anemia:'-'; ?></td>
            <td nowrap><b>Kala III</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->pendarahan)?$modPemeriksaan->pendarahan:'-' ?></td>
            <td  nowrap><b>Inveksi</b></td>
            <td width="33%"><?php echo isset($modPemeriksaan->nifas_inveksi)?$modPemeriksaan->nifas_inveksi:'-' ?></td>
        </tr>
        <tr>
            <td><b>Tekanan Darah</b></td>
            <td><?php 
                $mm = '-';
                $hg = '';
                
                if (isset($modPemeriksaan->kala4_systolic)){
                    $mm = $modPemeriksaan->kala4_systolic;
                }
                
                if (isset($modPemeriksaan->kala4_diastolic)){
                    $hg = $modPemeriksaan->kala4_diastolic;
                }
                echo $mm.' Mm '.$hg.'Hg'.'     '.$tekananDarahText; ?>
            </td>
            <td colspan = "2">&nbsp;</td>            
            <td><b>Laktasi</b></td>
            <td><?php echo isset($modPemeriksaan->nifas_laktasi)?$modPemeriksaan->nifas_laktasi:'-' ?></td>
        </tr>
        <tr>
            <td><b>Mean Arteri Pressure</b></td>
            <td><?php 
                
                echo isset($modPemeriksaan->kala4_meanarteripressure)?$modPemeriksaan->kala4_meanarteripressure:'-'; ?>
            </td>
            <td colspan = "2">&nbsp;</td>            
            <td><b>Febris Puerperalis</b></td>
            <td><?php echo isset($modPemeriksaan->nifas_febris)?$modPemeriksaan->nifas_febris:'-' ?></td>
        </tr>
         <tr>
            <td><b>Detak Nadi</b></td>
            <td><?php 
                
                echo isset($modPemeriksaan->kala4_detaknadi)?$modPemeriksaan->kala4_detaknadi.' /Menit':'-'.' /Menit'; ?>
            </td>
            <td colspan = "2">&nbsp;</td>            
            <td><b>Lain Lain</b></td>
            <td><?php echo isset($modPemeriksaan->nifas_lainlain)?$modPemeriksaan->nifas_lainlain:'-' ?></td>
        </tr>
        <tr>
            <td><b>Pernapasan</b></td>
            <td><?php 
                
                echo isset($modPemeriksaan->kala4_pernapasan)?$modPemeriksaan->kala4_pernapasan.' /Menit':'-'.' /Menit'; ?>
            </td>
            <td colspan = "4">&nbsp;</td>                        
        </tr>
        <tr>
            <td><b>Tinggi Fundus Uteri</b></td>
            <td><?php 
                
                echo isset($modPemeriksaan->tinggifundus_uteri)?$modPemeriksaan->tinggifundus_uteri:'-'; ?>
            </td>
            <td colspan = "4">&nbsp;</td>                        
        </tr>
        <tr>
            <td><b>Kontraksi</b></td>
            <td><?php 
                
                echo isset($modPemeriksaan->kala4_kontraksi)?$modPemeriksaan->kala4_kontraksi:'-'; ?>
            </td>
            <td colspan = "4">&nbsp;</td>                        
        </tr>
        <?php
            endforeach;
        ?>
        </table>
		<br/>
		
<?php
    }
?>
		


<?php if (!empty($persalinan)) : ?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Print Partograf', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPartograf();return false",  )); ?>	
<script>
/**
 * print rincian belum bayar >> RND-3122
 * @returns {undefined} */ 
function printPartograf()
{
    window.open("<?php echo $this->createUrl('printDetailPartograf', array('persalinan_id'=>$persalinan->persalinan_id)); ?>","",'location=_new, width=1024px');

}
</script>
<?php endif; ?>