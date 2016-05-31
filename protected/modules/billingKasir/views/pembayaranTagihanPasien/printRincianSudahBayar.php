<style>
    body{
        width: 100%;
        /* height: 11cm; */
    }
    .identitas{
        line-height: 12px;
    }
    
    .rincian th, .rincian td {
        border: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
    }
    
    .rincian tfoot td {
        font-weight: bold;
    }
    
    
    .table-rincian td, th{
        border: solid #000 1px;
    }
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}

$pasien = $modPendaftaran->pasien;
$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
$asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);



$grp = array();

$suba = 0;
$subp = 0;
$subr = 0;
$subtotalkotor = 0;
$subtotal = 0;

foreach ($modRincians as $item) {
    
    $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
    $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    
    if (empty($grp[$item->ruangan_id])) {
        $grp[$item->ruangan_id] = array(
            'nama'=>$item->ruangan_nama,
            'content'=>array(),
        );
    }
    
    
    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;
    
    $subtotalkotor += $item->qty_tindakan * $item->tarif_satuan;
    $subtotal += ($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
    
    array_push($grp[$item->ruangan_id]['content'], array(
        'uraian'=>$item->daftartindakan_nama,
        'dokter'=>$dokter,
        'tgl'=>  MyFormatter::formatDateTimeForUser($item->tgl_tindakan),
        'jml'=> $item->qty_tindakan,
        'harga'=> MyFormatter::formatNumberForPrint($item->tarif_satuan),
        'suba'=>MyFormatter::formatNumberForPrint($item->subsidiasuransi_tindakan),
        'subp'=>MyFormatter::formatNumberForPrint($item->subsidipemerintah_tindakan),
        'subr'=>MyFormatter::formatNumberForPrint($item->subsisidirumahsakit_tindakan),
        'subtotal'=>MyFormatter::formatNumberForPrint(($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
    ));
}

?>




<table class="identitas" width="100%">
    <tr>
        <td>Cara Bayar</td><td>:</td><td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
        <td>Kelas Pelayanan</td><td>:</td><td><?php echo !empty($modPendaftaran->pasienadmisi_id)?$admisi->kelaspelayanan->kelaspelayanan_nama:$modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Penjamin</td><td>:</td><td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        <?php if (!empty($asuransi)): ?><td nowrap>Kelas Tanggungan</td><td>:</td><td><?php echo $asuransi->kelastanggunganasuransi->kelaspelayanan_nama; ?></td><?php endif; ?>
    </tr>
    <tr>
        <td>Banyaknya</td><td>:</td><td><?php echo MyFormatter::formatNumberForPrint($subtotalkotor); ?></td>
    </tr>
    <tr>
        <td>Terbilang</td><td>:</td><td><?php echo $subtotalkotor==0?"NOL RUPIAH":strtoupper(MyFormatter::formatNumberTerbilang($subtotalkotor))." RUPIAH"; ?></td>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td><td>:</td><td width="100%"><?php echo $pasien->no_rekam_medik; ?></td>
        <td>Tgl. Pendaftaran</td><td>:</td><td nowrap><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td nowrap><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
        <td>No. Pendaftaran</td><td>:</td><td nowrap><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
        <td>Ruangan</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->ruangan->ruangan_nama:$admisi->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td nowrap><?php echo $pasien->no_rekam_medik; ?></td>
        
        <?php if (!empty($modPendaftaran->pasienadmisi_id)): ?> 
        <td nowrap>Kamar / No. Bed</td><td>:</td><td nowrap><?php echo empty($admisi->kamarruangan_id)?"-":($admisi->kamarruangan->kamarruangan_nokamar." / ".$admisi->kamarruangan->kamarruangan_nobed); ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Dokter</td><td>:</td><td nowrap><?php echo $modPendaftaran->pegawai->namaLengkap; ?></td>
        <?php if (!empty($modPendaftaran->pasienadmisi_id)): ?> 
        <td>Dokter PJP</td><td>:</td><td nowrap><?php echo $admisi->pegawai->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
</table>
<br/>

<table width="100%" class="rincian">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Uraian</th>
        <th style='text-align: center;'>Dokter</th>
        <th style='text-align: center;'>Tgl Transaksi</th>
        <th style='text-align: center;'>Jml</th>
        <th style='text-align: center;'>Harga</th>
        <th style='text-align: center;'>Subsidi Asuransi</th>
        <th style='text-align: center;'>Subsidi Pemerintah</th>
        <th style='text-align: center;'>Subsidi RS</th>
        <th style='text-align: center;'>Subtotal</th>
    </thead>
    <tbody>
        <?php foreach ($grp as $item) : ?>
        <tr>
            <td colspan="10"><strong><?php echo $item['nama']; ?></strong></td>
        </tr>
            <?php 
            $cnt = 0;
            foreach ($item['content'] as $item2) : 
                $cnt++;
            ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $item2['uraian']; ?></td>
                <td><?php echo $item2['dokter']; ?></td>
                <td><?php echo $item2['tgl']; ?></td>
                <td style="text-align: right;"><?php echo $item2['jml']; ?></td>
                <td style="text-align: right;"><?php echo $item2['harga']; ?></td>
                <td style="text-align: right;"><?php echo $item2['suba']; ?></td>
                <td style="text-align: right;"><?php echo $item2['subp']; ?></td>
                <td style="text-align: right;"><?php echo $item2['subr']; ?></td>
                <td style="text-align: right;"><?php echo $item2['subtotal']; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">Total Keseluruhan</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($suba); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>
        </tr>
    </tfoot>
    
</table>
<br/><br/>

<?php /*
<div style='width:100%; text-align: center; font-weight: bold;'>  BUKTI PEMBAYARAN </div>
<table width="100%">
    <tr>
        <td>No. Urut</td><td>: <?php echo "-"?></td>
        <td>No. Rekam Medis</td><td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td><td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
        <td>Tanggal Masuk RS</td><td>: <?php echo date("d-m-Y",strtotime($modPendaftaran->tgl_pendaftaran));?></td>
    </tr>
    <tr>
        <td>Nama/Umur</td><td>: <?php echo $modPendaftaran->pasien->namadepan." ".$modPendaftaran->pasien->nama_pasien."/".$modPendaftaran->umur;?></td>
        <td>Tanggal Keluar</td><td>: <?php 
		if(count($modRincians) > 0) {
			echo date("d-m-Y",strtotime($modRincians[count($modRincians)-1]->tgl_tindakan));
		}else{
			echo "-";
		} ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>: <?php echo $modPendaftaran->pasien->alamat_pasien;?></td>
        <td></td><td></td>
    </tr>
	<tr>
        <td>Cara Bayar</td><td>: <?php echo $modPendaftaran->carabayar->carabayar_nama;?></td>
        <td>Penjamin</td><td>: <?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
    </tr>
</table>
 * 
 */ ?>
<?php /*
<table width='100%' cellpadding='2px' class='table-rincian'>
    <thead>
        <th>Tanggal</th>
        <th>Uraian</th>
        <th>Banyaknya</th>
        <th>Harga Satuan</th>
        <th>Jumlah</th>
    </thead>
    <tbody>
        <?php 
        $totalbiaya = 0;
        foreach($modRincians AS $i => $rincian) {
            $totalbiaya += ($rincian->qty_tindakan*$rincian->tarif_satuan);
            $tampilruangan = true;
            if($i > 0){
                if($modRincians[$i]->ruangan_id == $modRincians[$i-1]->ruangan_id){
                    $tampilruangan = false;
                }else{
                    $tampilruangan = true;
                }
            }
            if($tampilruangan){
        ?>
                <tr>
                    <td></td>
                    <td colspan='4'><b><?php echo $rincian->instalasi_nama." - ".$rincian->ruangan_nama; ?></b></td>
                </tr>
        <?php 
            }
        ?>
        <tr>
            <td align='right'><?php echo date("d-m-Y",strtotime($rincian->tgl_tindakan)); ?></td>
            <td><?php echo $rincian->daftartindakan_nama; ?></td>
            <td align='right'><?php echo $rincian->qty_tindakan; ?></td>
            <td align='right'><?php echo $format->formatNumberForPrint($rincian->tarif_satuan); ?></td>
            <td align='right'><?php echo $format->formatNumberForPrint($rincian->qty_tindakan*$rincian->tarif_satuan); ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' align='left' style="font-weight:bold;">Jumlah Biaya</td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
        </tr>
        <tr>
            <td colspan='4' align='left' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
            <td></td>
        </tr>
    </tfoot>
</table>
*/ ?>

<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}else{
?>    
    <table width='100%'>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td align='center'>Verifikasi</td>
            <td align='center'>Yang membayar</td>
            <td align='center'>Kasir</td>
        </tr>
        <tr height='100px'>
            <td align='center'>__________________</td>
            <td align='center'>__________________</td>
            <td align='center'><?php echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
        </tr>
    </table>
<?php
}
?>

