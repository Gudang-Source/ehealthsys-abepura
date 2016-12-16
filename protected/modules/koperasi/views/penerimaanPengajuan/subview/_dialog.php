<!-- Dialog pengurus koperasi -->
<div class="modal fade custom-width" id="dialog_permintaan">
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Pengajuan</h4>
			</div>
			<div class="modal-body">
				<?php
					echo CHtml::hiddenField('target_attr', null);
					$permintaan = new InfopengajuanpemotonganV;
					if (isset($_GET['InfopengajuanpemotonganV'])) $permintaan->attributes = $_GET['InfopengajuanpemotonganV'];
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'pegawai-pengurus-m-grid',
					'dataProvider'=>$permintaan->searchNoPermintaan(),
					'filter'=>$permintaan,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns'=>array(
						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'$("#PengajuanpenerimaanangsuranV_nopengajuan").val("'.$data->nopengajuan.'"); ubahTeksBKM("'.$data->nopengajuan.'","'.date("d/m/Y", strtotime($data->tglpengajuanpemb)).'"); $("#dialog_permintaan").modal("hide"); $("#PengajuanpenerimaanangsuranV_potongansumber_id").val("'.$data->potongansumber_id.'"); return false;'));
							},
						),
						array(
							'name'=>'tglpengajuanpemb',
							'filter'=>false,
						),
						'nopengajuan',
						array(
							'header'=>'Dibuat',
							'type'=>'raw',
							'value'=>function($data) {
								$buat = PegawaiM::model()->findByPk($data->dibuatoleh_id_pengpemb);
								if (empty($ubat)) return '-';
								return $buat->nama_pegawai;
							},
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Diperiksa',
							'type'=>'raw',
							'value'=>function($data) {
								$buat = PegawaiM::model()->findByPk($data->diperiksaoleh_id_pengpemb);
								return empty($buat)?'-':$buat->nama_pegawai;
							},
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Disetujui',
							'type'=>'raw',
							'value'=>function($data) {
								$buat = PegawaiM::model()->findByPk($data->disetujuioleh_id_pengpemb);
								return empty($buat)?'-':$buat->nama_pegawai;
							},
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
					/*
						array(
							'type'=>'raw',
							'value'=>function($data) {
								return ''; //CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pegawai_pengurus").modal("hide"); return false;'));
							},
						),
						'nomorindukpegawai',
						'no_kartupegawainegerisipil',
						//'pegawai_id',
						//'noidentitas',
						array(
							'header'=>'Gelar Depan',
							'type'=>'raw',
							'name'=>'gelardepan',
							'value'=>'$data->gelardepan',
						),
						array(
							'header'=>'Nama Pegawai',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->nama_pegawai',
						),
						array(
							'header'=>'Gelar Belakang',
							'type'=>'raw',
							'name'=>'gelarbelakang',
							'value'=>'$data->gelarbelakang',
						),
						array(
							'header'=>'Jabatan',
							'type'=>'raw',
							'value'=>function($data) {
								return empty($data->jabatan_id)?'-':$data->jabatan->jabatan_nama;
							},
						), */
					),
				));

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
					'id'=>'pegawai-m-grid',
					'dataProvider'=>$pegawai->searchPengurus(),
					'filter'=>$pegawai,
					'itemsCssClass' => 'table-bordered datatable dataTable',
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
