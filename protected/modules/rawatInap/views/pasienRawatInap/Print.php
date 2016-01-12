<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 11pt !important;
    }
    body{
        width: 21.7cm;
    }
</style>
<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); ?>
<?php $format = new MyFormatter(); ?>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>Tanggal Pendaftaran</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($modPasien->tgl_pendaftaran); ?></td>
		</tr>
		<tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo $modPasien->pasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>No. Pendaftara</td>
            <td>:</td>
            <td><?php echo $modPasien->no_pendaftaran; ?></td>
        </tr>
		<tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPasien->pasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>:</td>
            <td><?php echo isset($modPasien->umur) ? $modPasien->umur : ""; ?></td>
		</tr>
		<tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $modPasien->pasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>Kasus Penyakit</td>
            <td>:</td>
            <td><?php echo isset($modPasien->jeniskasuspenyakit_nama) ? $modPasien-jeniskasuspenyakit_nama : ""; ?></td>
		</tr>
		<tr>
            <td>Nama Alias</td>
            <td>:</td>
            <td><?php echo isset($modPasien->nama_bin) ? $modPasien-nama_bin : ""; ?></td>
        </tr>
		<tr>
			<td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
		</tr>
    </table>
    <table width="40%" style="margin:0px;" cellpadding="1" cellspacing="0">
		<tr>
			<td>Tanggal Pasien Pulang</td>
			<td>:</td>
			<td><?php echo $format->formatDateTimeForUser($modPulang->tglpasienpulang); ?></td>
		</tr>
		<tr>
			<td>Cara Keluar</td>
			<td>:</td>
			<td><?php echo $modPulang->carakeluar->carakeluar_nama; ?></td>
		</tr>
		<tr>
			<td>Kondisi Pulang</td>
			<td>:</td>
			<td><?php echo $modPulang->kondisikeluar->kondisikeluar_nama; ?></td>
		</tr>
		<tr>
			<td>Penerimaan Pasien</td>
			<td>:</td>
			<td><?php echo $modPulang->penerimapasien; ?></td>
        </tr>
		<tr>
			<td>Tanggal Masuk Kamar</td>
			<td>:</td>
			<td><?php echo $format->formatDateTimeForUser($modMasukKamar->tglmasukkamar); ?></td>
		</tr>
		<tr>
			<td>Tanggal Pulang Kamar</td>
			<td>:</td>
			<td><?php echo $format->formatDateTimeForUser($modMasukKamar->tglkeluarkamar); ?></td>
        </tr>
		<tr>
			<td>Jam Pulang Kamar</td>
			<td>:</td>
			<td><?php echo $modMasukKamar->jamkeluarkamar; ?></td>
		</tr>
		<tr>
			<td>Lama Dirawat</td>
			<td>:</td>
			<td><?php echo $modMasukKamar->lamadirawat_kamar; ?></td>
        </tr>
		<tr>
			<td>Hari Perawatan</td>
			<td>:</td>
			<td><?php echo $modPulang->hariperawatan; ?></td>
		</tr>
		<tr>
			<td>Keterangan Pulang</td>
			<td>:</td>
			<td><?php echo (!empty($modPulang->keterangankeluar) ? $modPulang->keterangankeluar : "-"); ?></td>
        </tr>		
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint)
	{
		var pasienpulang_id = '<?php echo isset($modelPulang->pasienpulang_id) ? $modelPulang->pasienpulang_id : null ?>';
		window.open('<?php echo $this->createUrl('printPasienPulang'); ?>&pasienpulang_id='+pasienpulang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
	}
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
    </table>
<?php } ?>
