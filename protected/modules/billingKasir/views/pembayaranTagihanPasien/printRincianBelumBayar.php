<style>
    th, td, div{
        font-family: Arial;
        font-size: 9.7pt;
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
    }
    body{
        width: 10cm;
        height: 11cm;
    }
    .identitas{
        line-height: 10px;
    }
</style>
<?php
$format = new MyFormatter;
 echo $this->renderPartial('application.views.headerReport.headerRincian');
?>
<table class="identitas">
    <tr>
        <td>
            Ruang / Instalasi : <b><?php echo $modPendaftaran->instalasi->instalasi_nama; ?></b>
        </td>
    </tr>
    <tr>
        <td>No. Pendaftaan
            :  <?php echo $modPendaftaran->no_pendaftaran; ?></td></tr>
    <tr>
        <td>No. Rekam Medik
        :  <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Nama
            : <?php echo $modPendaftaran->pasien->namadepan." ".$modPendaftaran->pasien->nama_pasien;?></td></tr>
    <tr>
        <td>Alamat
            : <?php echo $modPendaftaran->pasien->alamat_pasien;?></td>
    </tr>
    <tr>
        <td>Tanggal : <?php echo substr($format->formatDateTimeId($modPendaftaran->tgl_pendaftaran),0,-9);?></td>
<!--  dicomment karena RND-5888      <td>No. KPK : <?php echo (isset($modPendaftaran->no_asuransi)?$modPendaftaran->no_asuransi:"-"); ?></td>-->
    </tr>
</table>
<table>
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
		if (count($modRincians) > 0 ){
			foreach($modRincians AS $i => $rincian):
				$totalbiaya += ($rincian->qty_tindakan*$rincian->tarif_satuan);
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
				<td style='text-align: center;'>".(MyFormatter::formatNumberForPrint($rincian->tarif_satuan))."</td>
				<td style='text-align: center;'>".(MyFormatter::formatNumberForPrint($rincian->qty_tindakan*$rincian->tarif_satuan))."</td>      
			 </tr>";  
			$no++;
			endforeach;
		?>
		<?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' align='right' style="font-weight:bold;">Jumlah Biaya</td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='center' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
        </tr>
        <tr><td></td></tr>
        <tr><td colspan="2">
        <?php echo date("d-m-Y"); ?>&nbsp;&nbsp;<?php echo $modPendaftaran->carabayar->carabayar_nama;?></td>
        </tr>    
    </tfoot>
</table>
<br/>
<br/>
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
         <td class="tandatangan" style="height: 50px;">.........................</td>
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

