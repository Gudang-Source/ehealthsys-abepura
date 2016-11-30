<style>
        border th, .border td{
            border:1px solid #000;
        }
        .table thead:first-child{
            border-top:1px solid #000;        
        }

        thead th{
            background:none;
            color:#333;
        }

        .border {
            box-shadow:none;
        }

        .table tbody tr:hover td, .table tbody tr:hover th {
            background-color: none;
        }

        strong{
            font-size:11px;
        }

        b{
            font-size:11px;
        }
    
	.spasi1 {
		margin: 0px 0px 0px 10px;
	}

	.spasi2 {
		padding: 0px 0px 0px 20px;
	}
	.table-alergi, th {
		border: 1px solid black;
	}
</style>
<div class="white-container" style="box-shadow: none;">
	<?php
	if ($caraPrint == 'EXCEL') {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
		header('Cache-Control: max-age=0');
	}
	echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
	$no_urut = 1;
	$class = '';
	if (isset($_GET['frame'])) {
		$class = "table table-striped";
	}
	?>
	<table width="100%" class="spasi1">
		<tr>
			<td width="20%"><b>Nama</b></td>
			<td width="30%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="20%"><b>No. Rekam Medis</b></td>
			<td width="30%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%"><b>Umur</b></td>
			<td width="30%">: <?php echo (isset($modPendaftaran->umur) ? $modPendaftaran->umur : " - "); ?></td>
			<td width="20%"><b>Ruangan</b></td>
			<td width="30%">: <?php echo isset($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%"><b>Tgl. Masuk RS</b></td>
			<td width="30%">: <?php echo isset($modPendaftaran->tgl_pendaftaran) ? date('d-m-Y', strtotime($modPendaftaran->tgl_pendaftaran)) : " - "; ?></td>
			<td width="20%"><b>Jam</b></td>
			<td width="30%">: <?php echo isset($modPendaftaran->tgl_pendaftaran) ? date('H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)) : " - "; ?></td>
		</tr>
	</table>
	<?php $this->renderPartial('_PrintPage1', array('modAnamnesa' => $modAnamnesa, 'modPeriksaFisik' => $modPeriksaFisik)); ?>
	<?php $this->renderPartial('_PrintPage2', array('modAnamnesa' => $modAnamnesa, 'modPeriksaFisik' => $modPeriksaFisik)); ?>
	<?php $this->renderPartial('_PrintPage3', array('modAnamnesa' => $modAnamnesa, 'modPeriksaFisik' => $modPeriksaFisik, 'modPenanggungJawab'=>$modPenanggungJawab)); ?>
</div>
