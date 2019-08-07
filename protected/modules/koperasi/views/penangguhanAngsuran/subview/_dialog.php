<!-- Dialog Pegawai -->
<div class="modal fade custom-width" id="dialog_pemohon">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Anggota</h4>
			</div>
			<div class="modal-body">
				<?php 
					$anggota = new InformasipermohonanpinjamanV;
					if (isset($_GET['InformasipermohonanpinjamanV'])) {
						$anggota->attributes = $_GET['InformasipermohonanpinjamanV'];
					}
					$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->searchPemohonApproved(),
					'filter'=>$anggota,
					'itemsCssClass' => 'table-bordered datatable dataTable',
					'columns'=>array(
						
						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPemohonAjax("'.$data->nokeanggotaan.'"); $("#dialog_pemohon").modal("hide"); return false;'));
							},
						),
						'tglpermohonanpinjaman',
						array(
							'name'=>'nokeanggotaan',
							'header'=>'Nomor Anggota',
						),
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
						),
						array(
							'header'=>'Tempat Lahir',
							'name'=>'tempatlahir_pegawai',
						),
						// 'pegawai.tempatlahir_pegawai',
						array(
							'header'=>'Tanggal Lahir',
							'name'=>'tgl_lahirpegawai',
							'filter'=>false,
							'type'=>'raw',
							'value'=>'date("d/m/Y", strtotime($data->tgl_lahirpegawai))',
						),
						array(
							'header'=>'Jenis Kelamin',
							'name'=>'jeniskelamin',
							'filter'=>Params::getJenisKelamin(),
						),
						array(
							'name'=>'jenispinjaman_permohonan',
							'filter'=>Params::jenisPinjaman(),
							),
						array(
							'name'=>'jmlpinjaman',
							'value'=>'MyFormatter::formatNumberForPrint($data->jmlpinjaman)',
							'htmlOptions'=>array('style'=>'text-align:right;'),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
						),
						array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'$data->namaunit',
							'filter'=>CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true','order'=>'namaunit asc')), 'unit_id', 'namaunit'),
						),
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'value'=>'$data->golonganpegawai_nama',
							'filter'=>CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true','order'=>'golonganpegawai_nama asc')), 'golonganpegawai_id', 'golonganpegawai_nama'),
						),
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
				<h4 class="modal-title">Data Pegawai</h4>
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
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pegawai").modal("hide"); return false;'));
							},
						),
						'nomorindukpegawai',
						'no_kartupegawainegerisipil',
						//'pegawai_id',
						'noidentitas',
						array(
							'header'=>'Nama Pegawai',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
						)
						),
					)); 
				
				?>
			</div>
		</div>
	</div>
</div>