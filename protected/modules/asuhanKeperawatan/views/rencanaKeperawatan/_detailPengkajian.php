<table width="100%">
        <tr>
            <td style="text-align:center;" align="center"><b>PENGKAJIAN KEPERAWATAN</b></td>
        </tr>
</table>
<div class="white-container">
	<div class="row-fluid">
		<table width="100%">
			<tr>
				<td ><p>No. Pengkajian :</p></td>
				<td ><p><?php echo isset($modPengkajian->no_pengkajian) ? $modPengkajian->no_pengkajian : "-"; ?></p></td>
				<td ><p>Tanggal Pengkajian :</p></td>
				<td ><p><?php echo isset($modPengkajian->pengkajianaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modPengkajian->pengkajianaskep_tgl) : "-"; ?></p></td>
				<td ><p>Nama Perawat :</p></td>
				<td ><p><?php echo isset($modPengkajian->nama_pegawai) ? $modPengkajian->nama_pegawai : "-"; ?></p></td>
			</tr>
		</table>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Pasien</legend>
			<table width="100%">
				<tr>
					<td ><p>No. Pendaftaran :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_pendaftaran) ? $modPengkajian->no_pendaftaran : "-"; ?></p></td>
					<td ><p>Jenis Kelamin :</p></td>
					<td ><p><?php echo isset($modPengkajian->jeniskelamin) ? $modPengkajian->jeniskelamin : "-"; ?></p></td>
					<td ><p>Ruangan :</p></td>
					<td ><p><?php echo isset($modPengkajian->ruangan_nama) ? $modPengkajian->ruangan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Tanggal Pendaftaran :</p></td>
					<td ><p><?php echo isset($modPengkajian->tgl_pendaftaran) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgl_pendaftaran) : "-"; ?></p></td>
					<td ><p>Pekerjaan :</p></td>
					<td ><p><?php echo isset($modPengkajian->pekerjaan_nama) ? $modPengkajian->pekerjaan_nama : "-"; ?></p></td>
					<td ><p>Kelas :</p></td>
					<td ><p><?php echo isset($modPengkajian->kelaspelayanan_nama) ? $modPengkajian->kelaspelayanan_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>No. Rekam Medik:</p></td>
					<td ><p><?php echo isset($modPengkajian->no_rekam_medik) ? $modPengkajian->no_rekam_medik : "-"; ?></p></td>
					<td ><p>Pendidikan :</p></td>
					<td ><p><?php echo isset($modPengkajian->pendidikan_nama) ? $modPengkajian->pendidikan_nama : "-"; ?></p></td>
					<td ><p>No Kamar / No Bed :</p></td>
					<td ><p><?php echo isset($modPengkajian->kamarruangan_nokamar) ? $modPengkajian->kamarruangan_nokamar : "-" . ' / ' . isset($modPengkajian->kamarruangan_nobed) ? $modPengkajian->kamarruangan_nobed : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Nama Pasien :</p></td>
					<td ><p><?php echo isset($modPengkajian->nama_pasien) ? $modPengkajian->nama_pasien : "-"; ?></p></td>
					<td ><p>Agama :</p></td>
					<td ><p><?php echo isset($modPengkajian->agama) ? $modPengkajian->agama : "-"; ?></p></td>
					<td ><p>Diagnosa Medik Masuk :</p></td>
					<td ><p><?php echo isset($modPengkajian->diagnosa_nama) ? $modPengkajian->diagnosa_nama : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Umur :</p></td>
					<td ><p><?php echo isset($modPengkajian->umur) ? $modPengkajian->umur : "-"; ?></p></td>
					<td ><p>Alamat :</p></td>
					<td ><p><?php echo isset($modPengkajian->alamat_pasien) ? $modPengkajian->alamat_pasien : "-"; ?></p></td>
				</tr>
				<tr>
					<td ><p>Status Perkawinan :</p></td>
					<td ><p><?php echo isset($modPengkajian->statusperkawinan) ? $modPengkajian->statusperkawinan : "-"; ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Penanggung Jawab</legend>
			<table width="100%">
				<tr>
					<td ><p>Nama :</p></td>
					<td ><p><?php echo isset($modPengkajian->nama_pj) ? $modPengkajian->nama_pj : "-"; ?></p></td>
					<td ><p>Tanggal Lahir :</p></td>
					<td ><p><?php echo isset($modPengkajian->tgllahir_pj) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgllahir_pj) : "-"; ?></p></td>
					<td ><p>Hubungan Dengan Klien :</p></td>
					<td ><p><?php echo isset($modPengkajian->hubungankeluarga) ? $modPengkajian->hubungankeluarga : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>No Identitas :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_identitas) ? $modPengkajian->no_identitas : "-"; ?></p></td>
					<td ><p>No Telepon :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_teleponpj) ? $modPengkajian->no_teleponpj : "-"; ?></p></td>
					<td ><p>Alamat :</p></td>
					<td ><p><?php echo isset($modPengkajian->alamat_pj) ? $modPengkajian->alamat_pj : "-" ?></p></td>
				</tr>
				<tr>
					<td ><p>Jenis Kelamin:</p></td>
					<td ><p><?php echo isset($modPengkajian->jk) ? $modPengkajian->jk : "-"; ?></p></td>
					<td ><p>No Mobile :</p></td>
					<td ><p><?php echo isset($modPengkajian->no_mobilepj) ? $modPengkajian->no_mobilepj : "-"; ?></p></td>
				</tr>
			</table>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Anamnesa</legend>
			<div class='block-tabel'>
				<?php
				$this->widget('ext.bootstrap.widgets.BootGridView', array(
					'id' => 'anamnesa-grid',
					'enableSorting' => false,
					'template' => "{items}",
					'dataProvider' => $modAnamnesa,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns' => array(
						array(
							'header' => 'Tanggal',
							'name' => 'tglanamnesis',
							'value' => 'isset($data->tglanamnesis) ? MyFormatter::FormatDateTimeForUser($data->tglanamnesis) : " - "',
						),
						array(
							'header' => 'Keluhan Utama',
							'name' => 'keluhanutama',
							'value' => '$data->keluhanutama'
						),
						array(
							'header' => 'Keluhan Tambahan',
							'name' => 'keluhantambahan',
							'value' => '$data->keluhantambahan'
						),
						array(
							'header' => 'Riwayat Penyakit Terdahulu',
							'name' => 'riwayatpenyakitterdahulu',
							'value' => '$data->riwayatpenyakitterdahulu'
						),
						array(
							'header' => 'Riwayat Penyakit Keluarga',
							'name' => 'riwayatpenyakitkeluarga',
							'value' => '$data->riwayatpenyakitkeluarga'
						),
						array(
							'header' => 'Riwayat Imunisasi',
							'name' => 'riwayatimunisasi',
							'value' => '$data->riwayatimunisasi'
						),
						array(
							'header' => 'Riwayat Alergi Obat',
							'name' => 'riwayatalergiobat',
							'value' => '$data->riwayatalergiobat'
						),
						array(
							'header' => 'Riwayat Makanan',
							'name' => 'riwayatmakanan',
							'value' => '$data->riwayatmakanan'
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
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Pemeriksaan Fisik</legend>
			<div class='block-tabel'>
				<?php
				$this->widget('ext.bootstrap.widgets.BootGridView', array(
					'id' => 'anamnesa-grid',
					'enableSorting' => false,
					'template' => "{items}",
					'dataProvider' => $modPeriksaFisik,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns' => array(
						array(
							'header' => 'Tanggal Periksa Fisik',
							'name' => 'tglperiksafisik',
							'value' => 'isset($data->tglperiksafisik) ? MyFormatter::FormatDateTimeForUser($data->tglperiksafisik) : " - "',
						),
						array(
							'header' => 'Keadaan Umum',
							'name' => 'keadaanumum',
							'value' => '$data->keadaanumum'
						),
						array(
							'header' => 'Barat Badan',
							'name' => 'beratbadan_kg',
							'value' => '$data->beratbadan_kg'
						),
						array(
							'header' => 'Tinggi Badan',
							'name' => 'tinggibadan_cm',
							'value' => '$data->tinggibadan_cm'
						),
						array(
							'header' => 'Tekanan Darah',
							'name' => 'tekanandarah',
							'value' => '$data->tekanandarah'
						),
						array(
							'header' => 'Detak Nadi',
							'name' => 'detaknadi',
							'value' => '$data->detaknadi'
						),
						array(
							'header' => 'Suhu Tubuh',
							'name' => 'suhutubuh',
							'value' => '$data->suhutubuh'
						),
						array(
							'header' => 'Pernapasan',
							'name' => 'pernapasan',
							'value' => '$data->pernapasan'
						),
						array(
							'header' => 'Kesadaran/GCS',
							'name' => 'gcs_eye',
							'value' => '$data->gcs_eye'
						),
						array(
							'header' => 'Kelainan Pada Bag. Tubuh',
							'name' => 'kelainanpadabagtubuh',
							'value' => '$data->kelainanpadabagtubuh'
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
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Sistem-Sistem Tubuh</legend>
			<div class="row-fluid">
				<div class="span4">
					<div class="row-fluid">
						<fieldset class="box">
							<legend class="rim">Pernafasan</legend>
							<table>
								<tr>
									<td><p>Bunyi Nafas :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bunyinafas)) ? $modPengkajian->pengkajianaskep_bunyinafas : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Jalan Nafas :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_jalannafas)) ? $modPengkajian->pengkajianaskep_jalannafas : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Sesak Nafas :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_sesaknafas)) ? $modPengkajian->pengkajianaskep_sesaknafas : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Penggunaan Alat Bantu Pernafasan :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_alatbantu)) ? $modPengkajian->pengkajianaskep_alatbantu : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Irama :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_irama)) ? $modPengkajian->pengkajianaskep_irama : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Kedalaman :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kedalaman)) ? $modPengkajian->pengkajianaskep_kedalaman : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Perdarahan :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_perdarahan)) ? $modPengkajian->pengkajianaskep_perdarahan : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Keluhan :</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelnafas)) ? $modPengkajian->pengkajianaskep_kelnafas : "-" ?></p></td>
								</tr>
							</table>
						</fieldset>
					</div>
					<div class="row-fluid">
						<fieldset class="box">
							<legend class="rim">Muskuloskeletal</legend>
							<table>
								<tr>
									<td><p>Kekuatan Otot Atas:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_ototatas)) ? $modPengkajian->pengkajianaskep_ototatas : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Kekuatan Otot Bawah:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_ototbawah)) ? $modPengkajian->pengkajianaskep_ototbawah : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Rasa Sakit Persendian:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_sakitsendi)) ? $modPengkajian->pengkajianaskep_sakitsendi : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Keluhan:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelmuskulos)) ? $modPengkajian->pengkajianaskep_kelmuskulos : "-" ?></p></td>
								</tr>
							</table>
						</fieldset>
					</div>
					<div class="row-fluid">
						<fieldset class="box">
							<legend class="rim">Perkemihan</legend>
							<table>
								<tr>
									<td><p>BAK:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bak)) ? $modPengkajian->pengkajianaskep_bak : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Warna:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_warna)) ? $modPengkajian->pengkajianaskep_warna : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Rasa Sakit Saat BAK:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_sakitbak)) ? $modPengkajian->pengkajianaskep_sakitbak : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Ditensi Kandung Kemih:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kandkemih)) ? $modPengkajian->pengkajianaskep_kandkemih : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Rasa Sakit Pinggang:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_sakitpinggang)) ? $modPengkajian->pengkajianaskep_sakitpinggang : "-" ?></p></td>
								</tr>
								<tr>
									<td><p>Keluhan:</p></td>
									<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelkemih)) ? $modPengkajian->pengkajianaskep_kelkemih : "-" ?></p></td>
								</tr>
							</table>
						</fieldset>
					</div>
				</div>
				<div class="span8">
					<div class="row-fluid">
						<div class="span6">
							<fieldset class="box">
								<legend class="rim">Persarafan</legend>
								<table>
									<tr>
										<td><p>Refleksi Bisep:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_refbisep)) ? $modPengkajian->pengkajianaskep_refbisep : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Refleksi Trisep:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_reftrisep)) ? $modPengkajian->pengkajianaskep_reftrisep : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Refleksi Patela:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_refpatela)) ? $modPengkajian->pengkajianaskep_refpatela : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Refleksi Babinski:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_refbabinski)) ? $modPengkajian->pengkajianaskep_refbabinski : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Refleksi Primitif:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_refprimitif)) ? $modPengkajian->pengkajianaskep_refprimitif : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Keluhan:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelsaraf)) ? $modPengkajian->pengkajianaskep_kelsaraf : "-" ?></p></td>
									</tr>
								</table>
							</fieldset>
						</div>
						<div class="span6">
							<fieldset class="box">
								<legend class="rim">Kardiovaskuler</legend>
								<table>
									<tr>
										<td><p>Nadi Perifer:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_nadiperifer)) ? $modPengkajian->pengkajianaskep_nadiperifer : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Capilary Refill:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_capilary)) ? $modPengkajian->pengkajianaskep_capilary : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Bunyi Jantung:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bunyijantung)) ? $modPengkajian->pengkajianaskep_bunyijantung : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Bunyi Jantung:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bunyijantung)) ? $modPengkajian->pengkajianaskep_bunyijantung : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Irama:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_iramakardio)) ? $modPengkajian->pengkajianaskep_iramakardio : "-" ?></p></td>
									</tr>
									<tr>
										<td><p>Keluhan:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelkardio)) ? $modPengkajian->pengkajianaskep_kelkardio : "-" ?></p></td>
									</tr>
								</table>
							</fieldset>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<fieldset class="box">
								<legend class="rim">Gastrointestinal</legend>
								<table>
								<tr>
										<td><p>Peristaltik Usus:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_perusus)) ? $modPengkajian->pengkajianaskep_perusus : "-" ?></p></td>
								</tr>
								<tr>
										<td><p>Distensi/Kembung:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_distensi)) ? $modPengkajian->pengkajianaskep_distensi : "-" ?></p></td>
								</tr>
								<tr>
										<td><p>Nyeri Tekan:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_nyeritekan)) ? $modPengkajian->pengkajianaskep_nyeritekan : "-" ?></p></td>
								</tr>
								<tr>
										<td><p>Nyeri Lepas:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_nyerilepas)) ? $modPengkajian->pengkajianaskep_nyerilepas : "-" ?></p></td>
								</tr>
								<tr>
										<td><p>Bibir:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bibir)) ? $modPengkajian->pengkajianaskep_bibir : "-" ?></p></td>
								</tr>
								<tr>
										<td><p>Keluhan:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelgastro)) ? $modPengkajian->pengkajianaskep_kelgastro : "-" ?></p></td>
								</tr>
								</table>
							</fieldset>
						</div>
						<div class="span6">
							<fieldset class="box">
								<legend class="rim">Integumen</legend>
								<table>
								<tr>
										<td><p>Turgor Kulit:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_turgorkulit)) ? $modPengkajian->pengkajianaskep_turgorkulit : "-" ?></p></td>
								</tr>
								<tr>
										<td><p>Keadaan Kulit:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_keadaankulit)) ? $modPengkajian->pengkajianaskep_keadaankulit : "-" ?></p></td>
								</tr>
								<tr>
										<td><p>Keluhan:</p></td>
										<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelintegumen)) ? $modPengkajian->pengkajianaskep_kelintegumen : "-" ?></p></td>
								</tr>
								</table>
							</fieldset>
						</div>
					</div>
					<div class="row-fluid">
						<fieldset class="box">
							<legend class="rim">Pengindraan</legend>
							<div class="row-fluid">
								<div class="span6">
									<fieldset class="box">
										<legend class="rim">Mata</legend>
										<table>
										<tr>
											<td><p>Bentuk:</p></td>
											<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bentukmata)) ? $modPengkajian->pengkajianaskep_bentukmata : "-" ?></p></td>
										</tr>
										<tr>
											<td><p>Edema:</p></td>
											<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_edema)) ? $modPengkajian->pengkajianaskep_edema : "-" ?></p></td>
										</tr>
										<tr>
											<td><p>Konjungtiva:</p></td>
											<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_konjungtiva)) ? $modPengkajian->pengkajianaskep_konjungtiva : "-" ?></p></td>
										</tr>
										<tr>
											<td><p>Fungsi Penglihatan:</p></td>
											<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_funglihat)) ? $modPengkajian->pengkajianaskep_funglihat : "-" ?></p></td>
										</tr>
										<tr>
											<td><p>Keluhan:</p></td>
											<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelmata)) ? $modPengkajian->pengkajianaskep_kelmata : "-" ?></p></td>
										</tr>
										</table>
									</fieldset>
								</div>

								<div class="span6">
									<fieldset class="box">
										<legend class="rim">Hidung</legend>
										<table>
											<tr>
												<td><p>Bentuk:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bentukhid)) ? $modPengkajian->pengkajianaskep_bentukhid : "-" ?></p></td>
											</tr>
											<tr>
												<td><p>Perdarahan:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_perdarahanhid)) ? $modPengkajian->pengkajianaskep_perdarahanhid : "-" ?></p></td>
											</tr>
											<tr>
												<td><p>Fungsi Penciuman:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_fungpenciuman)) ? $modPengkajian->pengkajianaskep_fungpenciuman : "-" ?></p></td>
											</tr>
											<tr>
												<td><p>Keluhan:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_kelhidung)) ? $modPengkajian->pengkajianaskep_kelhidung : "-" ?></p></td>
											</tr>
										</table>
									</fieldset>
									<fieldset class="box">
										<legend class="rim">Telinga</legend>
										<table>
											<tr>
												<td><p>Bentuk:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_bentuktelinga)) ? $modPengkajian->pengkajianaskep_bentuktelinga : "-" ?></p></td>
											</tr>
											<tr>
												<td><p>Lesi:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_lesi)) ? $modPengkajian->pengkajianaskep_lesi : "-" ?></p></td>
											</tr>
											<tr>
												<td><p>Fungsi Pendengaran:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_fungdengar)) ? $modPengkajian->pengkajianaskep_fungdengar : "-" ?></p></td>
											</tr>
											<tr>
												<td><p>Keluhan:</p></td>
												<td><p><?php echo (!empty($modPengkajian->pengkajianaskep_keltelinga)) ? $modPengkajian->pengkajianaskep_keltelinga : "-" ?></p></td>
											</tr>
										</table>
									</fieldset>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="row-fluid">
		<fieldset class="box">
			<legend class="rim">Data Penunjang</legend>
			<div class='block-tabel'>
				<?php
				$this->widget('ext.bootstrap.widgets.BootGridView', array(
					'id' => 'penunjang-grid',
					'enableSorting' => false,
					'template' => "{items}",
					'dataProvider' => $modPenunjang,
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
							'value' => '$data->datapenunjang_nama'
						)
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
		</fieldset>
	</div>
</div>
