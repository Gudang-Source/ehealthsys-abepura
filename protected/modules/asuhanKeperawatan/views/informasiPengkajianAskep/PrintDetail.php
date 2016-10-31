<style>
	.spasi1 {
		margin: 0px 0px 0px 10px;
	}

	.spasi2 {
		padding: 0px 0px 0px 20px;
	}
        
       
        .border th, .border td{
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
            padding:0px;
            border-spacing: 0px;

        }

        .table tbody tr:hover td, .table tbody tr:hover th {
            background-color: none;
        }
           
</style>

<table style="width:100%;">
	<tr>
		<td style="text-align:center;" align="center"><b>PENGKAJIAN KEPERAWATAN</b></td>
	</tr>
</table>
<br/>
<table width="100%">
        <tr>
                <td ><p><b>No. Pengkajian</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->no_pengkajian) ? $modPengkajian->no_pengkajian : "-"; ?></p></td>
                <td ><p><b>Tanggal Pengkajian</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->pengkajianaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modPengkajian->pengkajianaskep_tgl) : "-"; ?></p></td>
                <td ><p><b>Nama Perawat</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->nama_pegawai) ? $modPengkajian->nama_pegawai : "-"; ?></p></td>
        </tr>
</table>
<br/>
<table width="100%" class = "border table">
        <tr>
            <td colspan="6" style="text-align:left;"><b style="font-size:15px;">Data Pasien</b></td>
        </tr>
        <tr>
            <td ><p><b>No. Pendaftaran</b></p></td>
            <td ><p>: <?php echo isset($modPengkajian->no_pendaftaran) ? $modPengkajian->no_pendaftaran : "-"; ?></p></td>
            <td ><p><b>Jenis Kelamin</b></p></td>
            <td ><p>: <?php echo isset($modPengkajian->jeniskelamin) ? $modPengkajian->jeniskelamin : "-"; ?></p></td>
            <td ><p><b>Ruangan</b></p></td>
            <td ><p>: <?php echo isset($modPengkajian->ruangan_nama) ? $modPengkajian->ruangan_nama : "-" ?></p></td>
        </tr>
        <tr>
                <td ><p><b>Tanggal Pendaftaran</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->tgl_pendaftaran) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgl_pendaftaran) : "-"; ?></p></td>
                <td ><p><b>Pekerjaan</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->pekerjaan_nama) ? $modPengkajian->pekerjaan_nama : "-"; ?></p></td>
                <td ><p><b>Kelas</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->kelaspelayanan_nama) ? $modPengkajian->kelaspelayanan_nama : "-" ?></p></td>
        </tr>
        <tr>
                <td ><p><b>No. Rekam Medik</b></p></td>
                <td ><p><?php echo isset($modPengkajian->no_rekam_medik) ? $modPengkajian->no_rekam_medik : "-"; ?></p></td>
                <td ><p><b>Pendidikan</b></p></td>
                <td ><p><?php echo isset($modPengkajian->pendidikan_nama) ? $modPengkajian->pendidikan_nama : "-"; ?></p></td>
                <td ><p><b>No Kamar / No Bed</b></p></td>
                <td ><p><?php echo isset($modPengkajian->kamarruangan_nokamar) ? $modPengkajian->kamarruangan_nokamar : "-" . ' / ' . isset($modPengkajian->kamarruangan_nobed) ? $modPengkajian->kamarruangan_nobed : "-" ?></p></td>
        </tr>
        <tr>
                <td ><p><b>Nama Pasien</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->nama_pasien) ? $modPengkajian->nama_pasien : "-"; ?></p></td>
                <td ><p><b>Agama</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->agama) ? $modPengkajian->agama : "-"; ?></p></td>
                <td ><p><b>Diagnosa Medik Masuk</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->diagnosa_nama) ? $modPengkajian->diagnosa_nama : "-" ?></p></td>
        </tr>
        <tr>
                <td ><p><b>Umur</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->umur) ? $modPengkajian->umur : "-"; ?></p></td>
                <td ><p><b>Alamat</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->alamat_pasien) ? $modPengkajian->alamat_pasien : "-"; ?></p></td>
                <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
                <td ><p><b>Status Perkawinan</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->statusperkawinan) ? $modPengkajian->statusperkawinan : "-"; ?></p></td>
                <td colspan="4">&nbsp;</td>
        </tr>
</table>
<br/>					
<table width="100%"  class = "border table">
        <tr>
            <td colspan="6" style = "text-align:left;"><b style="font-size:15px;">Data Penanggung Jawab</b></td>
        </tr>
        <tr>
                <td ><p><b>Nama</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->nama_pj) ? $modPengkajian->nama_pj : "-"; ?></p></td>
                <td ><p><b>Tanggal Lahir</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->tgllahir_pj) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgllahir_pj) : "-"; ?></p></td>
                <td ><p><b>Hubungan Dengan Klien</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->hubungankeluarga) ? $modPengkajian->hubungankeluarga : "-" ?></p></td>
        </tr>
        <tr>
                <td ><p><b>No Identitas</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->no_identitas) ? $modPengkajian->no_identitas : "-"; ?></p></td>
                <td ><p><b>No Telepon</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->no_teleponpj) ? $modPengkajian->no_teleponpj : "-"; ?></p></td>
                <td ><p><b>Alamat</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->alamat_pj) ? $modPengkajian->alamat_pj : "-" ?></p></td>
        </tr>
        <tr>
                <td ><p><b>Jenis Kelamin</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->jk) ? $modPengkajian->jk : "-"; ?></p></td>
                <td ><p><b>No Mobile</b></p></td>
                <td ><p>: <?php echo isset($modPengkajian->no_mobilepj) ? $modPengkajian->no_mobilepj : "-"; ?></p></td>
                <td colspan="2">&nbsp;</td>
        </tr>
</table>
<br/>
<?php 
	echo '<p style="text-align:left;"><strong>Data Anamnesa</strong></p>';
?>	
<?php 
	echo '<p style="text-align:center;"><strong>RIWAYAT ANAMNESA</strong></p>';
?>	

<br/>		
<?php $this->renderPartial('_detailAnamnesis', array('modAnamnesa' => $modAnamnesa)); ?>
<br/>		
<?php 
	echo '<p style="text-align:left;"><strong>Data Pemeriksaan Fisik</strong></p>';
?>
<?php 
	echo '<p style="text-align:center;"><strong>PERIKSA FISIK</strong></p>';
?>
			<?php
			$this->renderPartial('_detailFisik', array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'modPemeriksaanGambar' => $modPemeriksaanGambar,
				'modGambarTubuh' => $modGambarTubuh,
				'modBagianTubuh' => $modBagianTubuh,));
			?>
		
<br/>
<?php 
	echo '<p style="text-align:left;"><strong>Data Penunjang</strong></p>';
?>
				<?php
				$this->widget('ext.bootstrap.widgets.BootGridView', array(
					'id' => 'penunjang-grid',
					'enableSorting' => false,
					'template' => "{items}",
					'dataProvider' => $modPenunjang,
					'itemsCssClass' => 'table border',
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
			
	