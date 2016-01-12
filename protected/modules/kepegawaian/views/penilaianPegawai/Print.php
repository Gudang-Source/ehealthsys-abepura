<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  
<?php
$format = new MyFormatter;
echo $this->renderPartial('_headerPrint'); 
?>
<table width="100%">
	<tr>
		<td align="center" valig="middle" colspan="3">
			<b><?php echo $judul_print ?></b>
		</td>
	</tr>
</table>
<br><br>
<style>
	.a{
		font-weight: bold;
	}
</style>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
	<tr>
		<td width="15%" class="a">NIP</td>
		<td width="35%">: <?php echo $modPenilaianPegawai->pegawai->nomorindukpegawai; ?></td>
		<td width="15%" class="a">Jenis Kelamin</td>
		<td width="35%">: <?php echo $modPenilaianPegawai->pegawai->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td width="15%" class="a">Nama Pegawai</td>
		<td width="35%">: <?php echo $modPenilaianPegawai->pegawai->nama_pegawai; ?></td>
		<td width="15%" class="a">Status Perkawinan</td>
		<td width="35%">: <?php echo $modPenilaianPegawai->pegawai->statusperkawinan; ?></td>
	</tr>
	<tr>
		<td width="15%" class="a">Tempat Lahir</td>
		<td width="35%">: <?php echo $modPenilaianPegawai->pegawai->tempatlahir_pegawai; ?></td>
		<td width="15%" class="a">Jabatan</td>
		<td width="35%">: <?php echo isset($modPenilaianPegawai->pegawai->jabatan_id)?$modPenilaianPegawai->pegawai->jabatan->jabatan_nama:' - '; ?></td>
	</tr>
	<tr>
		<td width="15%" class="a">Tanggal Lahir</td>
		<td width="35%">: <?php echo $modPenilaianPegawai->pegawai->tgl_lahirpegawai; ?></td>
		<td width="15%" class="a">Alamat</td>
		<td width="35%">: <?php echo isset($modPenilaianPegawai->pegawai->alamat_pegawai)?$modPenilaianPegawai->pegawai->alamat_pegawai:' - '; ?></td>
	</tr>
</table>
<br><br>
<style>
	.tablepenilaian tr th{
		text-align: center;
		vertical-align: middle;
	}
</style>
<table class="table table-striped table-bordered table-condensed tablepenilaian">
	<thead>
		<tr>
			<th colspan="4" rowspan="2" >BERILAH TANDA (.) PADA KOLOM RATING SESUAI PENDAPAT ANDA</th>
		</tr>
		<tr></tr>
		<tr>
			<th width="20%">Jenis Penilaian</th>
			<th width="20%">Kompetensi</th>
			<th width="20%">Indikator Perilaku</th>
			<th width="40%">Uraian <span class="required">*</span></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($modPenilaianPegawaiDet)>0){
			foreach($modPenilaianPegawaiDet as $ii =>$modPenilaianPegawaiDe){
				echo "<tr>";
					echo "<td>".$modPenilaianPegawaiDe->jenispenilaian->jenispenilaian_nama."</td>";
					echo "<td>".$modPenilaianPegawaiDe->kompetensi->kompetensi_nama."</td>";
					echo "<td>".$modPenilaianPegawaiDe->indikatorperilaku->indikatorperilaku_nama."</td>";
					echo "<td>".$modPenilaianPegawaiDe->kolomrating->kolomrating_uraian."</td>";
				echo "</tr>";
			}
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan='4'>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" style='text-align: right; font-weight: bold'>Total Score Level</td>
			<td><?php echo $modPenilaianPegawai->jumlahpenilaian ?></td>
		</tr>
		<tr>
			<td colspan="3" style='text-align: right; font-weight: bold'>Rata-rata Level</td>
			<td><?php echo $modPenilaianPegawai->nilairatapenilaian ?></td>
		</tr>
		<tr>
			<td colspan="3" style='text-align: right; font-weight: bold'>Level KKJ</td>
			<td><?php echo $modPenilaianPegawai->performanceindex ?></td>
		</tr>
		<tr>
			<td colspan="3" style='text-align: right; font-weight: bold'>Saran</td>
			<td><?php echo $modPenilaianPegawai->keterangan_score ?></td>
		</tr>
	</tfoot>
</table>
<br><br>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
	<tr>
		<td width="10%" class="a">Tanggal Penilaian</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->tglpenilaian; ?></td>
		<td width="10%" class="a">Keterangan Penilaian Pegawai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->penilaianpegawai_keterangan; ?></td>
		<td width="10%" class="a">Nama Pimpinan</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->pimpinannama; ?></td>
	</tr>
	<tr>
		<td width="10%" class="a">Tanggal Tanggapan Pejabat</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->tanggal_tanggapanpejabat; ?></td>
		<td width="10%" class="a">Tanggal Diterima Pegawai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->diterimatanggalpegawai; ?></td>
		<td width="10%" class="a">NIP Pimpinan</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->pimpinannip; ?></td>
	</tr>
	<tr>
		<td width="10%" class="a">Tanggapan Pejabat</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->tanggapanpejabat; ?></td>
		<td width="10%" class="a">Tanggal Diterima Atasan</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->diterimatanggalatasan; ?></td>
		<td width="10%" class="a">Jabatan Pimpinan</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->pimpinanjabatan; ?></td>
	</tr>
	<tr>
		<td width="10%" class="a">Tanggal Keputusan Atasan</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->tanggal_keputusanatasan; ?></td>
		<td width="10%" class="a">Nama Penilai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->penilainama; ?></td>
		<td width="10%" class="a">Unit Organisasi Pimpinan</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->pimpinanunitorganisasi; ?></td>
	</tr>
	<tr>
		<td width="10%" class="a">Keputusan Atasan</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->keputusanatasan; ?></td>
		<td width="10%" class="a">NIP Penilai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->penilainip; ?></td>
		<td width="10%" class="a"></td>
		<td width="23%"></td>
	</tr>
	<tr>
		<td width="10%" class="a">Tanggal Keberatan Pegawai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->tanggal_keberatanpegawai; ?></td>
		<td width="10%" class="a">Jabatan Penilai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->penilaijabatan; ?></td>
		<td width="10%" class="a"></td>
		<td width="23%"></td>
	</tr>
	<tr>
		<td width="10%" class="a">Keberatan Pegawai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->keberatanpegawai; ?></td>
		<td width="10%" class="a">Unit Organisasi Penilai</td>
		<td width="23%">: <?php echo $modPenilaianPegawai->penilaiunitorganisasi; ?></td>
		<td width="10%" class="a"></td>
		<td width="23%"></td>
	</tr>
</table>