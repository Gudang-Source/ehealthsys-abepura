<?php
$this->breadcrumbs=array(
	'Pegawai'=>array('admin'),
	$model->nama_pegawai,
);

$this->menu=array(
array('label'=>'List PegawaiM','url'=>array('index')),
array('label'=>'Buat Baru PegawaiM','url'=>array('create')),
array('label'=>'Update PegawaiM','url'=>array('update','id'=>$model->pegawai_id)),
array('label'=>'Hapus PegawaiM','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pegawai_id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Kelola PegawaiM','url'=>array('admin')),
);
?>

<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-heading">
			<div class="panel-title">Detail Pegawai</div>
		</div>
		<div class="panel-body">
		`	<div class="panel panel-primary col-sm-12">
				<div class="panel-heading panel-heading2">
					<div class="panel-title">Data Pegawai</div>  
				</div>
				<div class="panel-body col-sm-9">
					<table class="table responsive">
						<tbody>
							<tr><th class="col-sm-4">NIP</th><td><?php echo $model->nomorindukpegawai; ?></td></tr>
							<tr><th>Nomor Kartu PNS</th><td><?php echo $model->no_kartupegawainegerisipil; ?></td></tr>
							<tr><th>No Identitas</th><td><?php echo $model->noidentitas." (".$model->jenisidentitas.")"; ?></td></tr>
							<tr><th>Nama Pegawai</th><td><?php echo $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang; ?></td></tr>
							<tr><th>Nama Keluarga</th><td><?php echo $model->nama_keluarga; ?></td></tr>
							<tr><th>Tempat / Tgl Lahir</th><td><?php echo $model->tempatlahir_pegawai.", ".date('d/m/Y', strtotime($model->tgl_lahirpegawai)); ?></td></tr>
							<tr><th>Jenis Kelamin</th><td><?php echo $model->jeniskelamin; ?></td></tr>
							<tr><th>Alamat</th><td><?php echo $model->alamat_pegawai; ?></td></tr>
							<tr><th>Kelurahan</th><td><?php echo empty($model->kelurahan)?'':$model->kelurahan->kelurahan_nama; ?></td></tr>
							<tr><th>Status Perkawinan</th><td><?php echo $model->statusperkawinan; ?></td></tr>
							<tr><th>Golongan Pegawai</th><td><?php echo empty($model->golonganpegawai)?'':$model->golonganpegawai->golonganpegawai_nama; ?></td></tr>
							<tr><th>Pangkat</th><td><?php echo empty($model->pangkat)?'':$model->pangkat->pangkat_nama; ?></td></tr>
							<tr><th>Jabatan</th><td><?php echo empty($model->jabatan)?'':$model->jabatan->jabatan_nama; ?></td></tr>
						</tbody>
					</table>
				</div>
				<div class="panel-body col-sm-3" style="float:right">
					<img src="<?php echo Params::urlPegawaiGambar().$model->photopegawai; ?>" width="100%">
				</div>
			</div>
			<div class="panel panel-primary col-sm-6">
				<div class="panel-heading panel-heading2">
					<div class="panel-title">Detail Pegawai</div>  
				</div>
				<div class="panel-body col-sm-12">
					<table class="table responsive">
						<tbody>
							<tr><th class="col-sm-4">Agama</th><td><?php echo $model->agama; ?></td></tr>
							<tr><th>Golongan Darah</th><td><?php echo $model->golongandarah." ".$model->rhesus; ?></td></tr>
							<tr><th>Email</th><td><?php echo $model->alamatemail; ?></td></tr>
							<tr><th>No Telp</th><td><?php echo $model->notelp_pegawai; ?></td></tr>
							<tr><th>No Mobile</th><td><?php echo $model->nomobile_pegawai; ?></td></tr>
							<tr><th>Jenis Waktu Kerja</th><td><?php echo $model->jeniswaktukerja; ?></td></tr>
							<tr><th>Tgl Mulai Kerja</th><td><?php echo MyFormatter::formatDateTimeId($model->tglmulaibekerja); ?></td></tr>
							<tr><th>Kategori Pegawai</th><td><?php echo $model->kategoripegawai; ?></td></tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel panel-primary col-sm-6">
				<div class="panel-heading panel-heading2">
					<div class="panel-title">Lain-Lain</div>  
				</div>
				<div class="panel-body col-sm-12">
					<table class="table responsive">
						<tbody>
							<tr><th class="col-sm-4">Bank</th><td><?php echo $model->banknorekening; ?></td></tr>
							<tr><th>No Rekening</th><td><?php echo $model->norekening; ?></td></tr>
							<tr><th>NPWP</th><td><?php echo $model->npwp; ?></td></tr>
							<tr><th>Gaji Pokok</th><td><?php echo $model->gajipokok; ?></td></tr>
							<tr><th>Insentif</th><td><?php echo $model->insentifpegawai; ?></td></tr>
						</tbody>
					</table>
				</div>
			</div>
		
			<?php /* $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'rowCssClass' => 'table',
'attributes'=>array(
		'pegawai_id',
		'golonganpegawai_id',
		'pangkat_id',
		'jabatan_id',
		'kelurahan_id',
		'nomorindukpegawai',
		'no_kartupegawainegerisipil',
		'jenisidentitas',
		'noidentitas',
		'gelardepan',
		'nama_pegawai',
		'nama_keluarga',
		'gelarbelakang',
		'tempatlahir_pegawai',
		'tgl_lahirpegawai',
		'jeniskelamin',
		'statusperkawinan',
		'alamat_pegawai',
		'agama',
		'golongandarah',
		'rhesus',
		'alamatemail',
		'notelp_pegawai',
		'nomobile_pegawai',
		'warganegara_pegawai',
		'jeniswaktukerja',
		'kategoripegawai',
		'photopegawai',
		'norekening',
		'banknorekening',
		'npwp',
		'tglmulaibekerja',
		'tglberhenti',
		'gajipokok',
		'insentifpegawai',
		'peg_create_time',
		'peg_update_time',
		'peg_create_login',
		'peg_update_login',
		'pegawai_aktif', 
),
)); */ ?>
		</div>
		<div class="panel-footer">
			<?php echo CHtml::link('Kembali',$this->createUrl('/keanggotaan/PegawaiM/admin'), array('class' => 'btn btn-link')); ?>
		</div>
	</div>
</div>