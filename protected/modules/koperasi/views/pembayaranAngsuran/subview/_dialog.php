<!-- Dialog Pegawai -->
<div class="modal fade custom-width" id="dialog_anggota">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Anggota</h4>
			</div>
			<div class="modal-body">
				<?php
					$anggota = new KeanggotaanV;
					if (isset($_GET['KeanggotaanV'])) {
						$anggota->attributes = $_GET['KeanggotaanV'];
					}
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->searchAnggotaPeminjam(),
					'filter'=>$anggota,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns'=>array(
						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPinjamanAjax("'.$data->no_pinjaman.'"); $("#dialog_anggota").modal("hide"); return false;'));
							},
						),
						'nokeanggotaan',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
						),

					/*	array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
						), */
						array(
							'header'=>'No Pinjaman',
							'type'=>'raw',
							'value'=>'$data->no_pinjaman',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Tgl Pinjaman',
							'type'=>'raw',
							'value'=>'date("d/m/Y", strtotime($data->tglpinjaman))',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Jumlah',
							'type'=>'raw',
							'value'=>'MyFormatter::formatNumberForPrint($data->jml_pinjaman)',
							'htmlOptions'=>array('style'=>'text-align: right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),/*
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'value'=>'empty($data->pegawai->golonganpegawai_id)?"-":$data->pegawai->golonganpegawai->golonganpegawai_nama',
							'filter'=>CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true','order'=>'golonganpegawai_nama asc')), 'golonganpegawai_id', 'golonganpegawai_nama'),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
							'value'=>'$data->alamat_pegawai',
						),
						//'pegawai.jeniskelamin',
						//'pegawai.alamat_pegawai',
						/*
						array(
							'name'=>'pegawain.kelurahan_id',
							'value'=>'empty($data->kelurahan_id)?"-":$data->pegawai->kelurahan->kelurahan_nama',
							'filter'=>false,
						), */
						//'pegawai.unit.unit_nama',
						//'pegawai.golonganpegawai.golonganpegawai_nama',

					)));

				?>
			</div>
		</div>
	</div>
</div>

<!-- Dialog pengurus koperasi -->
<div class="modal fade custom-width" id="dialog_pegawai">
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Pegawai Koperasi</h4>
			</div>
			<div class="modal-body">
				<?php
					echo CHtml::hiddenField('target_attr', null);
					$pegawai = new PegawaiM;
					if (isset($_GET['PegawaiM'])) $pegawai->attributes = $_GET['PegawaiM'];
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'pegawai-pengurus-m-grid',
					'dataProvider'=>$pegawai->searchPengurus(),
					'filter'=>$pegawai,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns'=>array(
						array(
							'header'=>'Pilih',
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pegawai").modal("hide"); return false;'));
							},
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
						),
						'nomorindukpegawai',
						//'no_kartupegawainegerisipil',
						//'pegawai_id',
						//'noidentitas',
						array(
							'header'=>'Nama Pegawai',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
							),
						array(
							'header'=>'Jabatan',
							'type'=>'raw',
							'value'=>'empty($data->jabatan_id)?"-":$data->jabatan->jabatan_nama',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Pangkat',
							'type'=>'raw',
							'value'=>'empty($data->pangkat_id)?"-":$data->pangkat->pangkat_nama',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Golongan',
							'type'=>'raw',
							'value'=>'empty($data->golonganpegawai_id)?"-":$data->golonganpegawai->golonganpegawai_nama',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
							'nomobile_pegawai',
							'alamatemail',
						),
					));

				?>
			</div>
		</div>
	</div>
</div>
