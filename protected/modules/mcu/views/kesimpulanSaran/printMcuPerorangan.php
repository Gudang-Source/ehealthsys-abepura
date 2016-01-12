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
    }
	.break { page-break-before: always; }
/*	table { page-break-inside:auto }
	tr    { page-break-inside:avoid; page-break-after:auto }*/
</style>
<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="100%">
	<tr>
		<td width="35%"></td>
		<td style="text-align: center; font-weight: bold; border-bottom: 1px solid #000000">STATUS KESEHATAN SAAT INI</td>
		<td width="35%"></td>
	</tr>
	<tr>
		<td width="35%"></td>
		<td style="text-align: center; font-weight: bold;">My Health At A Glance</td>
		<td width="35%"></td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td width="20%" style="font-weight: bold;">Nama Lengkap</td>
		<td width="80%">: &nbsp; <?php echo $modPasien->nama_pasien; ?></td>
	</tr>
	<tr>
		<td width="20%" style="font-weight: bold;">Golongan Darah</td>
		<td width="80%">: &nbsp; <?php echo !empty($modPasien->golongandarah)?$modPasien->golongandarah:' - '; ?></td>
	</tr>
	<tr>
		<td width="20%" style="font-weight: bold;">Tanggal Lahir</td>
		<td width="80%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
	</tr>
</table>
<br>
<div class="row-fluid">
	<div class="span12">
		<fieldset class="well">
<!--			<legend class="rim"><h4>PEMERIKSAAN</h4></legend>-->
			<table width="100%" border="0">
				<tr>
					<td width="20%" colspan="2"><strong>Riwayat Alergi</strong></td>
					<td width="80%"><strong>:</strong></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%" colspan="2" style="border-bottom: 1px solid #000000;">
						<?php echo !empty($modAnamnesa->riwayatalergiobat)?$modAnamnesa->riwayatalergiobat:"<i>Tidak Ada</i>" ?>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td width="20%" colspan="2"><strong>Masalah Kondisi Medis</strong></td>
					<td width="80%"><strong>:</strong></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%" colspan="2" style="border-bottom: 1px solid #000000">
						<?php echo !empty($modAnamnesa->riwayatobatya)?$modAnamnesa->riwayatpenyakitterdahulu:"<i>Tidak Ada</i>" ?>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td width="20%" colspan="3"><strong>Riwayat Konsumsi Obat, Vitamin, Suplemen, dan Herbal saat ini :</strong></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%" colspan="2" style="border-bottom: 1px solid #000000">
						<?php echo !empty($modAnamnesa->riwayatobatygsering)?$modAnamnesa->riwayatobatygsering:"<i>Tidak Ada</i>" ?>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td width="20%" colspan="3"><strong>Riwayat Penyakit Keluarga :</strong></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="95%" colspan="2" style="border-bottom: 1px solid #000000">
						<?php echo !empty($modAnamnesa->riwayatpenyakitkeluarga)?$modAnamnesa->riwayatpenyakitkeluarga:"<i>Tidak Ada</i>" ?>
					</td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td width="20%" colspan="2"><strong>Dokter Pribadi</strong></td>
					<td width="80%"><strong>:</strong></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="15%">Nama</td>
					<td width="80%" colspan="2" style="border-bottom: 1px solid #000000">: &nbsp; <?php echo $_GET['dokterpribadi_nama']; ?></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="15%">No. Telepon</td>
					<td width="80%" colspan="2" style="border-bottom: 1px solid #000000">: &nbsp; <?php echo $_GET['dokterpribadi_notelp']; ?></td>
				</tr>
				<tr><td></td></tr>
				<tr>
					<td width="20%" colspan="2"><strong>Yang Dihubungi Saat Darurat</strong></td>
					<td width="80%"><strong>:</strong></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="15%">Nama</td>
					<td width="80%" colspan="2" style="border-bottom: 1px solid #000000">: &nbsp; <?php echo $_GET['dihubungidarurat_nama']; ?></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="15%">Hubungan</td>
					<td width="80%" colspan="2" style="border-bottom: 1px solid #000000">: &nbsp; <?php echo $_GET['dihubungidarurat_hubungan']; ?></td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td width="15%">No. Telepon</td>
					<td width="80%" colspan="2" style="border-bottom: 1px solid #000000">: &nbsp; <?php echo $_GET['dihubungidarurat_notelp']; ?></td>
				</tr>
				<tr><td></td></tr>
			</table>
		</fieldset>
	</div>
</div>

<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->

<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="35%"></td>
		<td style="text-align: center; font-weight: bold; border-bottom: 1px solid #000000">ANALISA UMUM RESIKO KESEHATAN</td>
		<td width="35%"></td>
	</tr>
	<tr>
		<td width="35%"></td>
		<td style="text-align: center; font-weight: bold;">General Health Risk Analist</td>
		<td width="35%"></td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td width="100%" colspan="3" style="text-align: justify;">
			Resume ini memuat hasil kondisi kesehatan anda saat ini yang berhubungan dengan parameter-parameter yang didapat dari
			Formulir Health Risk Quesioner. Tujuannya untuk membantu anda memahami masalah kesehatan anda serta meningkatkan kesadaran dalam
			tindakan pencegahan terhadap penyakit yang dapat muncul.
		</td>
	</tr>
</table>
<div class="row-fluid">
	<div class="span12">
		<fieldset class="well">
			<table width="100%" border="0">
				<tr>
					<td width="25"><strong>Faktor Klinis</strong></td>
					<td width="25%"><strong>Hasil</strong></td>
					<td width="50%"><strong>Kesan</strong></td>
				</tr>
				<?php if(!empty($modHasilPemeriksaanLab)){
					foreach($modHasilPemeriksaanLab->Jenis as $i =>$v){ ?>
						<tr>
							<td width="25"> &nbsp; <?php echo $v->jenispemeriksaanlab_nama ?></td>
							<td width="25">Terlampir</td>
							<td width="25"><?php echo !empty($modHasilPemeriksaanLab->Kesimpulan)?$modHasilPemeriksaanLab->Kesimpulan:' - '; ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
				<tr>
					<td width="25"> &nbsp; Index Masa Tubuh (IMT)</td>
					<td width="25"><?php echo !empty($modPemeriksaanFisik->bb_ideal)?$modPemeriksaanFisik->bb_ideal:' - '; ?></td>
					<td width="25"></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; Tekanan Darah</td>
					<td width="25"><?php echo !empty($modPemeriksaanFisik->klasifikasitekanandarah_id)?$modPemeriksaanFisik->klasifikasitekanandarah_id:' - '; ?></td>
					<td width="25">
						<?php
						if(!empty($modPemeriksaanFisik->klasifikasitekanandarah_id)){
							$kls = KlasifikasitekanadarahM::model()->findByPk($modPemeriksaanFisik->klasifikasitekanandarah_id);
							echo $kls->klasifikasitekanadarah;
						}
						?>
					</td>
				</tr>
				<tr>
					<td width="25"><strong>Riwayat Penyakit Saat Ini</strong></td>
					<td width="25%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"><strong></strong></td>
					<td width="25%"><?php echo !empty($modAnamnesa->riwayatpenyakitterdahulu)?$modAnamnesa->riwayatpenyakitterdahulu:'<i>Tidak Ada</i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"><strong>Obat-obatan</strong></td>
					<td width="25%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"><strong></strong></td>
					<td width="25%"><?php echo !empty($modAnamnesa->riwayatobatyangsering)?$modAnamnesa->riwayatobatyangsering:'<i>Tidak Ada</i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"><strong>Vaksinasi</strong></td>
					<td width="25%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"><strong></strong></td>
					<td width="25%"><?php echo !empty($modAnamnesa->riwayatimunisasi)?$modAnamnesa->riwayatimunisasi:'<i>Tidak Ada</i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"><strong>Gaya Hidup</strong></td>
					<td width="25%"></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; Aerobic / Olah Raga</td>
					<td width="25%"><?php echo !empty($modAnamnesa->keb_olahraga)?($modAnamnesa->keb_olahraga)?'Ya':'Tidak':'<i> - </i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; Konsumsi Alkohol</td>
					<td width="25%"><?php echo !empty($modAnamnesa->keb_konsumsialkohol)?($modAnamnesa->keb_konsumsialkohol)?'Ya':'Tidak':'<i> - </i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; Merokok</td>
					<td width="25%"><?php echo !empty($modAnamnesa->statusmerokok)?($modAnamnesa->statusmerokok)?'Ya':'Tidak':'<i> - </i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; Minum Kopi</td>
					<td width="25%"><?php echo !empty($modAnamnesa->keb_minumkopi)?($modAnamnesa->keb_minumkopi)?'Ya':'Tidak':'<i> - </i>'; ?></td>
					<td width="50%"></td>
				</tr>
			</table>
		</fieldset>
	</div>
</div>

<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->

<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="35%"></td>
		<td style="text-align: center; font-weight: bold;">ANALISA RESIKO KORONER</td>
		<td width="35%"></td>
	</tr>
	<tr><td></td></tr>
	<tr>
		<td width="100%" colspan="3" style="text-align: justify;">
			<strong>Analisa Framingham Heart Study</strong><br>
			Analisa mengidentifikasi resiko terjadinya Penyakit Jantung Koroner / PJK selama 10 tahun kedepan,<br>
			Studi ini telah diakui oleh komunitas medis sebagai alat prediksi yang efektif untuk beberapa ganguan jantung termasuk angina pectoris (nyeri dada / angin duduk).
		</td>
	</tr>
</table>
<div class="row-fluid">
	<div class="span12">
		<fieldset class="well">
			<table width="100%" border="1">
				<tr>
					<td width="25"><strong>Faktor Resiko</strong></td>
					<td width="25%"><strong>Hasil</strong></td>
					<td width="50%"><strong>Level</strong></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; Kolesterol Total</td>
					<td width="25%"><?php echo !empty($modJantungKoroner->total_kolesterol)?$modJantungKoroner->total_kolesterol:'<i> - </i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; HDL Kolesterol</td>
					<td width="25%"><?php echo !empty($modJantungKoroner->hdl_kolesterol)?$modJantungKoroner->hdl_kolesterol:'<i> - </i>'; ?></td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td width="25"> &nbsp; Tekanan Darah</td>
					<td width="25%"><?php echo !empty($modJantungKoroner->tekanandarah)?$modJantungKoroner->tekanandarah:'<i> - </i>'; ?></td>
					<td width="50%"></td>
				</tr>
			</table>
			<br>
			<table width="100%" border="0">
				<tr>
					<td width="40%"><strong>Resiko Serangan Jantung dalam 10 tahun</strong></td>
					<td width="60%"><strong>Hasil Presentase : <?php echo !empty($modJantungKoroner->hasil_resiko_persen)?$modJantungKoroner->hasil_resiko_persen.'%':'<i> - </i>'; ?></strong></td>
				</tr>
			</table>
			<br>
			<table width="100%" border="0">
				<tr>
					<td width="30%"><strong>Hasil Review</strong></td>
					<td width="70%"><?php echo !empty($modJantungKoroner->hasil_review_ab)?$modJantungKoroner->hasil_review_ab:'<i> - </i>'; ?></td>
				</tr>
				<tr>
					<td width="30%"><strong>Gangguan Metabolisme</strong></td>
					<td width="70%"><?php echo !empty($modJantungKoroner->gangguan_metabolisme)?$modJantungKoroner->gangguan_metabolisme:'<i> - </i>'; ?></td>
				</tr>
			</table>
		</fieldset>
	</div>
</div>

<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->

<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="30%"></td>
		<td style="text-align: center; font-weight: bold;"><u>HASIL PEMERIKSAAN LABORATORIUM & PENUNJANG</u></td>
		<td width="30%"></td>
	</tr>
</table>
<div class="row-fluid">
	<div class="span12">
		<fieldset class="">
			<table width="100%" border="0" class="table table-striped table-bordered table-condensed">
				<tr>
					<th style="text-align: center;">PEMERIKSAAN</th>
					<?php for($i=0;$i<5;$i++){
						echo "<th style='text-align: center;'>".date('Y', strtotime('-'.$i.' year'))."</th>";
					}
					?>
				</tr>
				<?php
				if(!empty($modDetailHasilPemeriksaanLabMCU)){
					$echo='';
					foreach($modDetailHasilPemeriksaanLabMCU as $ii =>$vv){
						echo "<tr><td>".$vv->pemeriksaanlab->pemeriksaanlab_nama."</td>";
						echo "<td>".$vv->nilairujukan."</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</tr>";
					}
				}else{
					echo "<td colspan='6'><i>Data Pemeriksaan Lab Tidak Ditemukan...</i></td>";
				}
				?>
			</table>
		</fieldset>
	</div>
</div>


<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->

<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="30%"></td>
		<td style="text-align: center; font-weight: bold;">KESIMPULAN DAN SARAN</td>
		<td width="30%"></td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td width="15%" style="font-weight: bold;">Nama </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->nama_pasien; ?></td>
		<td width="15%" style="font-weight: bold;">Tanggal MCU </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Perusahaan </td>
		<td width="35%">: &nbsp; PT. Badak LNG</td>
		<td width="15%" style="font-weight: bold;">Kelamin </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Tanggal Lahir </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
		<td width="15%" style="font-weight: bold;">No. MR </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr><td colspan="4" style="border-top: 1px solid #000000"></td></tr>
</table>
<table width="100%">
	<tr>
		<td width="5%"></td>
		<td width="95%"><strong><u>KESIMPULAN</u></strong></td>
	</tr>
	<tr>
		<td width="5%"></td>
		<td width="95%"><?php echo !empty($ModKesimpulanMCU->kesimpulanperorangan)?$ModKesimpulanMCU->kesimpulanperorangan:' - '; ?></td>
	</tr>
	<tr><td colspan="2"></td></tr>
	<tr>
		<td width="5%"></td>
		<td width="95%"><strong><u>SARAN</u></strong></td>
	</tr>
	<tr>
		<td width="5%"></td>
		<td width="95%"><?php echo !empty($ModKesimpulanMCU->saranperorangan)?$ModKesimpulanMCU->saranperorangan:' - '; ?></td>
	</tr>
	<tr><td colspan="2"></td></tr>
	<tr>
		<td width="5%"></td>
		<td width="95%"><strong><u>KESIAPAN KERJA</u></strong></td>
	</tr>
	<tr>
		<td width="5%"></td>
		<td width="95%"><?php echo !empty($ModKesimpulanMCU->keterangan_kesimpulanmcu)?$ModKesimpulanMCU->keterangan_kesimpulanmcu:' - '; ?></td>
	</tr>
	<tr><td colspan="4" style="border-bottom: 1px solid #000000"></td></tr>
</table>
<br><br>
<table width="100%">
	<tr>
		<td width="75%"></td>
		<td width="25%" style="text-align: center;">
			<?php echo $modProfilRs->kabupaten->kabupaten_nama.", ".!empty($ModKesimpulanMCU->tgl_kesimpulanmcu)?MyFormatter::formatDateTimeId($ModKesimpulanMCU->tgl_kesimpulanmcu):''; ?><br>
			<br><br><br><br><br>
			<b><u>(<?php echo !empty($ModKesimpulanMCU->nama_pemeriksa_kes)?$ModKesimpulanMCU->nama_pemeriksa_kes:''; ?>)</u></b>
		</td>
	</tr>
	<tr>
		<td width="75%"></td>
		<td width="25%" style="text-align:center;">
			Occupational Health Doctor.
		</td>
	</tr>
</table>

<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->


<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="30%"></td>
		<td style="text-align: center; font-weight: bold;">HASIL PEMERIKSAAN FISIK</td>
		<td width="30%"></td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td width="15%" style="font-weight: bold;">Nama </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->nama_pasien; ?></td>
		<td width="15%" style="font-weight: bold;">Tanggal MCU </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Perusahaan </td>
		<td width="35%">: &nbsp; PT. Badak LNG</td>
		<td width="15%" style="font-weight: bold;">Kelamin </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Tanggal Lahir </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
		<td width="15%" style="font-weight: bold;">No. MR </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr><td colspan="4" style="border-top: 1px solid #000000"></td></tr>
</table>
<?php $jarak = " &nbsp;  &nbsp;  &nbsp;&nbsp; "; ?>
<div class="row-fluid">
	<div class="span12">
		<fieldset class="well">
			<table width="100%" border="0">
				<tr>
					<td width="50%" style="border-top: 1px solid #000000;border-bottom: 1px solid #000000"><strong>JENIS PEMERIKSAAN</strong></td>
					<td width="20%" style="border-top: 1px solid #000000;border-bottom: 1px solid #000000"><strong>HASIL</strong></td>
					<td width="30%" style="border-top: 1px solid #000000;border-bottom: 1px solid #000000"><strong>KETERANGAN</strong></td>
				</tr>
				<tr>
					<td><strong>1.1. Keluhan Saat Ini</strong></td>
					<td><?php echo !empty($modAnamnesa->keluhanutama)?$modAnamnesa->keluhanutama:'<i> - </i>'; ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>1.2. Riwayat Kesehatan Individu (Pribadi)</strong></td>
					<td></td>
					<td></td>
				</tr>
				<?php
				if(!empty($modRiwayatIndividuR)){
					foreach($modRiwayatIndividuR as $iii => $vvv){
						echo "<tr>";
						echo "<td>".$jarak.$vvv->nama_riwayat_individu."</td>";
						echo "<td>".$vvv->status_riwayatinidividu."</td>";
						echo "</tr>";
					}
				}
				?>
				<tr>
					<td><strong>1.3. Riwayat Kesehatan Keluarga</strong></td>
					<td></td>
					<td></td>
				</tr>
				<?php
				if(!empty($modRiwayatKeluargaR)){
					foreach($modRiwayatKeluargaR as $iiii => $vvvv){
						echo "<tr>";
						echo "<td>".$jarak.$vvvv->nama_riwayat_keluarga."</td>";
						echo "<td>".$vvvv->status_riwayat_keluarga."</td>";
						echo "</tr>";
					}
				}
				?>
				<tr>
					<td><strong>1.4. Faktor Resiko Ditempat Kerja</strong></td>
					<td></td>
					<td></td>
				</tr>
				<?php
				if(!empty($modRiwayatResikoKerjaJenis)){
					foreach($modRiwayatResikoKerjaJenis as $iiiii => $vvvvv){
						echo "<tr>";
						echo "<td><b>".$vvvvv->jenis_faktor_resiko."</b></td>";
						echo "<td></td>";
						echo "</tr>";
//						echo $modRiwayatResikoKerjaJenis[$iiiii]->ResikoKerjaByJenis;
						
						foreach($modRiwayatResikoKerjaJenis[$iiiii]->ResikoKerjaByJenis as $key => $val){
							echo "<tr>";
							echo "<td>".$jarak.$val->nama_faktor_resiko."</td>";
							echo "<td>".$val->status_faktor_resiko."</td>";
							echo "</tr>";
						}
						
					}
				}
				?>
				<tr>
					<td><strong>1.5. Riwayat Kecelakan Kerja</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Waktu dan Jenis Kecelakaan</td>
					<td><?php echo !empty($modAnamnesa->riwayat_kecelakaan)?$modAnamnesa->riwayat_kecelakaan:'<i> - </i>'; ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>1.6. Riwayat Operasi</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Kapan dan Jenis Operasi</td>
					<td><?php echo !empty($modAnamnesa->riwayat_operasi)?$modAnamnesa->riwayat_operasi:'<i> - </i>'; ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>1.7. Riwayat Imunisasi</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?><?php echo !empty($modAnamnesa->riwayatimunisasi)?$modAnamnesa->riwayatimunisasi:'<i> - </i>'; ?></td>
					<td><?php echo !empty($modAnamnesa->riwayatimunisasiblm)?$modAnamnesa->riwayatimunisasiblm:'<i> - </i>'; ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>1.8. Kebiasaan</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Olah Raga</td>
					<td><?php 
							if(!isset($modAnamnesa->keb_olahraga)){
								echo"Tidak";
							}else{
								echo "Ya";
							}
							?>
					</td>
					<td><?php if(!isset($modAnamnesa->keb_olahraga)){echo " - ";}else{echo $modAnamnesa->keb_jnsolahraga;} ?></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Jenis Olah Raga</td>
					<td><?php if(!isset($modAnamnesa->keb_jnsolahraga)){echo " - ";}else{if($modAnamnesa->keb_jnsolahraga==='1'){echo"Ya";}else{echo"Tidak";}} ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Frekuensi</td>
					<td><?php if(!isset($modAnamnesa->keb_frekuensi_kaliminggu)){echo " - ";}else{if($modAnamnesa->keb_frekuensi_kaliminggu==='1'){echo"Ya";}else{echo"Tidak";}} ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Merokok</td>
					<td><?php if(!isset($modAnamnesa->statusmerokok)){echo " - ";}else{if($modAnamnesa->statusmerokok===true){echo"Ya";}else{echo"Tidak";}} ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Minum Alkohol</td>
					<td><?php if(!isset($modAnamnesa->keb_konsumsialkohol)){echo " - ";}else{if($modAnamnesa->keb_konsumsialkohol==='1'){echo"Ya";}else{echo"Tidak";}} ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Minum Kopi</td>
					<td><?php if(!isset($modAnamnesa->keb_minumkopi)){echo " - ";}else{if($modAnamnesa->keb_minumkopi==='1'){echo"Ya";}else{echo"Tidak";}} ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Obat-obatan yang sering digunakan</td>
					<td><?php if(!isset($modAnamnesa->riwayatobatygsering)){echo " - ";}else{echo $modAnamnesa->riwayatobatygsering;} ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>Alergi Terhadap</td>
					<td><?php if(!isset($modAnamnesa->riwayatalergiobat)){echo " - ";}else{echo $modAnamnesa->riwayatalergiobat;} ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Tanda Vital</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>a. Nadi</td>
					<td><?php echo isset($modPemeriksaanFisik->detaknadi)?$modPemeriksaanFisik->detaknadi:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>b. Pernafasan</td>
					<td><?php echo isset($modPemeriksaanFisik->pernapasan)?$modPemeriksaanFisik->pernapasan:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>c. Tekanan Darah</td>
					<td><?php echo isset($modPemeriksaanFisik->tekanandarah)?$modPemeriksaanFisik->tekanandarah:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>d. Suhu Tubuh</td>
					<td><?php echo isset($modPemeriksaanFisik->suhutubuh)?$modPemeriksaanFisik->suhutubuh:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Status Gizi</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>a. Tinggi Badan</td>
					<td><?php echo isset($modPemeriksaanFisik->tinggibadan_cm)?$modPemeriksaanFisik->tinggibadan_cm:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>b. Berat Badan</td>
					<td><?php echo isset($modPemeriksaanFisik->beratbadan_kg)?$modPemeriksaanFisik->beratbadan_kg:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>c. Lingkar Perut</td>
					<td><?php echo isset($modPemeriksaanFisik->lingkarperut_cm)?$modPemeriksaanFisik->lingkarperut_cm:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>d. BMI</td>
					<td><?php echo isset($modPemeriksaanFisik->bb_ideal)?$modPemeriksaanFisik->bb_ideal:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>e. Bentuk Badan</td>
					<td><?php echo isset($modPemeriksaanFisik->bentukbadan)?$modPemeriksaanFisik->bentukbadan:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>d. Keadaan Umum</td>
					<td><?php echo isset($modPemeriksaanFisik->keadaanumum)?$modPemeriksaanFisik->keadaanumum:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>Mata</strong></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>a. Persepsi Warna</td>
					<td><?php echo isset($modPemeriksaanFisik->mata_persepsiwarna)?$modPemeriksaanFisik->mata_persepsiwarna:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>b. Visus</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak.$jarak; ?>OD</td>
					<td><?php echo isset($modPemeriksaanFisik->mata_visus_od)?$modPemeriksaanFisik->mata_visus_od:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak.$jarak; ?>OS</td>
					<td><?php echo isset($modPemeriksaanFisik->mata_visus_os)?$modPemeriksaanFisik->mata_visus_os:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak.$jarak; ?>Keterangan</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>c. Penglihatan Jauh</td>
					<td><?php echo isset($modPemeriksaanFisik->mata_penglihatanjauh)?$modPemeriksaanFisik->mata_penglihatanjauh:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $jarak; ?>d. Kelainan Mata Lainnya</td>
					<td><?php echo isset($modPemeriksaanFisik->mata_kelainan)?$modPemeriksaanFisik->mata_kelainan:' - ' ?></td>
					<td></td>
				</tr>
				<tr>
					<td><strong>THT</strong></td>
					<td></td>
					<td></td>
				</tr>
				<?php
				if(!empty($modRiwayatThtJenis)){
					foreach($modRiwayatThtJenis as $ktht => $vtht){
						echo "<tr>";
						echo "<td><b>".$vtht->jenis_tht."</b></td>";
						echo "<td></td>";
						echo "</tr>";
						foreach($modRiwayatThtJenis[$ktht]->THTByJenis as $ktht2 => $vtht2){
							echo "<tr>";
							echo "<td>".$jarak.$vtht2->bagian_tht."</td>";
							echo "<td>".$vtht2->status_bagiantht."</td>";
							echo "</tr>";
						}
					}
				}
				?>
			</table>
		</fieldset>
	</div>
</div>

<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->

<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="30%"></td>
		<td style="text-align: center; font-weight: bold;">HASIL PEMERIKSAAN GIGI</td>
		<td width="30%"></td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td width="15%" style="font-weight: bold;">Nama </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->nama_pasien; ?></td>
		<td width="15%" style="font-weight: bold;">Tanggal MCU </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Perusahaan </td>
		<td width="35%">: &nbsp; PT. Badak LNG</td>
		<td width="15%" style="font-weight: bold;">Kelamin </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Tanggal Lahir </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
		<td width="15%" style="font-weight: bold;">No. MR </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr><td colspan="4" style="border-top: 1px solid #000000"></td></tr>
</table>
<br><br><br><br><br><br>

<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->


<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="30%"></td>
		<td style="text-align: center; font-weight: bold;">HASIL PEMERIKSAAN LABORATORIUM</td>
		<td width="30%"></td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td width="15%" style="font-weight: bold;">Nama </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->nama_pasien; ?></td>
		<td width="15%" style="font-weight: bold;">Tanggal MCU </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Perusahaan </td>
		<td width="35%">: &nbsp; PT. Badak LNG</td>
		<td width="15%" style="font-weight: bold;">Kelamin </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Tanggal Lahir </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
		<td width="15%" style="font-weight: bold;">No. MR </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr><td colspan="4" style="border-top: 1px solid #000000"></td></tr>
</table>
<table width="100%" border="0" class="table table-striped table-bordered table-condensed">
	<tr>
		<th style="text-align: center;">PEMERIKSAAN</th>
		<th style="text-align: center;">HASIL</th>
		<th style="text-align: center;">RUJUKAN</th>
		<th style="text-align: center;">SATUAN</th>
		<th style="text-align: center;">KETERANGAN</th>
	</tr>
	<?php
	if(!empty($modDetailHasilPemeriksaanLabMCU)){
		foreach($modDetailHasilPemeriksaanLabMCU as $ii =>$vv){
			echo "<tr><td>".$vv->pemeriksaanlab->pemeriksaanlab_nama."</td>";
			echo "<td>".$vv->hasilpemeriksaan."</td>";
			echo "<td>".$vv->nilairujukan."</td>";
			echo "<td>".$vv->hasilpemeriksaan_satuan."</td>";
			echo "<td>".$vv->hasil_laboratorium."</td>";
			echo "</tr>";
		}
	}else{
		echo "<td colspan='6'><i>Data Pemeriksaan Lab Tidak Ditemukan...</i></td>";
	}
	?>
</table>


<div class="break"></div>
<!---------------------------------------- GANTI HALAMAN -------------------------------------------------------------------------------->


<?php echo $this->renderPartial('mcu.views.kesimpulanSaran._headerMcu'); ?>
<table width="100%">
	<tr>
		<td width="30%"></td>
		<td style="text-align: center; font-weight: bold;">HASIL PEMERIKSAAN RONTGEN THORAX</td>
		<td width="30%"></td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td width="15%" style="font-weight: bold;">Nama </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->nama_pasien; ?></td>
		<td width="15%" style="font-weight: bold;">Tanggal MCU </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Perusahaan </td>
		<td width="35%">: &nbsp; PT. Badak LNG</td>
		<td width="15%" style="font-weight: bold;">Kelamin </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td width="15%" style="font-weight: bold;">Tanggal Lahir </td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
		<td width="15%" style="font-weight: bold;">No. MR </td>
		<td width="35%">: &nbsp; <?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr><td colspan="4" style="border-top: 1px solid #000000"></td></tr>
</table>
<table width="100%">
	<tr>
		<td width="30%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000;"><strong>JENIS PEMERIKSAAN</strong></td>
		<td width="70%" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000;"><strong>HASIL</strong></td>
	</tr>
	<?php foreach($modHasilPemeriksaanRad as $krad => $vrad){ ?>
		<tr>
			<td><strong><?php echo $jarak.$vrad->pemeriksaanrad->pemeriksaanrad_nama; ?></strong></td>
			<td><?php echo !empty($vrad->hasilexpertise)?$vrad->hasilexpertise:' - '; ?></td>
		</tr>
	<?php } ?>
	<tr><td colspan="2" style="border-top: 1px solid #000000"></td></tr>
</table>

<br><br>