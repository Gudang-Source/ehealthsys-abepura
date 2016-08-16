<div class="white-container">
    <legend class="rim2">Lihat <b>Pelamar <?php echo $model->nama_pelamar ?></b></legend>
    <fieldset class='box well row-fluid'>
        <legend class="rim">Data Pelamar</legend>
		<table width="100%" class="table table-striped table-bordered table-condensed">
			<tbody>
			<tr>
				<td width="13%"><b>Tanggal Lowongan</b></td>
				<td width="20%"><?php echo !empty($model->tgllowongan)?  MyFormatter::formatDateTimeId($model->tgllowongan):' - '; ?></td>
				<td width="13%"><b>Kode Pos</b></td>
				<td width="20%"><?php echo !empty($model->kodepos)?$model->kodepos:' - '; ?></td>
				<td width="13%"><b>Photo</b></td>
				<td width="20%" rowspan="6">
					<?php
					if(!empty($model->photopegawai)){
						echo CHtml::image(Params::urlPegawaiTumbsDirectory().'kecil_'.$model->photopegawai, 'photo pasien', array('id'=>'photo_pasien','width'=>150));
					} else {
						echo CHtml::image(Params::urlPegawaiTumbsDirectory().'no_photo.jpeg', 'photo pasien', array('id'=>'photo_pasien','width'=>150));
					}
					?>
				</td>
				
			</tr>
			<tr>
				<td width="13%"><b>No. Identitas</b></td>
				<td width="20%"><?php echo !empty($model->noidentitas)?$model->noidentitas:' - '; ?>
								<?php echo !empty($model->jenisidentitas)? "(".$model->jenisidentitas.")":' - '; ?></td>
				<td width="13%"><b>No. Telepon</b></td>
				<td width="20%"><?php echo !empty($model->notelp_pelamar)?$model->notelp_pelamar:' - '; ?> / 
								<?php echo !empty($model->nomobile_pelamar)?$model->nomobile_pelamar:' - '; ?></td>
			</tr>
			<tr>
				<td width="13%"><b>Nama Pelamar</b></td>
				<td width="20%"><?php echo !empty($model->nama_pelamar)?$model->nama_pelamar:' - '; ?></td>
				<td width="13%"><b>E-mail</b></td>
				<td width="20%"><?php echo !empty($model->alamatemail)?$model->alamatemail:' - '; ?></td>
				
			</tr>
			<tr>
				<td width="13%"><b>Nama Keluarga</b></td>
				<td width="20%"><?php echo !empty($model->nama_keluarga)?$model->nama_keluarga:' - '; ?></td>
				<td width="13%"><b>Pendidikan</b></td>
				<td width="20%"><?php echo !empty($model->pendidikan_id)?$model->pendidikan->pendidikan_nama:' - '; ?></td>
			</tr>
			<tr>
				<td width="13%"><b>Jenis Kelamin</b></td>
				<td width="20%"><?php echo !empty($model->jeniskelamin)?$model->jeniskelamin:' - '; ?></td>
				<td width="13%"><b>Pendidikan Kualifikasi</b></td>
				<td width="20%"><?php echo !empty($model->pendkualifikasi_id)?$model->pendkualifikasi->pendkualifikasi_nama:' - '; ?></td>
			</tr>
			<tr>
				<td width="13%"><b>Agama</b></td>
				<td width="20%"><?php echo !empty($model->agama)?$model->agama:' - '; ?></td>
				<td width="13%"><b>Minat Pekerjaan</b></td>
				<td width="20%"><?php echo !empty($model->minatpekerjaan)?$model->minatpekerjaan:' - '; ?></td>
			</tr>
			<tr>
				<td width="13%"><b>Tempat Lahir</b></td>
				<td width="20%"><?php echo !empty($model->tempatlahir_pelamar)?$model->tempatlahir_pelamar:' - '; ?></td>
				<td width="13%"><b>Warga Negara</b></td>
				<td width="20%"><?php echo !empty($model->warganegara_pelamar)?$model->warganegara_pelamar:' - '; ?></td>
				<td width="13%"><b>Rumah Sakit</b></td>
				<td width="20%"><?php echo !empty($model->profilrs_id)?$model->profilrs->nama_rumahsakit:' - '; ?></td>
			</tr>
			<tr>
				<td width="13%"><b>Tanggal Lahir</b></td>
				<td width="20%"><?php echo !empty($model->tgl_lahirpelamar)?MyFormatter::formatDateTimeId($model->tgl_lahirpelamar):' - '; ?></td>
				<td width="13%"><b>Suku</b></td>
				<td width="20%"><?php echo !empty($model->suku_id)?$model->suku->suku_nama:' - '; ?></td>
				<td width="13%"><b>Keterangan Pelamar</b></td>
				<td width="20%"><?php echo !empty($model->keterangan_pelamar)?$model->keterangan_pelamar:' - '; ?></td>
			</tr>
			<tr>
				<td width="13%"><b>Status Perkawinan</b></td>
				<td width="20%"><?php echo !empty($model->statusperkawinan)?$model->statusperkawinan:' - '; ?></td>
				<td width="13%"><b>Gaji yang diharapkan</b></td>
				<td width="20%"><?php echo !empty($model->gajiygdiharapkan)?MyFormatter::formatUang($model->gajiygdiharapkan):' - '; ?></td>
				<td width="13%"><b></b></td>
				<td width="20%"></td>
			</tr>
			<tr>
				<td width="13%"><b>Jumlah Anak</b></td>
				<td width="20%"><?php echo !empty($model->jmlanak)?$model->jmlanak:' - '; ?></td>
				<td width="13%"><b>Tanggal mulai bekerja</b></td>
				<td width="20%"><?php echo !empty($model->tglmulaibekerja)?MyFormatter::formatDateTimeId($model->tglmulaibekerja):' - '; ?></td>
				<td width="13%"><b></b></td>
				<td width="20%"></td>
			</tr>
			<tr>
				<td width="13%"><b>Alamat</b></td>
				<td width="20%"><?php echo !empty($model->alamat_pelamar)?$model->alamat_pelamar:' - '; ?></td>
				<td width="13%"><b>Tunjangan yang diinginkan</b></td>
				<td width="20%"><?php echo !empty($model->ingintunjangan)?$model->ingintunjangan:' - '; ?></td>
				<td width="13%"><b></b></td>
				<td width="20%"></td>
			</tr>
			</tbody>
		</table>
    </fieldset>
	
    <div class='block-tabel well'>
        <h6>Kemampuan / <b>Skill</b></h6>
            <table width="100%" class="table table-striped table-bordered table-condensed">
                    <thead>
            <th>No</th>
            <th>Nama Kemampuan</th>
            <th>Tingkat Kemampuan</th>
        </thead>
                    <tbody>
                            <?php
                            if(count($modKemampuanPelamars)>0){
                            foreach ($modKemampuanPelamars as $i => $modKemampuanPelamar) { ?>
                            <tr>
                                    <td><?php echo $i+1; ?></td>
                                    <td><?php echo $modKemampuanPelamar->kemampuan_nama; ?></td>
                                    <td><?php echo $modKemampuanPelamar->kemampuan_tingkat; ?></td>
                            </tr>
                            <?php }
                            } ?>
                    </tbody>
            </table>
    </div>
    <div class='block-tabel well'>
        <h6>Kemampuan <b>Bahasa</b></h6>
            <table width="100%" class="table table-striped table-bordered table-condensed">
                    <thead>
            <th>No</th>
            <th>Bahasa</th>
            <th>Mengerti</th>
            <th>Berbicara</th>
            <th>Menulis</th>
        </thead>
                    <tbody>
                            <?php
                            if(count($modBahasas)>0){
                            foreach ($modBahasas as $i => $modBahasa) { ?>
                            <tr>
                                    <td><?php echo $i+1; ?></td>
                                    <td><?php echo $modBahasa->bahasa; ?></td>
                                    <td><?php echo $modBahasa->mengerti; ?></td>
                                    <td><?php echo $modBahasa->berbicara; ?></td>
                                    <td><?php echo $modBahasa->menulis; ?></td>
                            </tr>
                            <?php }
                            } ?>
                    </tbody>
            </table>
    </div>
    <div class='block-tabel well'>
        <h6>Lingkungan <b>Kerja</b></h6>
            <table width="100%" class="table table-striped table-bordered table-condensed">
                    <thead>
            <th>No</th>
            <th>Dengan Lingkungan</th>
            <th>Keterangan</th>
        </thead>
                    <tbody>
                            <?php
                            if(count($modLingkunganKerjas)>0){
                            foreach ($modLingkunganKerjas as $i => $modLingkunganKerja) { ?>
                            <tr>
                                    <td><?php echo $i+1; ?></td>
                                    <td><?php echo $modLingkunganKerja->dgnlingkungan; ?></td>
                                    <td><?php echo $modLingkunganKerja->keterangan; ?></td>
                            </tr>
                            <?php }
                            } ?>
                    </tbody>
            </table>
    </div>
<?php //$this->widget('UserTips',array('type'=>'view'));?>
</div>