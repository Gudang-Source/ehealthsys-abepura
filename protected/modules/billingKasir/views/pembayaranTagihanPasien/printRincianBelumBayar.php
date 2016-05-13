<style>
    th, td, div{
        font-family: Arial;
        font-size: 10pt;
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
    }
    body{
        width: 100%;
        /* height: 11cm; */
    }
    .identitas{
        line-height: 12px;
    }
</style>
<?php
$format = new MyFormatter;
 echo $this->renderPartial('application.views.headerReport.headerRincian');
?>
<table class="identitas">
    <tr>
        <td>
            Instalasi
        </td>
        <td>: <b><?php echo $modInstalasi->instalasi_nama; ?></b></td>
    </tr>
    <tr>
        <td>No. Pendaftaan</td>
        <td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td></tr>
    <tr>
        <td nowrap>No. Rekam Medik</td>
        <td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>: <?php echo $modPendaftaran->pasien->namadepan." ".$modPendaftaran->pasien->nama_pasien;?></td></tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $modPendaftaran->pasien->alamat_pasien;?></td>
    </tr>
    <tr>
        <td>Tanggal </td><td>: <?php echo substr($format->formatDateTimeId($modPendaftaran->tgl_pendaftaran),0,-9);?></td>
<!--  dicomment karena RND-5888      <td>No. KPK : <?php echo (isset($modPendaftaran->no_asuransi)?$modPendaftaran->no_asuransi:"-"); ?></td>-->
    </tr>
</table>
<table width="100%">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Tanggal Tindakan</th>
        <th style='text-align: center;'>Jenis Pelayanan</th>
        <th style='text-align: center;'>Jumlah</th>
        <th style='text-align: center;'>Harga Satuan</th>
        <th style='text-align: center;'>Total</th>

    </thead>
    <tbody>
        <?php
        $no=1;
        $totalbiaya = 0;
        $subasuransi = 0;
        $subrs = 0;
        $subpemerintah = 0;
        
		if (count($modRincians) > 0 ){
			foreach($modRincians AS $i => $rincian):
				$totalbiaya += ($rincian->qty_tindakan*$rincian->tarif_satuan);
                                $subasuransi += $rincian->subsidiasuransi_tindakan;
                                $subrs += $rincian->subsisidirumahsakit_tindakan;
                                $subpemerintah += $rincian->subsidipemerintah_tindakan;
                        
				$tampilruangan = true;
					if((($rincian->tm)=='AP') or (($rincian->tm)=='OA')){
						$jenisPelayanan = $rincian->daftartindakan_nama;
					}else{
	//                   dicomment karena issue  RND-6042 $jenisPelayanan = $rincian->kategoritindakan_nama;
						$jenisPelayanan = $rincian->daftartindakan_nama;
					}
				echo "<tr style='border:1px solid;''>
				<td style='text-align:center;'>".$no."</td>
				<td style='text-align:left;'>".(MyFormatter::formatDateTimeForUser($rincian->tgl_tindakan))."</td>
				<td>".$jenisPelayanan."</td>
				<td style='text-align: center;'>".$rincian->qty_tindakan."</td>
				<td style='text-align: right;'>".(MyFormatter::formatNumberForPrint($rincian->tarif_satuan))."</td>
				<td style='text-align: right;'>".(MyFormatter::formatNumberForPrint($rincian->qty_tindakan*$rincian->tarif_satuan))."</td>      
			 </tr>";  
			$no++;
			endforeach;
		?>
		<?php } 
                
                $res = $totalbiaya - ($subasuransi + $subrs + $subpemerintah);
                
                ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Jumlah Biaya</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Subsidi Asuransi</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($subasuransi); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Subsidi Rumah Sakit</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($subrs); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Subsidi Pemeintah</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($subpemerintah); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Tanggungan Pasien</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($res); ?></td>
        </tr>
        <tr>
            <td colspan='6' align='center' style="font-style:italic; border: 1px solid black;">(<?php echo $format->formatNumberTerbilang($res); ?> rupiah)</td>
        </tr>
        <tr><td></td></tr>
        <tr><td colspan="2">
        <?php echo MyFormatter::formatDateTimeForUser(date("d-m-Y")); ?>&nbsp;&nbsp;<?php echo $modPendaftaran->carabayar->carabayar_nama;?></td>
        </tr>    
    </tfoot>
</table>
<table>
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan">Petugas</td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan"></td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>      
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan" style="height: 50px;">
                <b><?php echo empty($pegawai)?"-":$pegawai->nama_pegawai; ?></b>                
         </td>         
    </tr>
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan" style = "border-top: 2px solid #000;">                              
                <b>NIP. <?php echo empty($pegawai)?"-":$pegawai->nomorindukpegawai; ?></b>
         </td>         
    </tr>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianBelumBayar", array("instalasi_id"=>$_GET['instalasi_id'], "pendaftaran_id"=>$_GET['pendaftaran_id'], "pasienadmisi_id"=>(isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>","",'location=_new, width=1024px');
    }
    </script>

    
           <?php //echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?>

<?php
}
?>

