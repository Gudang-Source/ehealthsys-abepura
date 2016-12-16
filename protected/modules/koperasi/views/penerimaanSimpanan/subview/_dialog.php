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
					$anggota = new SPKeanggotaanT;
					if (isset($_GET['SPKeanggotaanT'])) {
						$anggota->attributes = $_GET['SPKeanggotaanT'];
						$anggota->nomorindukpegawai = $_GET['SPKeanggotaanT']['nomorindukpegawai'];
						$anggota->no_kartupegawainegerisipil = $_GET['SPKeanggotaanT']['no_kartupegawainegerisipil'];
						$anggota->nama_pegawai = $_GET['SPKeanggotaanT']['nama_pegawai'];
						$anggota->noidentitas = $_GET['SPKeanggotaanT']['noidentitas'];
						$anggota->tempatlahir_pegawai = $_GET['SPKeanggotaanT']['tempatlahir_pegawai'];
						//$anggota->tgl_lahirpegawai = $_GET['SPKeanggotaanT']['tgl_lahirpegawai'];
						$anggota->jeniskelamin = $_GET['SPKeanggotaanT']['jeniskelamin'];
						$anggota->alamat_pegawai = $_GET['SPKeanggotaanT']['alamat_pegawai'];
						$anggota->unit_id = $_GET['SPKeanggotaanT']['unit_id'];
						$anggota->golonganpegawai_id = $_GET['SPKeanggotaanT']['golonganpegawai_id'];
					}
					$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->searchAnggota(),
					'filter'=>$anggota,
					'itemsCssClass' => 'table-bordered datatable dataTable',
					'columns'=>array(
						
						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadAnggotaAjax("'.$data->nokeanggotaan.'"); $("#dialog_anggota").modal("hide"); return false;'));
							},
						),
						'nokeanggotaan',
						array (
							'header'=>'NIP',
							'name'=>'nomorindukpegawai',
							'value'=>'$data->pegawai->nomorindukpegawai',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'No Kartu PNS',
							'name'=>'no_kartupegawainegerisipil',
							'value'=>'$data->pegawai->no_kartupegawainegerisipil',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						/*array(
							'header'=>'No Identitas',
							'name'=>'noidentitas',
							'value'=>'$data->pegawai->noidentitas',
						),*/
						//'pegawai.nomorindukpegawai',
						//'pegawai.no_kartupegawainegerisipil',
						//'pegawai_id',
						//'pegawai.noidentitas',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->pegawai->gelardepan." ".$data->pegawai->nama_pegawai." ".$data->pegawai->gelarbelakang',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Tempat Lahir',
							'name'=>'tempatlahir_pegawai',
							'value'=>'$data->pegawai->tempatlahir_pegawai',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						// 'pegawai.tempatlahir_pegawai',
						array(
							'header'=>'Tanggal Lahir',
							'name'=>'tgl_lahirpegawai',
							'filter'=>false,
							'type'=>'raw',
							'value'=>'date("d/m/Y", strtotime($data->pegawai->tgl_lahirpegawai))',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Jenis Kelamin',
							'name'=>'jeniskelamin',
							'value'=>'$data->pegawai->jeniskelamin',
							'filter'=>Params::getJenisKelamin(),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
							'value'=>'$data->pegawai->alamat_pegawai',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'empty($data->pegawai->unit_id)?"-":$data->pegawai->unit->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'value'=>'empty($data->pegawai->golonganpegawai_id)?"-":$data->pegawai->golonganpegawai->golonganpegawai_nama',
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
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
						),
						
					)); 
				
				?>
			</div>
		</div>
	</div>
</div>


<!-- Dialog pengurus koperasi -->
<div class="modal fade custom-width" id="dialog_pegawai_pengurus">
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
					$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'pegawai-pengurus-m-grid',
					'dataProvider'=>$pegawai->searchPengurus(),
					'filter'=>$pegawai,
					'itemsCssClass' => 'table-bordered datatable dataTable',
					'columns'=>array(
						array(
							'header'=>'Pilih',
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pegawai_pengurus").modal("hide"); return false;'));
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
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
							),
						array(
							'header'=>'Jabatan',
							'type'=>'raw',
							'value'=>'!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Pangkat',
							'type'=>'raw',
							'value'=>'!empty($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Golongan',
							'type'=>'raw',
							'value'=>'$!empty($data->golonganpegawai_id)?$data->golonganpegawai->golonganpegawai_nama:"-"',
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


