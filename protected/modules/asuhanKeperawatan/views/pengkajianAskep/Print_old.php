<style>
	.spasi1 {
		margin: 0px 0px 0px 10px;
	}
	
	.spasi2 {
		padding: 0px 0px 0px 20px;
	}
</style>
<div class="white-container">
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
	<?php echo '<strong>I. IDENTITAS</strong>'; ?>
	<br>
	<br>
	<?php echo 'A. PASIEN'; ?>
    <table width="100%" class="spasi1">
		<tr>
			<td width="20%">Nama</td>
			<td width="30%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="20%">No. Rekam Medis</td>
			<td width="30%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%">Umur</td>
			<td width="30%">: <?php echo (isset($modPendaftaran->umur) ? $modPendaftaran->umur : " - "); ?></td>
			<td width="20%">Ruang / Kelas</td>
			<td width="30%">: <?php echo isset($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : " - " . ' / ' . (isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : " - " ); ?></td>
		</tr>
		<tr>
			<td width="20%">Jenis Kelamin</td>
			<td width="30%">: <?php echo (isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : " - "); ?></td>
			<td width="20%">Diagnosa Medis</td>
			<td width="30%">: <?php echo isset($modDiagnosa->diagnosa_nama) ? $modDiagnosa->diagnosa_nama : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%">Agama</td>
			<td width="30%">: <?php echo (isset($modPasien->agama) ? $modPasien->agama : " - "); ?></td>
			<td width="20%">Tgl. Masuk RS</td>
			<td width="30%">: <?php echo isset($modPendaftaran->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) : " - "; ?></td>
		</tr>
		<tr>
			<td width="20%">Pendidikan / Pekerjaan</td>
			<td width="30%">: <?php echo isset($modPasien->pendidikan->pendidikan_nama) ? $modPasien->pendidikan->pendidikan_nama : " - " . ' / ' . (isset($modPasien->pekerjaan->pekerjaan_nama) ? $modPasien->pekerjaan->pekerjaan_nama : " - " ); ?></td>
			<td width="20%">Alamat</td>
			<td width="30%">: <?php echo isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : " - "; ?></td>
		</tr>
	</table>
	<br>
	<?php echo 'B. PENANGGUNG JAWAB'; ?>
	<table width ='100%' class="spasi1">
		<tr>
			<td width="20%">Nama</td>
			<td width="30%">: <?php echo (isset($modPenanggungJawab->nama_pj) ? $modPenanggungJawab->nama_pj : " - "); ?></td>
			<td width="20%">No. Tlp / No. Mobile</td>
			<td width="30%">: <?php echo isset($modPenanggungJawab->no_teleponpj) ? $modPenanggungJawab->no_teleponpj : " - " . ' / ' . (isset($modPenanggungJawab->no_mobilepj) ? $modPenanggungJawab->no_mobilepj : " - " ); ?></td>
		</tr>
		<tr>
			<td width="20%">No. Identitas</td>
			<td width="30%">: <?php echo (isset($modPenanggungJawab->no_identitas) ? $modPenanggungJawab->no_identitas : " - "); ?></td>
			<td width="20%">Hubungan Dengan Klien</td>
			<td width="30%">: <?php echo (isset($modPenanggungJawab->hubungankeluarga) ? $modPenanggungJawab->hubungankeluarga : " - "); ?></td>
		</tr>
		<tr>
			<td width="20%">Jenis Kelamin</td>
			<td width="30%">: <?php echo (isset($modPenanggungJawab->jeniskelamin) ? $modPenanggungJawab->jeniskelamin : " - "); ?></td>
			<td width="20%">Alamat</td>
			<td width="30%">: <?php echo (isset($modPenanggungJawab->alamat_pj) ? $modPenanggungJawab->alamat_pj : " - "); ?></td>
		</tr>
	</table>
	<br>
	<?php echo '<strong>II. RIWAYAT KESEHATAN</strong>'; ?>
	<table width ='100%' class="spasi1">
		<tr>
			<td width="50%">1. Riwayat Kesehatan Masa Lalu</td>
			<td width="50%">: <?php echo (isset($modAnamnesa->riwayatpenyakitterdahulu) ? $modAnamnesa->riwayatpenyakitterdahulu : " - "); ?></td>
		</tr>
		<tr>
			<td width="50%">2. Riwayat Kesehatan Keluarga</td>
			<td width="50%">: <?php echo (isset($modAnamnesa->riwayatpenyakitkeluarga) ? $modAnamnesa->riwayatpenyakitkeluarga : " - "); ?></td>
		</tr>
		<tr>
			<td width="50%">3. Pola Aktivitas, Istirahat/Tidur</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">a. Pola Nutrisi</td>
			<td width="50%" class="spasi2">: <?php echo isset($modAnamnesa->riwayatmakanan) ? $modAnamnesa->riwayatmakanan : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">b. Pola Istirahat/Tidur</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_polatidur', array('value' => 'Pagi')); ?> Pagi
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_polatidur', array('value' => 'Siang')); ?> Siang
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_polatidur', array('value' => 'Malam')); ?> Malam</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">Keluhan</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPengkajian->pengkajianaskep_keluhanpolatid) ? $modPengkajian->pengkajianaskep_keluhanpolatid : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">c. Pola Aktivitas</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_aktsehari', array('value' => 'Dibantu')); ?> Dibantu
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_aktsehari', array('value' => 'Dilakukan Sendiri')); ?> Dilakukan Sendiri</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">Keluhan</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPengkajian->pengkajianaskep_keluhanakt) ? $modPengkajian->pengkajianaskep_keluhanakt : " - "; ?></td>
		</tr>
	</table>
	<br>
	<?php echo '<strong>III. PENGKAJIAN FISIK</strong>'; ?>
	<table width ='100%' class="spasi1">
		<tr>
			<td width="50%">1. Sistem Saraf Pusat</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">a. Refleksi Bisep</td>
			<td class="spasi2">
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refbisep', array('value' => 'Positif')); ?> Positif
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refbisep', array('value' => 'Negatif')); ?> Negatif</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">b. Refleksi Trisep</td>
			<td class="spasi2">
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_reftrisep', array('value' => 'Positif')); ?> Positif
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_reftrisep', array('value' => 'Negatif')); ?> Negatif</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">c. Refleksi Patela</td>
			<td class="spasi2">
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refpatela', array('value' => 'Positif')); ?> Positif
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refpatela', array('value' => 'Negatif')); ?> Negatif</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">d. Refleksi Babinski</td>
			<td class="spasi2">
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refbabinski', array('value' => 'Positif')); ?> Positif
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refbabinski', array('value' => 'Negatif')); ?> Negatif</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">e. Refleksi Primitf</td>
			<td class="spasi2">
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refprimitif', array('value' => 'Positif')); ?> Positif
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_refprimitif', array('value' => 'Negatif')); ?> Negatif</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">Keluhan</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPengkajian->pengkajianaskep_kelsaraf) ? $modPengkajian->pengkajianaskep_kelsaraf : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%">2. Sistem Kardiovaskuler</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">a. Nadi</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPeriksaFisik->detaknadi) ? $modPeriksaFisik->detaknadi : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">b. Tekanan Darah</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPeriksaFisik->tekanandarah) ? $modPeriksaFisik->tekanandarah : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">c. Suhu Tubuh</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPeriksaFisik->suhutubuh) ? $modPeriksaFisik->suhutubuh : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">d. Nadi Perifer</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_nadiperifer', array('value' => 'Baik')); ?> Baik
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_nadiperifer', array('value' => 'Lemah')); ?> Lemah
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_nadiperifer', array('value' => 'Tak Teraba')); ?> Tak Teraba</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">e. Capillary Refill</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_capilary', array('value' => '< 3 Detik')); ?> < 3 Detik
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_capilary', array('value' => '> 3 Detik')); ?> > 3 Detik</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">f. Bunyi Jantung</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bunyijantung', array('value' => 'Normal')); ?> Normal
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bunyijantung', array('value' => 'Murmur')); ?> Murmur
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bunyijantung', array('value' => 'Gallops')); ?> Gallops</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">g. Irama</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_iramakardio', array('value' => 'Teratur')); ?> Teratur
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_iramakardio', array('value' => 'Tidak Teratur')); ?> Tidak Teratur</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">Keluhan</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPengkajian->pengkajianaskep_kelkardio) ? $modPengkajian->pengkajianaskep_kelkardio : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%">3. Sistem Pernafasan</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">a. Bunyi Nafas</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bunyinafas', array('value' => 'Ronchi')); ?> Ronchi
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bunyinafas', array('value' => 'Wheezing')); ?> Wheezing
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bunyinafas', array('value' => 'Vesikuler')); ?> Vesikuler</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">b. Jalan Nafas</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_jalannafas', array('value' => 'Bersih')); ?> Bersih
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_jalannafas', array('value' => 'Sumbatan')); ?> Sumbatan</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">c. Sesak Nafas</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sesaknafas', array('value' => 'Ya')); ?> Ya
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sesaknafas', array('value' => 'Tidak')); ?> Tidak</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">  Dengan</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sesaknafasdengan', array('value' => 'Aktifitas')); ?> Aktifitas
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sesaknafasdengan', array('value' => 'Tanpa Aktifitas')); ?> Tanpa Aktifitas</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">d. Penggunaan Alat Bantu Pernafasan</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_alatbantu', array('value' => 'Ya')); ?> Ya
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_alatbantu', array('value' => 'Tidak')); ?> Tidak</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">e. Irama</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_irama', array('value' => 'Teratur')); ?> Teratur
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_irama', array('value' => 'Tidak Teratur')); ?> Tidak Teratur</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">f. Kedalaman</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_kedalaman', array('value' => 'Dangkal')); ?> Dangkal
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_kedalaman', array('value' => 'Dalam')); ?> Dalam</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">g. Perdarahan</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_perdarahan', array('value' => 'Ya')); ?> Ya
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_perdarahan', array('value' => 'Tidak')); ?> Tidak</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">Keluhan</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPengkajian->pengkajianaskep_kelnafas) ? $modPengkajian->pengkajianaskep_kelnafas : " - "; ?></td>
		</tr>
		<tr>
			<td width="50%">4. Sistem Pencernaan</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">a. BAK</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bak', array('value' => 'Terkontrol')); ?> Terkontrol
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_bak', array('value' => 'Tidak Terkontrol')); ?> Tidak Terkontrol</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">b. Warna</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_warna', array('value' => 'Kuning Jernih')); ?> Kuning Jernih
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_warna', array('value' => 'Kuning Kental/Coklat')); ?> Kuning Kental/Coklat
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_warna', array('value' => 'Merah')); ?> Merah</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">c. Rasa Sakit Saat BAK</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sakitbak', array('value' => 'Ya')); ?> Ya
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sakitbak', array('value' => 'Tidak')); ?> Tidak</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">d. Ditensi Kandung Kemih</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_kandkemih', array('value' => 'Ya')); ?> Ya
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_kandkemih', array('value' => 'Tidak')); ?> Tidak</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">e. Rasa Sakit Pinggang</td>
			<td width="50%" class="spasi2">: <?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sakitpinggang', array('value' => 'Ya')); ?> Ya
				<?php echo CHtml::activeRadioButton($modPengkajian, 'pengkajianaskep_sakitpinggang', array('value' => 'Tidak')); ?> Tidak</td>
		</tr>
		<tr>
			<td width="50%" class="spasi2">Keluhan</td>
			<td width="50%" class="spasi2">: <?php echo isset($modPengkajian->pengkajianaskep_kelkemih) ? $modPengkajian->pengkajianaskep_kelkemih : " - "; ?></td>
		</tr>
	</table>
	<br>
	<?php echo 'Data Penunjang'; ?>
	<div class='block-tabel'>
		<?php
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'penunjang-grid',
			'enableSorting' => false,
			'template' => "{items}",
			'dataProvider' => $modPenunjang->searchPrint($modPengkajian->pengkajianaskep_id),
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			'columns' => array(
				array(
					'header' => 'Tanggal',
					'name' => 'datapenunjang_tgl',
					'value' => 'isset($data->datapenunjang_tgl) ? MyFormatter::FormatDateTimeForUser($data->datapenunjang_tgl) : " - "',
				),
				array(
					'header' => 'Data Penunjang',
					'name' => 'datapenunjang_nama',
					'value' => 'isset($data->datapenunjang_nama) ? $data->datapenunjang_nama : " - "',
				),
			),
			'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
		));
		?>
    </div>